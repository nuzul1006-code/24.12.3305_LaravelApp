@extends('layouts.app')

@section('content')

<main class="max-w-3xl mx-auto px-6 py-20">
    <div class="mb-12">
        <a href="{{ route('ticket') }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Tiket Saya
        </a>
        <h1 class="text-4xl font-extrabold tracking-tight">Tulis Ulasan & Rating</h1>
        <p class="text-slate-500 mt-2">Bagikan pengalaman Anda tentang acara yang telah Anda hadiri.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl font-bold">
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        {{-- Ringkasan Acara --}}
        <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-6 flex gap-6 items-center">
            @if($transaction->event->poster_path)
                <img src="{{ asset('storage/' . $transaction->event->poster_path) }}" 
                     alt="{{ $transaction->event->title }}" class="w-20 h-24 object-cover rounded-xl shadow-sm shrink-0">
            @else
                <img src="{{ asset('assets/concert.png') }}" 
                     alt="{{ $transaction->event->title }}" class="w-20 h-24 object-cover rounded-xl shadow-sm shrink-0">
            @endif
            <div>
                <span class="text-xs font-black uppercase text-indigo-600 tracking-wider">
                    {{ $transaction->event->category->name ?? 'Acara Selesai' }}
                </span>
                <h4 class="font-extrabold text-xl text-slate-800 mt-1">{{ $transaction->event->title }}</h4>
                <p class="text-slate-500 text-sm mt-1">
                    Diselenggarakan oleh: 
                    <span class="font-bold text-slate-700">
                        {{ $transaction->event->partner->name ?? 'Penyelenggara Resmi' }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Form Ulasan --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                {{-- Rating Bintang --}}
                <div class="text-center py-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <label class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Berikan Penilaian Bintang</label>
                    <div class="flex items-center justify-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only star-input" required {{ old('rating') == $i ? 'checked' : '' }}>
                                <svg data-index="{{ $i }}" class="w-12 h-12 text-slate-200 hover:scale-110 transition-transform duration-150 star-icon fill-current" 
                                     viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <p id="rating-label" class="text-xs font-bold text-indigo-600 mt-3 uppercase tracking-wider">Silakan pilih rating</p>
                </div>

                {{-- Testimoni Ulasan --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Testimoni / Ulasan</label>
                    <textarea name="review" rows="5" required minlength="5" maxlength="1000"
                              placeholder="Bagikan ulasan jujur Anda tentang keseruan acara, fasilitas, pelayanan panitia, maupun masukan untuk acara selanjutnya..."
                              class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none">{{ old('review') }}</textarea>
                    <div class="flex justify-between mt-2 text-xs text-slate-400 font-medium">
                        <span>Minimal 5 karakter</span>
                        <span>Maksimal 1000 karakter</span>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 active:scale-98 transition duration-200">
                        Kirim Ulasan & Rating
                    </button>
                    <p class="text-center text-xs text-slate-400 mt-3 font-semibold uppercase tracking-wider">
                        *Ulasan yang dikirim akan ditayangkan di halaman profil penyelenggara
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-icon');
        const inputs = document.querySelectorAll('.star-input');
        const label = document.getElementById('rating-label');

        const ratingTexts = {
            1: "⭐ Buruk - Sangat kecewa",
            2: "⭐⭐ Kurang - Butuh banyak peningkatan",
            3: "⭐⭐⭐ Cukup - Lumayan seru",
            4: "⭐⭐⭐⭐ Sangat Baik - Sangat menikmati",
            5: "⭐⭐⭐⭐⭐ Luar Biasa - Sempurna!"
        };

        function highlightStars(rating) {
            stars.forEach(star => {
                const index = parseInt(star.getAttribute('data-index'));
                if (index <= rating) {
                    star.classList.remove('text-slate-200');
                    star.classList.add('text-amber-400');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-slate-200');
                }
            });
            if (ratingTexts[rating]) {
                label.textContent = ratingTexts[rating];
            }
        }

        // Cek jika ada default value (dari validation error redirect)
        const checkedInput = document.querySelector('.star-input:checked');
        if (checkedInput) {
            highlightStars(parseInt(checkedInput.value));
        }

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = parseInt(this.getAttribute('data-index'));
                const matchingInput = document.querySelector(`.star-input[value="${rating}"]`);
                if (matchingInput) {
                    matchingInput.checked = true;
                }
                highlightStars(rating);
            });

            star.addEventListener('mouseenter', function () {
                const rating = parseInt(this.getAttribute('data-index'));
                // Highlight temporary on hover
                stars.forEach(s => {
                    const idx = parseInt(s.getAttribute('data-index'));
                    if (idx <= rating) {
                        s.classList.remove('text-slate-200');
                        s.classList.add('text-amber-400');
                    } else {
                        s.classList.remove('text-amber-400');
                        s.classList.add('text-slate-200');
                    }
                });
            });

            star.addEventListener('mouseleave', function () {
                // Restore checked state
                const activeChecked = document.querySelector('.star-input:checked');
                if (activeChecked) {
                    highlightStars(parseInt(activeChecked.value));
                } else {
                    stars.forEach(s => {
                        s.classList.remove('text-amber-400');
                        s.classList.add('text-slate-200');
                    });
                    label.textContent = "Silakan pilih rating";
                }
            });
        });
    });
</script>

@endsection
