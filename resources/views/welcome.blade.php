@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1 Event Platform</span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
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

{{-- Kategori Section --}}
<section id="kategori" class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold mb-2">Jelajahi Kategori</h2>
        <p class="text-slate-500">Temukan event sesuai minat Anda.</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        {{-- Tombol Semua --}}
        <a href="{{ route('home') }}#events"
           class="group bg-white rounded-2xl border {{ !request('category') ? 'border-indigo-400 bg-indigo-50' : 'border-slate-100' }} shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all p-6 text-center">
            <div class="w-12 h-12 {{ !request('category') ? 'bg-indigo-600' : 'bg-indigo-50' }} rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-600 transition">
                <svg class="w-6 h-6 {{ !request('category') ? 'text-white' : 'text-indigo-600' }} group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
            <p class="font-black {{ !request('category') ? 'text-indigo-600' : 'text-slate-800' }} group-hover:text-indigo-600 transition">Semua</p>
            <p class="text-xs text-slate-400 mt-1">{{ $events->count() }} Event</p>
        </a>

        @foreach($categories as $category)
        <a href="{{ route('home', ['category' => $category->id]) }}#events"
           class="group bg-white rounded-2xl border {{ request('category') == $category->id ? 'border-indigo-400 bg-indigo-50' : 'border-slate-100' }} shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all p-6 text-center">
            <div class="w-12 h-12 {{ request('category') == $category->id ? 'bg-indigo-600' : 'bg-indigo-50' }} rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-600 transition">
                <svg class="w-6 h-6 {{ request('category') == $category->id ? 'text-white' : 'text-indigo-600' }} group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"></path>
                </svg>
            </div>
            <p class="font-black {{ request('category') == $category->id ? 'text-indigo-600' : 'text-slate-800' }} group-hover:text-indigo-600 transition">
                {{ $category->name }}
            </p>
            <p class="text-xs text-slate-400 mt-1">{{ $category->events_count }} Event</p>
        </a>
        @endforeach
    </div>
</section>

{{-- Events Grid --}}
<section id="events" class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex justify-between items-end mb-12">
        <div>
            @if(request('category'))
                @php $selectedCategory = $categories->find(request('category')); @endphp
                <h2 class="text-3xl font-extrabold mb-2">
                    Event: {{ $selectedCategory->name ?? 'Kategori' }}
                </h2>
                <p class="text-slate-500 font-medium">
                    Menampilkan {{ $events->count() }} event dalam kategori ini.
                    <a href="{{ route('home') }}#events" class="text-indigo-600 font-bold hover:underline ml-2">
                        ← Lihat Semua
                    </a>
                </p>
            @else
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            @endif
        </div>
    </div>

    @if($events->isEmpty())
        <div class="text-center py-20 text-slate-400">
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

{{-- Partner Section (Soal 4) --}}
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