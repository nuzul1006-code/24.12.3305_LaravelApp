<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User; // <-- 1. Tambahkan ini untuk menghitung total user
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        // Tangkap pilihan filter & waktu dari request
        $filter = $request->query('filter', '7days'); 
        $selectedMonth = $request->query('month', date('m'));
        $selectedYear = $request->query('year', date('Y'));

        // ==========================================
        // 1. STATISTIK KARTU UTAMA (SAAS METRICS)
        // ==========================================
        $totalUsers = User::count();
        $totalEvents = Event::count();

        $successQuery = Transaction::whereIn('status', ['settlement', 'success']);

        $totalRevenue = (clone $successQuery)->sum('total_price');
        $ticketsSold = (clone $successQuery)->count();

        // ==========================================
        // 2. DATA UNTUK DONUT CHART (STATUS PEMBAYARAN)
        // ==========================================
        $paidCount = (clone $successQuery)->count();
        $pendingCount = Transaction::where('status', 'pending')->count();
        $failedCount = Transaction::whereNotIn('status', ['settlement', 'success', 'pending'])->count();

        // ==========================================
        // 3. DATA UNTUK BAR CHART (TOP 5 EVENT TERLARIS)
        // ==========================================
        $topEvents = Event::withCount(['transactions' => function ($query) {
                $query->whereIn('status', ['settlement', 'success']);
            }])
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        $topEventLabels = $topEvents->pluck('title')->toArray();
        $topEventData = $topEvents->pluck('transactions_count')->toArray();

        // ==========================================
        // 4. DATA GRAFIK UTAMA (LINE CHART DENGAN FILTER)
        // ==========================================
        $chartLabels = [];
        $chartData = [];

        if ($filter === 'today') {
            // OPSI A: GRAFIK HARI INI (PER JAM 00:00 - 23:00)
            $hours = range(0, 23);
            $hourlyCounts = array_fill(0, 24, 0);

            $transactionsToday = Transaction::whereIn('status', ['settlement', 'success'])
                ->whereDate('created_at', today())
                ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->get();

            foreach ($transactionsToday as $trx) {
                $hourlyCounts[$trx->hour] = (int) $trx->count;
            }

            $chartLabels = array_map(function($h) {
                return str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            }, $hours);
            $chartData = $hourlyCounts;

        } elseif ($filter === 'month') {
            // OPSI B: GRAFIK BULAN TERTENTU (PER HARI DALAM BULAN TERSEBUT)
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$selectedMonth, (int)$selectedYear);
            $dailyCounts = array_fill(1, $daysInMonth, 0);

            $transactionsMonth = Transaction::whereIn('status', ['settlement', 'success'])
                ->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $selectedMonth)
                ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->get();

            foreach ($transactionsMonth as $trx) {
                $dailyCounts[$trx->day] = (int) $trx->count;
            }

            $chartLabels = array_keys($dailyCounts);
            $chartData = array_values($dailyCounts);

        } elseif ($filter === 'year') {
            // OPSI C: GRAFIK TAHUN INI (PER BULAN)
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $monthlyCounts = array_fill(0, 12, 0); 

            $transactionsPerMonth = Transaction::whereIn('status', ['settlement', 'success'])
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $selectedYear)
                ->groupBy('month')
                ->get();

            foreach ($transactionsPerMonth as $trx) {
                if ($trx->month >= 1 && $trx->month <= 12) {
                    $monthlyCounts[$trx->month - 1] = (int) $trx->count;
                }
            }

            $chartLabels = $months;
            $chartData = $monthlyCounts;

        } else {
            // OPSI D: GRAFIK HARIAN (7 atau 30 HARI TERAKHIR)
            $days = ($filter === '30days') ? 30 : 7;
            
            $dates = [];
            $transactionCounts = [];

            for ($i = $days - 1; $i >= 0; $i--) {
                $dateKey = now()->subDays($i)->format('Y-m-d');
                $dateLabel = now()->subDays($i)->format('d'); // Hanya angka tanggal saja
                
                $dates[$dateKey] = $dateLabel;
                $transactionCounts[$dateKey] = 0; 
            }

            $transactionsPerDay = Transaction::whereIn('status', ['settlement', 'success'])
                ->where('created_at', '>=', now()->subDays($days)->startOfDay())
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->get();

            foreach ($transactionsPerDay as $trx) {
                if (isset($transactionCounts[$trx->date])) {
                    $transactionCounts[$trx->date] = (int) $trx->count;
                }
            }

            $chartLabels = array_values($dates);
            $chartData = array_values($transactionCounts);
        }

        // 5. 5 Transaksi terbaru untuk tabel bawah
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'ticketsSold',
            'totalRevenue',
            'recentTransactions',
            'chartLabels',
            'chartData',
            'topEventLabels',
            'topEventData',
            'paidCount',
            'pendingCount',
            'failedCount',
            'filter',
            'selectedMonth',
            'selectedYear'
        ));
    }
}