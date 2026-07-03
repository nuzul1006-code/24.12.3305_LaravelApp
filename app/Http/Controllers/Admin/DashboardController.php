<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total pendapatan dari transaksi lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        // 2. Jumlah tiket terjual
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])
            ->count();

        // 3. Jumlah event aktif (belum lewat tanggalnya)
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Jumlah pesanan pending
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. 5 transaksi terbaru
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions'
        ));
    }
}