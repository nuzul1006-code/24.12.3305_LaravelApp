<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-partner');
    }

    public function register(Request $request)
    {
        $request->validate([
            'organizer_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'description'    => 'nullable|string',
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed',
        ]);

        // 1. Buat data Organisasi / Partner (Status default: pending)
        $partner = Partner::create([
            'name'        => $request->organizer_name,
            'slug'        => Str::slug($request->organizer_name) . '-' . Str::random(5),
            'description' => $request->description,
            'phone'       => $request->phone,
            'status'      => 'pending',
        ]);

        // 2. Buat data User dengan role partner dan terhubung ke partner_id
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'partner',
            'partner_id' => $partner->id,
        ]);

        auth()->login($user);

        return redirect()->route('partner.pending');
    }
}