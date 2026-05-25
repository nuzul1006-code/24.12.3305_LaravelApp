<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

// ===== HALAMAN STATIS (dari pertemuan 2) =====
Route::get('/tentang', function () {
    return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});
Route::get('/kontak', function () {
    return view('contact');
});
Route::get('/profil', function () {
    return view('profil');
});
Route::get('/katalog', function () {
    return view('katalog');
});
Route::get('/bantuan', function () {
    return view('bantuan');
});

// ===== USER AREA =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// ===== ADMIN AREA =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::resource('categories', CategoryController::class);
    Route::resource('events', EventAdminController::class);
    Route::resource('partners', PartnerController::class); // ← TAMBAH INI
});