@extends('layouts.admin', ['title' => 'Tambah Partner'])

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-black">Tambah Partner</h1>
    <p class="text-slate-500 font-medium">Tambahkan mitra baru AmikomEventHub.</p>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm max-w-2xl">
    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Partner
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Tambah partner baru..."
                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Logo Partner (Opsional)
            </label>
            <input type="file" name="logo" accept="image/*"
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG, SVG. Maks 2MB.</p>
            @error('logo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.partners.index') }}"
               class="px-6 py-3 font-bold text-slate-400 hover:text-slate-600 transition">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
                Simpan Partner
            </button>
        </div>
    </form>
</div>

@endsection