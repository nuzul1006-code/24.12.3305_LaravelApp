@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1 Event Platform</span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Loket Event</span> Impianmu.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
        </p>
        <div class="flex gap-4">
            <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <img src="{{ asset('assets/concert.png') }}"
             alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5]">
        <div class="absolute -bottom-6 -left-6 p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Events Section --}}
<section id="events" class="max-w-7xl mx-auto px-6 py-20">

    {{-- Header --}}
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
        <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru!</p>
    </div>

    {{-- Filter Kategori --}}
    <div class="mb-10 flex flex-wrap gap-3">
        {{-- Tombol Semua --}}
        <a href="{{ route('home') }}"
           class="px-5 py-2.5 rounded-2xl font-bold text-sm transition
           {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white border border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
            🗂️ Semua Kategori
        </a>

        {{-- Tab Kategori Dinamis --}}
        @foreach($categories as $cat)
        <a href="{{ route('home', ['category' => $cat->slug]) }}#events"
           class="px-5 py-2.5 rounded-2xl font-bold text-sm transition
           {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white border border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    {{-- Info filter aktif --}}
    @if(request('category'))
        @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
        <div class="mb-8 flex items-center gap-3 px-6 py-4 bg-indigo-50 rounded-2xl border border-indigo-100">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"></path>
            </svg>
            <p class="text-indigo-700 font-bold text-sm">
                Filter aktif: <span class="text-indigo-900">{{ $activeCat->name ?? request('category') }}</span>
                — menampilkan {{ $events->count() }} event
            </p>
            <a href="{{ route('home') }}" class="ml-auto text-xs font-bold text-indigo-500 hover:text-indigo-700 underline">
                ✕ Hapus filter
            </a>
        </div>
    @endif

    {{-- Grid Event --}}
    @if($events->isEmpty())
        <div class="text-center py-24 text-slate-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="font-bold text-lg">Belum ada event di kategori ini.</p>
            <a href="{{ route('home') }}" class="mt-3 inline-block text-indigo-600 font-bold hover:underline">
                ← Lihat semua event
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[3/4]">
                    @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                             alt="{{ $event->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <img src="{{ asset('assets/concert.png') }}"
                             alt="{{ $event->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @endif
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                        {{ $event->category->name ?? 'Event' }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-2">
                        {{ $event->title }}
                    </h3>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-2xl font-black text-indigo-600">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('events.show', $event->id) }}"
                           class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</section>

{{-- Partner Section --}}
@if($partners->count() > 0)
<section id="partner" class="max-w-7xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold mb-2">Partner Kami</h2>
        <p class="text-slate-500 font-medium">Didukung oleh perusahaan dan organisasi terpercaya.</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($partners as $partner)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all p-6 flex flex-col items-center justify-center gap-3">
            @if($partner->logo_url)
                <img src="{{ asset('storage/' . $partner->logo_url) }}"
                     alt="{{ $partner->name }}"
                     class="h-16 w-auto object-contain">
            @else
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-2xl">
                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                </div>
            @endif
            <p class="font-bold text-slate-700 text-center text-sm">{{ $partner->name }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection