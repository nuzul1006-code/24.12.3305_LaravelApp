<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Halaman detail event (sisi user)
    public function show(Event $event)
    {
        $event->load(['category', 'partner', 'reviews.user']);
        
        $averageRating = $event->reviews()->avg('rating') ?: 0;
        $totalReviews = $event->reviews()->count();

        // Rating keseluruhan partner (gabungan semua event miliknya), dipakai di kartu "Penyelenggara"
        $partnerAvgRating = 0;
        $partnerTotalReviews = 0;
        if ($event->partner) {
            $partnerAvgRating = $event->partner->reviews()->avg('rating') ?: 0;
            $partnerTotalReviews = $event->partner->reviews()->count();
        }

        return view('event-detail', compact('event', 'averageRating', 'totalReviews', 'partnerAvgRating', 'partnerTotalReviews'));
    }

    // Halaman checkout
    public function checkout(Event $event)
    {
        return view('checkout', compact('event'));
    }

    // Halaman tiket (List Tiket)
    public function ticket(Request $request)
    {
        $categories = \App\Models\Category::all();
        $transactions = collect();
        $searched = false;
        
        $email = $request->input('email');
        $order_id = $request->input('order_id');

        if (auth()->check()) {
            $transactions = \App\Models\Transaction::with(['event.partner', 'review'])
                ->where('customer_email', auth()->user()->email)
                ->latest()
                ->get();
            $searched = true;
        } elseif ($email && $order_id) {
            $transactions = \App\Models\Transaction::with(['event.partner', 'review'])
                ->where('customer_email', $email)
                ->where('order_id', $order_id)
                ->get();
            $searched = true;
        }

        return view('ticket-list', compact('transactions', 'categories', 'searched', 'email', 'order_id'));
    }

    // Detail E-Ticket
    public function showTicketDetail(string $order_id)
    {
        $transaction = \App\Models\Transaction::with('event.partner')->where('order_id', $order_id)->firstOrFail();
        return view('ticket', compact('transaction'));
    }
}