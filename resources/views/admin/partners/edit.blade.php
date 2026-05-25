@extends('layouts.admin', ['title' => 'Edit Partner'])

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="mb-10">
    <h1 class="text-3xl font-black">Edit Partner</h1>
    <p class="font-medium text-slate-500">
        Perbarui informasi partner
        <span class="font-bold text-indigo-600">"{{ $partner->name }}"</span>
    </p>
</div>

{{-- ===== FORM CARD ===== --}}
<div class="max-w-2xl rounded-[2.5rem] border border-slate-100 bg-white p-10 shadow-sm">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.partners.update', $partner->id) }}"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- Nama Partner --}}
        <div>
            <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-700">
                Nama Partner
            </label>
            <input
                required
                type="text"
                name="name"
                value="{{ old('name', $partner->name) }}"
                class="w-full rounded-xl border border-slate-200 px-5 py-4 outline-none transition focus:ring-2 focus:ring-indigo-500"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Logo Partner --}}
        <div>
            <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-700">
                Logo Partner
            </label>

            <div class="flex items-start gap-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-4">

                {{-- Preview logo saat ini --}}
                <div class="shrink-0 text-center">
                    <p class="mb-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        Logo Saat Ini
                    </p>
                    @if ($partner->logo_url)
                        <img
                            alt="Logo {{ $partner->name }}"
                            src="{{ asset('storage/' . $partner->logo_url) }}"
                            class="h-24 w-24 rounded-xl border border-slate-100 bg-white object-contain p-2 shadow-sm"
                        >
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-slate-200 text-2xl font-black text-slate-400">
                            {{ strtoupper(substr($partner->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                {{-- Input file --}}
                <div class="flex-1">
                    <p class="mb-3 text-xs leading-relaxed text-slate-500">
                        Pilih file baru untuk mengganti logo. Kosongkan jika tidak ingin mengubah.
                    </p>
                    <input
                        type="file"
                        name="logo"
                        accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                    @error('logo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 border-t border-slate-100 pt-6">
            
                href="{{ route('admin.partners.index') }}"
                class="px-6 py-3 font-bold text-slate-400 transition hover:text-slate-600"
            >
                Batal
            </a>
            <button
                type="submit"
                class="rounded-2xl bg-indigo-600 px-8 py-3 font-bold text-white shadow-lg transition hover:bg-indigo-700"
            >
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@endsection