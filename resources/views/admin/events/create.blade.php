@extends('layouts.admin', ['title' => 'Tambah Event'])

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-black">Tambah Event Baru</h1>
    <p class="text-slate-500 font-medium">Isi detail event baru dengan lengkap.</p>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm max-w-4xl">
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">

            {{-- Judul Event --}}
            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Event</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Kategori</label>
                <select name="category_id" class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal & Waktu --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" value="{{ old('date') }}"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none" required>
                @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none resize-none" required>{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none" required>
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Stok --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Stok Tiket</label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}" min="1"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none" required>
                @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Lokasi --}}
            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 outline-none" required>
                @error('location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Poster --}}
            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Upload Poster</label>
                <input type="file" name="poster" accept="image/*"
                    class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                @error('poster') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.events.index') }}" class="px-6 py-3 font-bold text-slate-400 hover:text-slate-600 transition">Batal</a>
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                Simpan Event
            </button>
        </div>

    </form>
</div>

@endsection