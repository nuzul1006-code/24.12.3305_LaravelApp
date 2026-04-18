<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    // Halaman detail event (sisi user)
    public function show()
    {
        return view('event-detail');
    }

    // Halaman checkout
    public function checkout()
    {
        return view('checkout');
    }

    // Halaman tiket
    public function ticket()
    {
        return view('ticket');
    }

    // Halaman events untuk admin
    public function indexAdmin()
    {
        return view('admin.events');
    }
}