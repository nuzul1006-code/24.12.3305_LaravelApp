<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventTicketMail;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId    = 'TRX-' . time() . '-' . Str::random(5);
        
        // Tentukan total harga: jika harga event 0, total harga 0. Jika berbayar, tambah biaya layanan.
        $totalPrice = $event->price == 0 ? 0 : ($event->price + 5000);

        // ==========================================
        // PERCABANGAN: JIKA EVENT GRATIS (TOTAL = 0)
        // ==========================================
        if ($totalPrice == 0) {
            $transaction = Transaction::create([
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price'    => 0,
                'status'         => 'success', // Langsung sukses/paid
            ]);

            // Kurangi stok tiket
            if ($event->stock > 0) {
                $event->stock = $event->stock - 1;
                $event->save();

                // Kirim email E-Ticket
                try {
                    Mail::to($transaction->customer_email)
                        ->send(new EventTicketMail($transaction));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email E-Ticket (Free Event): ' . $e->getMessage());
                }
            }

            // Langsung arahkan ke halaman sukses
            return redirect()->route('checkout.success', $transaction->order_id);
        }

        // ==========================================
        // ALUR BERBAYAR (MIDTRANS - TETAP SEPERTI SEMULA)
        // ==========================================
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
        ]);

        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function payment(string $order_id)
    {
        $categories  = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success(string $order_id)
    {
        $categories  = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Jika transaksi dari awal berstatus success (untuk event gratis), lewati pengecekan Midtrans
        if (strtolower($transaction->status) === 'success') {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        try {
            $status     = \Midtrans\Transaction::status($order_id);
            $trx_status = is_array($status)
                ? ($status['transaction_status'] ?? '')
                : ($status->transaction_status ?? '');

            if (in_array($trx_status, ['settlement', 'capture'])) {
                if (strtolower($transaction->status) === 'pending') {
                    $transaction->update(['status' => 'success']);

                    if ($transaction->event && $transaction->event->stock > 0) {
                        $transaction->event->stock = $transaction->event->stock - 1;
                        $transaction->event->save();

                        // Kirim email E-Ticket
                        try {
                            Mail::to($transaction->customer_email)
                                ->send(new EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            Log::error('Gagal kirim email Fallback: ' . $e->getMessage());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika transaksi tidak ditemukan di midtrans tapi status lokal sudah success, biarkan lolos ke view sukses
            if (strtolower($transaction->status) !== 'success') {
                return redirect()->route('home')
                    ->with('error', 'Transaksi tidak ditemukan atau gagal diproses.');
            }
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}