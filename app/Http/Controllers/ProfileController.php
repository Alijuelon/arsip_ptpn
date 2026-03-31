<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * (Opsional: Tetap dipertahankan bawaan Laravel jika sewaktu-waktu butuh halaman khusus)
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information from Modal.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Validasi Input Kustom (Langsung di controller agar lebih mudah disesuaikan)
        $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'], // Validasi jika password diisi
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.'
        ]);

        $user = $request->user();

        // 2. Update Data Profil Utama
        $user->nama_user = $request->nama_user;
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 3. Update Password (Hanya jika field password di form tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Simpan Perubahan
        $user->save();

        // 5. Kembali ke halaman sebelumnya (tutup modal) dengan notifikasi sukses
        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     * (Bawaan Laravel, dibiarkan jika sewaktu-waktu fitur hapus akun sendiri diaktifkan)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}