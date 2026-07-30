<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Category;
use Illuminate\Http\Request;

class PartnerProfileController extends Controller
{
    public function show(Partner $partner)
    {
        // Pastikan hanya partner yang sudah disetujui (approved) yang bisa diakses publik
        if ($partner->status !== 'approved') {
            abort(404, 'Profil Penyelenggara tidak ditemukan.');
        }

        $categories = Category::all();

        // Hitung rata-rata rating & total ulasan lewat relasi reviews
        $averageRating = $partner->reviews()->avg('rating') ?: 0;
        $totalReviews  = $partner->reviews()->count();

        // Ambil ulasan/testimoni beserta info event & user
        $reviews = $partner->reviews()->with(['event', 'user'])->latest()->paginate(6);

        // Event yang akan datang (Upcoming)
        $upcomingEvents = $partner->events()
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        // Event yang sudah berlalu (Past)
        $pastEvents = $partner->events()
            ->where('date', '<', now())
            ->orderBy('date', 'desc')
            ->get();

        return view('partner-profile', compact(
            'partner',
            'categories',
            'averageRating',
            'totalReviews',
            'reviews',
            'upcomingEvents',
            'pastEvents'
        ));
    }
}