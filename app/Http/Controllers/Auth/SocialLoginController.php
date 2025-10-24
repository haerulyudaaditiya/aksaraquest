<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Arahkan pengguna ke halaman autentikasi Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani respons (callback) dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            // 1. Ambil data pengguna dari Google
            $googleUser = Socialite::driver('google')->user();

            // 2. Logika "Cari atau Buat" yang profesional
            $user = User::updateOrCreate(
                [
                    'google_id' => $googleUser->getId(),
                ],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(str()->random(24)), // Buat password acak (wajib ada)
                    'email_verified_at' => now(), // Anggap sudah terverifikasi
                ]
            );

            // 3. Loginkan pengguna
            Auth::login($user);

            // 4. Arahkan ke Dashboard
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            // Jika terjadi error (misal: pengguna membatalkan)
            return redirect()->route('login')->withErrors(['email' => 'Login via Google gagal. Silakan coba lagi.']);
        }
    }
}