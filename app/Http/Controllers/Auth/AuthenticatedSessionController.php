<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        $url = "/login"; // Default fallback url

        // Sesuaikan dengan enum di Database ('Admin', 'Staff', 'Pimpinan')
        if (Auth::user()->role === "Admin") {
            $url = "admin/dashboard";
        } elseif (Auth::user()->role === "Staff") {
            $url = "karyawan/dashboard";
        } elseif (Auth::user()->role === "Pimpinan") {
            $url = "pimpinan/dashboard";
        }

        // Redirect ke intended URL (atau URL default berdasarkan role)
        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Setelah logout, arahkan kembali ke halaman login
        return redirect('/login'); 
    }
}