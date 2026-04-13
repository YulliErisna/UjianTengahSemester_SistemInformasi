<?php

namespace App\Http\Controllers\Auth; // Namespace untuk controller web

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Kita akan buat Form Request ini untuk validasi login

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// Hapus jika tidak ada error khusus seperti ValidationException dari Auth::attempt
// use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * Method ini akan dipanggil oleh GET /login (dari routes/web.php)
     */
    public function create(): View
    {
        // Tampilkan view Blade untuk form login
        return view('auth.login'); // Asumsi ada di resources/views/auth/login.blade.php
    }

    /**
     * Handle an incoming authentication request.
     * Method ini akan dipanggil oleh POST /login (dari routes/web.php)
     */
    public function store(LoginRequest $request): RedirectResponse // Menggunakan LoginRequest untuk validasi
    {
        // LoginRequest akan menangani validasi input 'npm' dan 'password'
        // dan mencoba melakukan autentikasi.

        // Jika authenticate() di LoginRequest berhasil, user sudah login.
        // Sekarang kita perlu regenerate session ID untuk keamanan.
        $request->session()->regenerate();

        // Redirect ke halaman yang dituju setelah login berhasil.
        // RouteServiceProvider::HOME biasanya '/dashboard' atau '/home'
        return redirect()->intended('/dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');
    }

    /**
     * Destroy an authenticated session (logout).
     * Method ini akan dipanggil oleh POST /logout (dari routes/web.php)
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Logout user dari guard 'web' (default session guard)

        $request->session()->invalidate(); // Invalidate session lama

        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login')->with('success', 'Anda telah berhasil logout.'); // Redirect ke halaman login
    }
}