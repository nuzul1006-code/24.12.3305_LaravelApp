@extends('layouts.admin', ['title' => 'Tambah Kategori'])

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-black">Tambah Kategori</h1>
    <p class="text-slate-500 font-medium">Tambahkan kategori event baru.</p>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Kategori
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="cth: Seminar, Workshop, Hiburan..."
                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-slate-400 mt-2">Slug akan dibuat otomatis dari nama kategori.</p>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.categories.index') }}"
               class="px-6 py-3 font-bold text-slate-400 hover:text-slate-600 transition">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>

@endsection