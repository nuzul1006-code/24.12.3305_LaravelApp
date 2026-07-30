@extends('layouts.admin', ['title' => 'Admin Dashboard'])

@section('content')

{{-- GLOBAL FILTER BAR (SaaS Style) --}}
<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
    <form method="GET" action="{{ url()->current() }}" class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Dashboard Overview</h2>
            <p class="text-slate-400 text-sm">Analisis performa sistem ticketing dan penjualan event secara real-time.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            {{-- Dropdown Filter Utama --}}
            <select name="filter" id="filterSelect" onchange="toggleFilterInputs()" 
                class="bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="7days" {{ $filter === '7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30days" {{ $filter === '30days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Bulan Tertentu</option>
                <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>Tahun Tertentu</option>
            </select>

            {{-- Dropdown Pilih Bulan (Muncul jika filter 'month' dipilih) --}}
            <div id="monthWrapper" class="{{ $filter === 'month' ? '' : 'hidden' }}">
                <select name="month" class="bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    @php
                        $monthsList = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                    @endphp
                    @foreach($monthsList as $num => $name)
                        <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown Pilih Tahun (Muncul jika filter 'month' atau 'year' dipilih) --}}
            <div id="yearWrapper" class="{{ in_array($filter, ['month', 'year']) ? '' : 'hidden' }}">
                <select name="year" class="bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition shadow-sm shadow-indigo-200">
                Terapkan
            </button>
        </div>
    </form>
</div>

{{-- Stats Grid (4 Kartu Utama) --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Total User --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total User</p>
        <h3 class="text-2xl font-black">{{ number_format($totalUsers, 0, ',', '.') }}</h3>
    </div>

    {{-- Total Event --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Event</p>
        <h3 class="text-2xl font-black">{{ number_format($totalEvents, 0, ',', '.') }}</h3>
    </div>

    {{-- Tiket Terjual --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
    </div>

    {{-- Total Pendapatan --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>

</div>

{{-- SECTION GRAFIK UTAMA (Line Chart Tren Penjualan Tiket) --}}
<div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="font-black text-xl text-slate-800">Tren Penjualan Tiket</h3>
            <p class="text-slate-400 text-sm">Grafik pergerakan transaksi sukses sesuai rentang filter yang dipilih.</p>
        </div>
        <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold uppercase">
            Real-time Data
        </span>
    </div>
    <div class="relative w-full h-80">
        <canvas id="eventGrowthChart"></canvas>
    </div>
</div>

{{-- SECTION GRAFIK TAMBAHAN (Bar Chart & Donut Chart Berdampingan) --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    {{-- Top 5 Event Terlaris (Bar Chart - Mengambil 2 kolom) --}}
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm lg:col-span-2 flex flex-col justify-between">
        <div>
            <h3 class="font-black text-xl text-slate-800 mb-1">Top 5 Event Terlaris</h3>
            <p class="text-slate-400 text-sm mb-6">Event dengan jumlah penjualan tiket terbanyak.</p>
        </div>
        <div class="relative w-full h-72">
            <canvas id="topEventsChart"></canvas>
        </div>
    </div>

    {{-- Status Pembayaran (Donut Chart - Mengambil 1 kolom) --}}
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="font-black text-xl text-slate-800 mb-1">Status Pembayaran</h3>
            <p class="text-slate-400 text-sm mb-6">Distribusi status transaksi.</p>
        </div>
        <div class="relative w-full h-64 flex justify-center items-center">
            <canvas id="paymentStatusChart"></canvas>
        </div>
    </div>
</div>

{{-- Tabel Aktivitas / Transaksi Terakhir --}}
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Aktivitas Transaksi Terbaru</h3>
        <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">
            Lihat Semua
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 text-sm text-slate-600">
                        {{ $trx->created_at->format('d M Y, H:i') }}
                        <br>
                        <span class="text-xs text-slate-400">{{ $trx->order_id }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold uppercase tracking-wide text-sm">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-600">
                        {{ $trx->event->title ?? '-' }}
                    </td>
                    <td class="px-8 py-6">
                        @if($trx->status === 'settlement' || $trx->status === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                        @elseif($trx->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 text-right">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script untuk Toggle Visibility Filter Bulan & Tahun --}}
<script>
    function toggleFilterInputs() {
        const filterVal = document.getElementById('filterSelect').value;
        const monthWrapper = document.getElementById('monthWrapper');
        const yearWrapper = document.getElementById('yearWrapper');

        if (filterVal === 'month') {
            monthWrapper.classList.remove('hidden');
            yearWrapper.classList.remove('hidden');
        } else if (filterVal === 'year') {
            monthWrapper.classList.add('hidden');
            yearWrapper.classList.remove('hidden');
        } else {
            monthWrapper.classList.add('hidden');
            yearWrapper.classList.add('hidden');
        }
    }
</script>

{{-- Script Chart.js (Line Chart, Bar Chart, Donut Chart) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Line Chart Utama (Tren Penjualan Tiket)
        const lineCanvas = document.getElementById('eventGrowthChart');
        if (lineCanvas) {
            const ctx = lineCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.35)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Tiket Terjual',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#4f46e5',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ` Total Tiket: ${context.raw} Tiket`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { weight: 'bold', size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#94a3b8', font: { weight: 'bold' } },
                            grid: { color: '#f1f5f9' }
                        }
                    }
                }
            });
        }

        // 2. Bar Chart (Top 5 Event Terlaris)
        const barCanvas = document.getElementById('topEventsChart');
        if (barCanvas) {
            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topEventLabels) !!},
                    datasets: [{
                        label: 'Tiket Terjual',
                        data: {!! json_encode($topEventData) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 8,
                        barThickness: 32
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { weight: 'bold', size: 10 } } },
                        y: { beginAtZero: true, ticks: { precision: 0, color: '#94a3b8' }, grid: { color: '#f1f5f9' } }
                    }
                }
            });
        }

        // 3. Donut Chart (Status Pembayaran)
        const donutCanvas = document.getElementById('paymentStatusChart');
        if (donutCanvas) {
            new Chart(donutCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Paid / Success', 'Pending', 'Failed / Expired'],
                    datasets: [{
                        data: [
                            {{ $paidCount }},
                            {{ $pendingCount }},
                            {{ $failedCount }}
                        ],
                        backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { weight: 'bold', size: 11 }, color: '#64748b', boxWidth: 12 }
                        }
                    },
                    cutout: '70%'
                }
            });
        }
    });
</script>

@endsection