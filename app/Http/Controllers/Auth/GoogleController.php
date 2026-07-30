<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToGoogle()
    {
        if (request()->has('event_id')) {
            session(['checkout_event_id' => request('event_id')]);
        }
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and log them in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with the Google ID
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                // Update their token and avatar
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_avatar' => $googleUser->avatar,
                ]);
            } else {
                // Check if user already exists with the same email
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Update user's Google ID, token and avatar
                    $user->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_avatar' => $googleUser->avatar,
                    ]);
                } else {
                    // Create a new user
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_avatar' => $googleUser->avatar,
                        'password' => null, // Google logins do not require password
                        'role' => 'user',
                    ]);
                }
            }

            Auth::login($user);

            // If there's a checkout redirect pending in the session, redirect there
            if (session()->has('checkout_event_id')) {
                $eventId = session()->pull('checkout_event_id');
                return redirect()->route('checkout.create', $eventId)
                    ->with('success', 'Berhasil login dengan Google! Silakan lanjutkan pemesanan tiket Anda.');
            }

            return redirect()->route('home')->with('success', 'Berhasil login dengan Google!');
        } catch (Exception $e) {
            return redirect()->route('home')->with('error', 'Gagal login via Google: ' . $e->getMessage());
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }
}
