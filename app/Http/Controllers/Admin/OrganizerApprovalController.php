<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class OrganizerApprovalController extends Controller
{
    // Menampilkan daftar semua pengajuan organizer
    public function index()
    {
        $partners = Partner::withCount('events')->latest()->paginate(10);
        return view('admin.organizers.index', compact('partners'));
    }

    // Setujui pengajuan organizer
    public function approve(Partner $partner)
    {
        $partner->update(['status' => 'approved']);
        return back()->with('success', "Organisasi {$partner->name} berhasil disetujui!");
    }

    // Tolak pengajuan organizer
    public function reject(Partner $partner)
    {
        $partner->update(['status' => 'rejected']);
        return back()->with('error', "Organisasi {$partner->name} telah ditolak.");
    }
}