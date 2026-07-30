<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{
    // Tampilkan form ulasan
    public function create(Request $request, $order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event.partner')->where('order_id', $order_id)->firstOrFail();

        // 1. Pastikan transaksi sukses
        if (strtolower($transaction->status) !== 'success') {
            return redirect()->route('ticket')->with('error', 'Ulasan hanya dapat diberikan untuk transaksi yang sukses.');
        }

        // 2. Pastikan sudah lewat 1 hari setelah acara selesai
        $eventDate = Carbon::parse($transaction->event->date);
        if ($eventDate->copy()->addDay() > now()) {
            return redirect()->route('ticket')->with('error', 'Ulasan baru bisa diberikan minimal 1 hari setelah acara selesai.');
        }

        // 3. Pastikan belum pernah mengisi ulasan untuk transaksi ini
        if ($transaction->review()->exists()) {
            return redirect()->route('ticket')->with('error', 'Anda sudah memberikan ulasan untuk tiket ini.');
        }

        return view('reviews.create', compact('transaction', 'categories'));
    }

    // Simpan ulasan
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating'         => 'required|integer|between:1,5',
            'review'         => 'required|string|min:5|max:1000',
        ]);

        $transaction = Transaction::with('event')->findOrFail($request->transaction_id);

        // Validasi ulang di sisi backend untuk keamanan
        if (strtolower($transaction->status) !== 'success') {
            return redirect()->route('ticket')->with('error', 'Transaksi belum sukses.');
        }

        $eventDate = Carbon::parse($transaction->event->date);
        if ($eventDate->copy()->addDay() > now()) {
            return redirect()->route('ticket')->with('error', 'Acara belum selesai.');
        }

        if ($transaction->review()->exists()) {
            return redirect()->route('ticket')->with('error', 'Ulasan untuk transaksi ini sudah ada.');
        }

        Review::create([
            'event_id'       => $transaction->event_id,
            'transaction_id' => $transaction->id,
            'user_id'        => auth()->id(), // null jika checkout guest
            'rating'         => $request->rating,
            'review'         => $request->review,
            'customer_name'  => $transaction->customer_name,
        ]);

        return redirect()->route('ticket')->with('success', 'Terima kasih! Ulasan dan rating Anda berhasil disimpan.');
    }
}
