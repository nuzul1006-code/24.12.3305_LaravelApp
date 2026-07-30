<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\PartnerProfileController;
use App\Http\Controllers\ReviewController;

// Import Controller Multi-Tenant Baru
use App\Http\Controllers\Auth\PartnerRegisterController;
use App\Http\Controllers\Admin\OrganizerApprovalController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;

// ===== HALAMAN STATIS =====
Route::get('/tentang', function () {
    return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});
Route::get('/kontak', function () { return view('contact'); });
Route::get('/profil', function () { return view('profil'); });
Route::get('/katalog', function () { return view('katalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });

// ===== USER AREA =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/my-ticket/{order_id}', [EventController::class, 'showTicketDetail'])->name('ticket.detail');

// ===== REVIEWS AND RATINGS =====
Route::get('/reviews/create/{order_id}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

// ===== CHECKOUT FLOW =====
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// ===== MIDTRANS WEBHOOK =====
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

// Redirect /login ke admin login
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ===== GOOGLE SSO ROUTES =====
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/auth/logout', [GoogleController::class, 'logout'])->name('auth.logout');

// ===== MULTI-TENANT: REGISTRASI ORGANIZER & PENDING PAGE =====
Route::middleware('auth')->group(function () {
    Route::get('/register-partner', [PartnerRegisterController::class, 'showRegistrationForm'])->name('register.partner');
    Route::post('/register-partner', [PartnerRegisterController::class, 'register'])->name('register.partner.store');
    
    Route::get('/partner/pending', function () {
        return view('partner.pending');
    })->name('partner.pending');
});

// ===== MULTI-TENANT: DASHBOARD ORGANIZER / PARTNER (Isolasi Data via Middleware 'partner') =====
Route::middleware(['auth', 'partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
});

// ===== PARTNER / ORGANIZER PUBLIC PROFILE =====
// Dipindahkan ke bawah grup dashboard agar '/partner/{partner}' tidak memakan URL '/partner/dashboard'
Route::get('/organizer/{partner:slug}', [PartnerProfileController::class, 'show'])->name('partner.public_profile');
Route::get('/partner/{partner}', [PartnerProfileController::class, 'show'])->name('partner.profile');

// ===== ADMIN & SUPERADMIN AREA =====
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Superadmin: Approval Pengajuan Organizer
    Route::middleware(['auth', 'superadmin'])->group(function () {
        Route::get('/organizers', [OrganizerApprovalController::class, 'index'])->name('organizers.index');
        Route::post('/organizers/{partner}/approve', [OrganizerApprovalController::class, 'approve'])->name('organizers.approve');
        Route::post('/organizers/{partner}/reject', [OrganizerApprovalController::class, 'reject'])->name('organizers.reject');
    });

    // Admin / Management Standard
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::resource('categories', CategoryController::class);
        Route::resource('events', EventAdminController::class);
        Route::resource('partners', PartnerController::class);
    });
});