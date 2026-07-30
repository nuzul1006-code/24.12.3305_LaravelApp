@extends('layouts.app')

@section('content')

<main class="max-w-6xl mx-auto px-6 py-16">

    {{-- Header Profil Partner --}}
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden mb-12">
        <div class="h-32 bg-gradient-to-r from-indigo-600 to-indigo-400"></div>
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row md:items-end gap-6 -mt-12">
                @if($partner->logo_url)
                    <img src="{{ Str::startsWith($partner->logo_url, 'http') ? $partner->logo_url : asset('storage/' . $partner->logo_url) }}" 
                         alt="{{ $partner->name }}"
                         class="w-28 h-28 rounded-3xl object-cover border-4 border-white shadow-lg bg-white shrink-0">
                @else
                    <div class="w-28 h-28 rounded-3xl border-4 border-white shadow-lg bg-indigo-600 text-white flex items-center justify-center text-4xl font-black shrink-0">
                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-1 pt-2 md:pt-0">
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">{{ $partner->name }}</h1>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <span class="font-black text-slate-700">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-slate-400 text-sm font-semibold">({{ $totalReviews }} ulasan)</span>
                    </div>
                    <p class="text-slate-500 text-sm mt-3 max-w-xl">
                        {{ $partner->description ?? 'Penyelenggara terpercaya di Event Hub. Lihat rekam jejak penilaian dari peserta acara sebelumnya sebelum membeli tiket di acara mereka selanjutnya.' }}
                    </p>
                </div>

                <div class="flex gap-8 md:gap-10 pt-2">
                    <div class="text-center">
                        <p class="text-2xl font-black text-indigo-600">{{ $upcomingEvents->count() }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Akan Datang</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-slate-700">{{ $pastEvents->count() }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Acara Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- Kolom Kiri: Event --}}
        <div class="lg:col-span-1 space-y-10">
            @if($upcomingEvents->isNotEmpty())
            <div>
                <h3 class="text-lg font-extrabold text-slate-800 mb-4">Acara Mendatang</h3>
                <div class="space-y-3">
                    @foreach($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event->id) }}" class="flex gap-3 p-3 bg-white border border-slate-200 rounded-2xl hover:border-indigo-300 hover:shadow-md transition group">
                            <img src="{{ $event->poster_path ? asset('storage/'.$event->poster_path) : asset('assets/concert.png') }}"
                                 class="w-14 h-16 object-cover rounded-xl shrink-0">
                            <div class="min-w-0">
                                <p class="font-bold text-sm text-slate-800 truncate group-hover:text-indigo-600">{{ $event->title }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($pastEvents->isNotEmpty())
            <div>
                <h3 class="text-lg font-extrabold text-slate-800 mb-4">Acara Selesai</h3>
                <div class="space-y-3">
                    @foreach($pastEvents as $event)
                        <a href="{{ route('events.show', $event->id) }}" class="flex gap-3 p-3 bg-white border border-slate-200 rounded-2xl hover:border-indigo-300 hover:shadow-md transition group opacity-80 hover:opacity-100">
                            <img src="{{ $event->poster_path ? asset('storage/'.$event->poster_path) : asset('assets/concert.png') }}"
                                 class="w-14 h-16 object-cover rounded-xl shrink-0">
                            <div class="min-w-0">
                                <p class="font-bold text-sm text-slate-800 truncate group-hover:text-indigo-600">{{ $event->title }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($upcomingEvents->isEmpty() && $pastEvents->isEmpty())
                <p class="text-sm text-slate-400 italic">Belum ada acara dari penyelenggara ini.</p>
            @endif
        </div>

        {{-- Kolom Kanan: Ulasan & Testimoni --}}
        <div class="lg:col-span-2">
            <h3 class="text-lg font-extrabold text-slate-800 mb-4">Ulasan & Testimoni Peserta</h3>

            @if($reviews->isEmpty())
                <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">
                    <p class="text-slate-400 font-semibold">Belum ada ulasan untuk penyelenggara ini.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $review->user->name ?? $review->customer_name ?? 'Peserta' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        untuk acara <span class="font-semibold text-slate-500">{{ $review->event->title ?? '-' }}</span>
                                        &middot; {{ $review->created_at ? $review->created_at->format('d M Y') : '-' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-0.5 shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-slate-600 text-sm mt-3 leading-relaxed">{{ $review->comment ?? $review->review }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</main>

@endsection