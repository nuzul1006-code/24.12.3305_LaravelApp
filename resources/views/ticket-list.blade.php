@extends('layouts.app')

@section('content')

<main class="max-w-6xl mx-auto px-6 py-20">
    <div class="mb-12 text-center md:text-left">
        <h1 class="text-4xl font-extrabold tracking-tight">Tiket Saya</h1>
        <p class="text-slate-500 mt-2">Daftar reservasi tiket event Anda dan ulasan pasca-acara.</p>
    </div>

    @if(!auth()->check() && !$searched)
        {{-- Tampilan Form Pencarian jika User Belum Login & Belum Melakukan Pencarian --}}
        <div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="p-8 bg-indigo-600 text-white text-center">
                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Cari Tiket Manual</span>
                <h3 class="text-2xl font-black mt-3">Lacak E-Ticket & Beri Rating</h3>
                <p class="text-indigo-100 text-sm mt-2">Masukkan data pembelian Anda untuk melihat tiket dan menulis testimoni pasca-acara.</p>
            </div>
            
            <form action="{{ route('ticket') }}" method="GET" class="p-8 space-y-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Email Pembeli</label>
                    <input type="email" name="email" required placeholder="contoh@gmail.com"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 focus:border-indigo-600 focus:bg-white rounded-2xl outline-none font-medium transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Order ID</label>
                    <input type="text" name="order_id" required placeholder="TRX-xxxxxxxxx"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 focus:border-indigo-600 focus:bg-white rounded-2xl outline-none font-mono font-bold transition">
                </div>
                <button type="submit" 
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-lg shadow-indigo-100 transition duration-200 active:scale-98">
                    Cari Tiket Saya
                </button>

                <div class="relative flex py-4 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-slate-400 text-xs font-bold uppercase">Atau Lebih Mudah</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <a href="{{ route('auth.google') }}" 
                   class="flex items-center justify-center gap-3 px-6 py-4 bg-white border-2 border-slate-200 hover:border-indigo-600 rounded-2xl font-bold text-slate-700 hover:text-indigo-600 shadow-sm hover:shadow transition duration-200 w-full">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    Masuk dengan Google SSO
                </a>
            </form>
        </div>
    @else
        {{-- Tampilan List Tiket --}}
        @if($transactions->isEmpty())
            <div class="text-center py-20 bg-white border border-slate-200 rounded-[2rem] shadow-sm max-w-3xl mx-auto p-10">
                <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800">Tiket Tidak Ditemukan</h3>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">Kami tidak menemukan transaksi tiket aktif dengan kriteria pencarian tersebut atau akun Google ini.</p>
                <div class="mt-8 flex justify-center gap-4">
                    <a href="{{ route('ticket', ['clear' => 1]) }}" class="px-6 py-3 border-2 border-slate-200 hover:border-indigo-600 text-slate-600 hover:text-indigo-600 rounded-2xl font-bold transition">
                        Cari Lagi
                    </a>
                    <a href="{{ route('home') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-md hover:scale-105 transition-all">
                        Eksplor Event
                    </a>
                </div>
            </div>
        @else
            {{-- Ada Tiket --}}
            <div class="space-y-8 max-w-4xl mx-auto">
                @if(!auth()->check())
                    <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-between">
                        <p class="text-indigo-900 text-sm font-semibold">Menampilkan pencarian tiket untuk: <span class="font-black font-mono text-indigo-700">{{ $order_id }}</span></p>
                        <a href="{{ route('ticket') }}" class="text-xs font-bold text-indigo-600 hover:underline">Reset Lacak</a>
                    </div>
                @endif

                @foreach($transactions as $trx)
                    @php
                        $event = $trx->event;
                        $partner = $event->partner;
                        $eventDate = \Carbon\Carbon::parse($event->date);
                        $isSuccess = strtolower($trx->status) === 'success';
                        
                        // Bisakah diulas?
                        // 1. Harus Sukses
                        // 2. Event Selesai dan sudah lewat 1 hari
                        $isFinished = $eventDate->isPast();
                        $canReviewDayPassed = $eventDate->copy()->addDay() <= now();
                        $hasReviewed = $trx->review()->exists();
                        $review = $trx->review;
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col md:flex-row">
                        {{-- Sisi Kiri: Poster Event --}}
                        <div class="w-full md:w-56 shrink-0 aspect-[4/5] md:aspect-auto relative overflow-hidden bg-slate-100">
                            @if($event->poster_path)
                                <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('assets/concert.png') }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-4 left-4">
                                @if($isSuccess)
                                    <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">Sukses</span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">Pending</span>
                                @endif
                            </div>
                        </div>

                        {{-- Sisi Kanan: Detail & Aksi --}}
                        <div class="p-8 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="text-xs font-black uppercase text-indigo-600">{{ $event->category->name ?? 'Event' }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-xs text-slate-500 font-bold">Order ID: <span class="font-mono">{{ $trx->order_id }}</span></span>
                                </div>
                                <h3 class="text-2xl font-black text-slate-800 mb-3">{{ $event->title }}</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-4 text-slate-600 text-sm mb-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $eventDate->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                    @if($partner)
                                    <div class="flex items-center gap-2 md:col-span-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span>Penyelenggara: 
                                            <a href="{{ route('partner.profile', $partner->id) }}" class="text-indigo-600 font-bold hover:underline">
                                                {{ $partner->name }}
                                            </a>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Panel Ulasan & Review Pasca Acara --}}
                            <div class="pt-6 border-t border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                                <div>
                                    @if($isSuccess)
                                        <a href="{{ route('ticket.detail', $trx->order_id) }}" target="_blank"
                                           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                            </svg>
                                            Lihat E-Ticket (PDF/Cetak) →
                                        </a>
                                    @else
                                        <span class="text-sm font-semibold text-slate-400">Selesaikan pembayaran untuk mengaktifkan tiket.</span>
                                    @endif
                                </div>

                                <div>
                                    @if(!$isSuccess)
                                        {{-- Pending/failed transaction --}}
                                        <a href="{{ route('checkout.payment', $trx->order_id) }}" 
                                           class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-bold text-xs shadow-md transition">
                                            Bayar Sekarang
                                        </a>
                                    @elseif(!$isFinished)
                                        {{-- Event belum terlaksana --}}
                                        <span class="inline-block px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-xs font-bold uppercase tracking-wider">
                                            ⏳ Acara Mendatang
                                        </span>
                                    @else
                                        {{-- Event selesai --}}
                                        @if($hasReviewed)
                                            {{-- Sudah diulas --}}
                                            <div class="text-right">
                                                <div class="flex items-center justify-end gap-1 mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-[11px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full inline-block">✓ Telah Diulas</p>
                                            </div>
                                        @elseif(!$canReviewDayPassed)
                                            {{-- Selesai, tapi kurang dari 24 jam --}}
                                            <div class="text-right">
                                                <span class="inline-block px-3 py-1.5 bg-slate-100 text-slate-500 rounded-xl text-xs font-bold">
                                                    🔒 Ulasan Tersedia Besok
                                                </span>
                                                <p class="text-[10px] text-slate-400 mt-1 italic font-medium">Ulasan aktif 1 hari setelah acara selesai</p>
                                            </div>
                                        @else
                                            {{-- Sukses, selesai, 1 hari lewat, belum diulas --}}
                                            <a href="{{ route('reviews.create', $trx->order_id) }}" 
                                               class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-100 hover:scale-105 transition-all">
                                                ★ Beri Ulasan & Rating
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            {{-- Tampilan feedback jika sudah diulas --}}
                            @if($hasReviewed)
                                <div class="mt-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs text-slate-600">
                                    <p class="font-bold text-slate-700 mb-1">Testimoni Anda:</p>
                                    <p class="italic">"{{ $review->review }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</main>

@endsection
