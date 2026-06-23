<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk tab filter
        $categories = Category::all();

        // 2. Ambil semua partner
        $partners = Partner::latest()->get();

        // 3. Buat query dasar — eager loading, hanya event yang belum lewat
        $query = Event::with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');

        // 4. Filter berdasarkan slug kategori jika ada parameter ?category=...
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 5. Eksekusi query
        $events = $query->get();

        return view('welcome', compact('events', 'categories', 'partners'));
    }
}