<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = $request->user()->partner_id;

        // ISOLASI DATA (Fase 7): Hanya query event milik partner yang sedang login!
        $events = Event::where('partner_id', $partnerId)->latest()->get();

        // Hitung total pendapatan khusus event partner ini (menggunakan kolom total_price)
        $totalRevenue = Transaction::whereHas('event', function ($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->where('status', 'success')->sum('total_price');

        $totalEvents = $events->count();

        return view('partner.dashboard', compact('events', 'totalRevenue', 'totalEvents'));
    }
}