@extends('layouts.app')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

    <!-- Left: Poster -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            @if($event->poster_path)
                <img src="{{ asset('storage/' . $event->poster_path) }}"
                     alt="{{ $event->title }}"
                     class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">
            @else
                <img src="{{ asset('assets/concert.png') }}"
                     alt="{{ $event->title }}"
                     class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">
            @endif

            @if($event->partner)
            <a href="{{ route('partner.profile', $event->partner->id) }}"
               class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm block hover:border-indigo-300 hover:shadow-md transition">
                <h4 class="font-bold mb-4">Penyelenggara</h4>
                <div class="flex items-center gap-4">
                    @if($event->partner->logo_url)
                        <img src="{{ Str::startsWith($event->partner->logo_url, 'http') ? $event->partner->logo_url : asset('storage/' . $event->partner->logo_url) }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            {{ strtoupper(substr($event->partner->name, 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-bold text-slate-800">{{ $event->partner->name }}</p>
                        @if($partnerTotalReviews > 0)
                            <div class="flex items-center gap-1 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-xs font-bold text-slate-700">{{ number_format($partnerAvgRating, 1) }}</span>
                                <span class="text-xs text-slate-400">({{ $partnerTotalReviews }} ulasan)</span>
                            </div>
                        @else
                            <p class="text-xs text-slate-500">Belum ada ulasan</p>
                        @endif
                    </div>
                </div>
            </a>
            @endif
        </div>
    </div>

    <!-- Right: Details -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                {{ $event->category->name ?? 'Event' }}
            </span>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                {{ $event->title }}
            </h1>
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y • H:i') }} WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <p class="text-lg text-slate-600 leading-relaxed">
                {{ $event->description }}
            </p>
        </div>

        <!-- Harga & Pesan -->
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    <h2 class="text-5xl font-black">
                        {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        @if($event->price > 0)
                            <span class="text-lg font-medium text-indigo-200">/ orang</span>
                        @endif
                    </h2>
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sisa stok: <span class="font-bold underline">{{ $event->stock }} tiket lagi!</span>
                    </p>
                </div>

                {{-- PERUBAHAN ADA DI SINI --}}
                <a href="{{ route('checkout.create', $event->id) }}"
                   class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                    Pesan Sekarang
                </a>
            </div>
            <!-- Decoration -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <!-- Kebijakan Tiket -->
        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>
    </div>

</main>

@endsection