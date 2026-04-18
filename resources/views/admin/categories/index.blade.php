@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Manajemen Kategori</h1>
        <p class="text-slate-500 font-medium">Kelola kategori event yang tersedia.</p>
    </div>
    <button onclick="openModal()"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kategori
    </button>
</header>

{{-- Stats ringkas --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"></path>
            </svg>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase">Total Kategori</p>
            <h3 class="text-2xl font-black">5</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase">Kategori Aktif</p>
            <h3 class="text-2xl font-black">4</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase">Total Event Terkait</p>
            <h3 class="text-2xl font-black">18</h3>
        </div>
    </div>
</div>

{{-- Tabel Kategori --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4 items-center">
        <input type="text" placeholder="Cari nama kategori..."
            class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
        <select class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Non-Aktif</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Ikon</th>
                    <th class="px-8 py-4">Jumlah Event</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">

                {{-- Row 1: Musik --}}
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">1</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">Musik</p>
                        <p class="text-xs text-slate-400 mt-0.5">Konser, festival, penampilan live</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-2xl">🎵</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700">6 Event</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Aktif</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <button onclick="openEditModal('Musik', 'Aktif')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal('Musik')"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Row 2: Seminar --}}
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">2</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">Seminar</p>
                        <p class="text-xs text-slate-400 mt-0.5">Seminar nasional, webinar, talk show</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-2xl">🎤</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700">4 Event</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Aktif</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <button onclick="openEditModal('Seminar', 'Aktif')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal('Seminar')"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Row 3: Workshop --}}
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">3</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">Workshop</p>
                        <p class="text-xs text-slate-400 mt-0.5">Pelatihan teknis, kelas praktis</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-2xl">🛠️</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700">5 Event</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Aktif</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <button onclick="openEditModal('Workshop', 'Aktif')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal('Workshop')"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Row 4: Konser --}}
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">4</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">Konser</p>
                        <p class="text-xs text-slate-400 mt-0.5">Pertunjukan musik berskala besar</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-2xl">🎸</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700">2 Event</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Aktif</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <button onclick="openEditModal('Konser', 'Aktif')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal('Konser')"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Row 5: Coding --}}
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">5</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800">Coding</p>
                        <p class="text-xs text-slate-400 mt-0.5">Hackathon, bootcamp, competitive programming</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-2xl">💻</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700">1 Event</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold uppercase ring-1 ring-slate-200">Non-Aktif</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <button onclick="openEditModal('Coding', 'Non-Aktif')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal('Coding')"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 bg-slate-50/50 border-t">
        <p class="text-sm text-slate-500 font-medium">Menampilkan 5 kategori</p>
    </div>
</div>


{{-- ========== MODAL: TAMBAH KATEGORI ========== --}}
<div id="modal-tambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="text-xl font-black">Tambah Kategori Baru</h3>
            <button onclick="closeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-8 space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Kategori</label>
                <input type="text" placeholder="cth: Olahraga, Seni, Teknologi..."
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi Singkat</label>
                <textarea rows="2" placeholder="Jelaskan jenis event dalam kategori ini..."
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Status</label>
                <select class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl outline-none font-medium focus:border-indigo-600">
                    <option>Aktif</option>
                    <option>Non-Aktif</option>
                </select>
            </div>
        </div>
        <div class="px-8 pb-8 flex gap-3">
            <button onclick="closeModal()"
                class="flex-1 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition">
                Batal
            </button>
            <button onclick="closeModal()"
                class="flex-1 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                Simpan
            </button>
        </div>
    </div>
</div>


{{-- ========== MODAL: EDIT KATEGORI ========== --}}
<div id="modal-edit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="text-xl font-black">Edit Kategori</h3>
            <button onclick="closeEditModal()" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-8 space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Kategori</label>
                <input type="text" id="edit-nama"
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi Singkat</label>
                <textarea rows="2"
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Status</label>
                <select id="edit-status" class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl outline-none font-medium focus:border-indigo-600">
                    <option>Aktif</option>
                    <option>Non-Aktif</option>
                </select>
            </div>
        </div>
        <div class="px-8 pb-8 flex gap-3">
            <button onclick="closeEditModal()"
                class="flex-1 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition">
                Batal
            </button>
            <button onclick="closeEditModal()"
                class="flex-1 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>


{{-- ========== MODAL: HAPUS KONFIRMASI ========== --}}
<div id="modal-hapus" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Hapus Kategori?</h3>
            <p class="text-slate-500 mb-1">Anda akan menghapus kategori:</p>
            <p id="hapus-nama" class="font-black text-rose-600 text-lg mb-4"></p>
            <p class="text-slate-400 text-sm">Tindakan ini tidak dapat dibatalkan. Event dalam kategori ini perlu dipindahkan dulu.</p>
        </div>
        <div class="px-8 pb-8 flex gap-3">
            <button onclick="closeDeleteModal()"
                class="flex-1 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition">
                Batal
            </button>
            <button onclick="closeDeleteModal()"
                class="flex-1 py-3 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 transition shadow-lg shadow-rose-100">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>


{{-- Script modal --}}
<script>
    // Modal Tambah
    function openModal() {
        document.getElementById('modal-tambah').classList.remove('hidden');
        document.getElementById('modal-tambah').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('modal-tambah').classList.add('hidden');
        document.getElementById('modal-tambah').classList.remove('flex');
    }

    // Modal Edit
    function openEditModal(nama, status) {
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-status').value = status;
        document.getElementById('modal-edit').classList.remove('hidden');
        document.getElementById('modal-edit').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('modal-edit').classList.add('hidden');
        document.getElementById('modal-edit').classList.remove('flex');
    }

    // Modal Hapus
    function openDeleteModal(nama) {
        document.getElementById('hapus-nama').textContent = '"' + nama + '"';
        document.getElementById('modal-hapus').classList.remove('hidden');
        document.getElementById('modal-hapus').classList.add('flex');
    }
    function closeDeleteModal() {
        document.getElementById('modal-hapus').classList.add('hidden');
        document.getElementById('modal-hapus').classList.remove('flex');
    }

    // Tutup modal jika klik di luar
    ['modal-tambah', 'modal-edit', 'modal-hapus'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    });
</script>

@endsection