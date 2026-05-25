<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    // Halaman detail event (sisi user)
    public function show(Event $event)
    {
        return view('event-detail', compact('event'));
    }

    // Halaman checkout
    public function checkout(Event $event)
    {
        return view('checkout', compact('event'));
    }

    // Halaman tiket
    public function ticket()
    {
        return view('ticket');
    }
}