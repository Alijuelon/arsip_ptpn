<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GmailAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/gmail.readonly']) // Izin khusus baca email
            ->with(['access_type' => 'offline', 'prompt' => 'consent']) // Wajib agar dapat Refresh Token
            ->redirect();
    }

    // 2. Menangkap balasan dari Google setelah staf klik "Izinkan"
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = Auth::user();

            // Simpan token ke database staf yang sedang login
            $user->update([
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
                'google_email' => $googleUser->email,
            ]);

            return redirect()->route('karyawan.email.index')
                ->with('success', 'Berhasil! Akun Gmail Anda telah terhubung dengan Aplikasi Arsip.');

        } catch (\Exception $e) {
            return redirect()->route('karyawan.email.index')
                ->with('error', 'Gagal menghubungkan ke Gmail: ' . $e->getMessage());
        }
    }
    
    // 3. (Opsional) Fitur untuk memutuskan koneksi Gmail
    public function disconnect()
    {
        $user = Auth::user();
        $user->update([
            'google_access_token' => null,
            'google_refresh_token' => null,
        ]);

        return back()->with('success', 'Koneksi Gmail berhasil diputuskan.');
    }
}