@extends('layouts.admin', ['title' => 'Kelola Partner'])

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="mb-10 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-black">Kelola Partner</h1>
        <p class="font-medium text-slate-500">Kelola mitra yang mendukung AmikomEventHub.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}"
        class="flex items-center gap-2 rounded-2xl bg-indigo-600 px-6 py-3 font-bold text-white shadow-lg transition hover:bg-indigo-700 active:scale-95">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Partner
    </a>
</div>

{{-- ===== MAIN CARD ===== --}}
<div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-sm">

    {{-- Search --}}
    <div class="border-b bg-slate-50/50 px-8 py-6">
        <form action="{{ route('admin.partners.index') }}" method="GET">
            <div class="flex gap-4">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari nama partner..."
                    value="{{ $search ?? '' }}"
                    class="flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 outline-none transition focus:ring-2 focus:ring-indigo-500"
                >
                <button type="submit"
                    class="rounded-xl bg-indigo-600 px-6 py-3 font-bold text-white transition hover:bg-indigo-700">
                    Cari
                </button>

                @isset($search)
                    <a href="{{ route('admin.partners.index') }}"
                        class="rounded-xl border border-slate-200 px-6 py-3 font-bold text-slate-600 transition hover:bg-slate-50">
                        Reset
                    </a>
                @endisset
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="w-16 px-8 py-4">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Ditambahkan</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse ($partners as $urutan => $item)
                <tr class="transition hover:bg-slate-50/50">
                    <td class="px-8 py-5 font-bold text-slate-400">{{ $urutan + 1 }}</td>

                    <td class="px-8 py-5">
                        @if ($item->logo_url)
                            <img
                                src="{{ asset('storage/' . $item->logo_url) }}"
                                alt="Logo {{ $item->name }}"
                                class="h-16 w-16 rounded-xl border border-slate-100 bg-slate-50 object-contain p-1"
                            >
                        @else
                            <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-slate-100 text-lg font-black text-slate-400">
                                {{ strtoupper(substr($item->name, 0, 2)) }}
                            </div>
                        @endif
                    </td>

                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">{{ $item->name }}</p>
                    </td>

                    <td class="px-8 py-5 text-sm text-slate-500">
                        {{ $item->created_at->format('d M Y') }}
                    </td>

                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            {{-- Tombol Edit --}}
                            <a title="Edit"
                                href="{{ route('admin.partners.edit', $item->id) }}"
                                class="rounded-xl bg-indigo-50 p-2.5 text-indigo-600 transition hover:bg-indigo-600 hover:text-white">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form method="POST"
                                action="{{ route('admin.partners.destroy', $item->id) }}"
                                onsubmit="return confirm('Yakin ingin menghapus partner {{ $item->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="rounded-xl bg-rose-50 p-2.5 text-rose-600 transition hover:bg-rose-600 hover:text-white">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center text-slate-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="mx-auto mb-4 h-12 w-12 text-slate-300">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="font-bold">
                            @isset($search)
                                Partner "{{ $search }}" tidak ditemukan.
                            @else
                                Belum ada partner terdaftar.
                            @endisset
                        </p>
                        <a href="{{ route('admin.partners.create') }}"
                            class="mt-3 inline-block font-bold text-indigo-600 hover:underline">
                            + Tambah sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="border-t bg-slate-50/50 px-8 py-5">
        <p class="text-sm font-medium text-slate-500">
            Total: {{ $partners->count() }} partner
            @isset($search)
                &bull; hasil pencarian untuk "{{ $search }}"
            @endisset
        </p>
    </div>

</div>

@endsection