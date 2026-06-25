@extends('layouts.admin', ['title' => 'Laporan Transaksi'])

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Laporan Transaksi</h1>
        <p class="text-slate-500 font-medium">Pantau arus kas dan penjualan tiket Anda.</p>
    </div>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Order ID</th>
                    <th class="px-8 py-4">Detail Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold px-3 py-1 rounded-lg text-sm
                            {{ $trx->status == 'Pending' ? 'bg-slate-100 text-slate-600' : 'text-indigo-600 bg-indigo-50' }}">
                            {{ $trx->order_id }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-500">{{ $trx->customer_email }}</p>
                        <p class="text-xs text-slate-500">{{ $trx->customer_phone }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-medium text-slate-700">{{ $trx->event->title ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500">
                        {{ $trx->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        @if($trx->status === 'settlement' || $trx->status === 'Success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">
                                Success
                            </span>
                        @elseif($trx->status === 'Pending' || $trx->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">
                                Pending
                            </span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">
                                {{ $trx->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-16 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="font-bold">Belum ada transaksi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $transactions->links() }}
    </div>
</div>

@endsection