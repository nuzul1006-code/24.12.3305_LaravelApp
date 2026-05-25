<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categoryId = request('category');

        $events = Event::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $partners   = Partner::latest()->get();
        $categories = Category::withCount('events')->get();

        return view('welcome', compact('events', 'partners', 'categories'));
    }
}