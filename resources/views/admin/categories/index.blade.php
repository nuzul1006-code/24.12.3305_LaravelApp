@extends('layouts.admin', ['title' => 'Kelola Kategori'])

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Kategori</h1>
        <p class="text-slate-500 font-medium">Kelola kategori event yang tersedia.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 active:scale-95 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kategori
    </a>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

    {{-- Search Bar --}}
    <div class="px-8 py-6 bg-slate-50/50 border-b">
        <form method="GET" action="{{ route('admin.categories.index') }}">
            <div class="flex gap-4">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari nama kategori..."
                    class="flex-1 px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-6 py-3 border border-slate-200 rounded-xl font-bold hover:bg-slate-50 transition text-slate-600">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Slug</th>
                    <th class="px-8 py-4">Jumlah Event</th>
                    <th class="px-8 py-4">Dibuat</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">{{ $category->name }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-mono">
                            {{ $category->slug }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-indigo-600">
                            {{ $category->events->count() }} Event
                        </span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500">
                        {{ $category->created_at->format('d M Y') }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                               class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus kategori {{ $category->name }}? Event yang terkait akan ikut terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                        title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-16 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"></path>
                        </svg>
                        <p class="font-bold">
                            {{ $search ? 'Kategori "' . $search . '" tidak ditemukan.' : 'Belum ada kategori.' }}
                        </p>
                        <a href="{{ route('admin.categories.create') }}" class="mt-3 inline-block text-indigo-600 font-bold hover:underline">
                            + Tambah sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 bg-slate-50/50 border-t">
        <p class="text-sm text-slate-500 font-medium">
            Total: {{ $categories->count() }} kategori
            @if($search) • hasil pencarian untuk "{{ $search }}" @endif
        </p>
    </div>
</div>

@endsection