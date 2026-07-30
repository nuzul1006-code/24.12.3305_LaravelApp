<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        // Izinkan admin maupun superadmin untuk auto-redirect ke dashboard
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Izinkan role 'admin' Maupun 'superadmin' untuk masuk
            if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                Auth::logout();
                return back()->with('error', 'Akun ini bukan akun admin.');
            }

            $request->session()->regenerate();
            
            // Jika yang login Superadmin, langsung arahkan ke approval panel organizer
            if (Auth::user()->role === 'superadmin') {
                return redirect()->route('admin.organizers.index');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau Password yang Anda masukkan salah.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}