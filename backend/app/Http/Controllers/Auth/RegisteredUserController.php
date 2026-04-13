<?php

namespace App\Http\Controllers\Auth; // Namespace untuk controller web

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Method ini akan dipanggil oleh GET /register (dari routes/web.php)
     */
    public function create(): View
    {
        // Cukup tampilkan view Blade untuk form registrasi
        return view('auth.register'); // Asumsi ada di resources/views/auth/register.blade.php
    }

    /**
     * Handle an incoming registration request.
     * Method ini akan dipanggil oleh POST /register (dari routes/web.php)
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse // Return type adalah RedirectResponse
    {
        // --- LOGIKA VALIDASI (SAMA SEPERTI DI API\AUTHCONTROLLER) ---
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'npm' => ['required', 'string', 'max:255', 'unique:'.User::class], // Pastikan field npm ada di tabel users
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // --- LOGIKA PEMBUATAN USER (SAMA SEPERTI DI API\AUTHCONTROLLER) ---
        // Kita tidak perlu try-catch di sini, karena jika validasi gagal, Laravel otomatis
        // melempar ValidationException dan redirect kembali ke form dengan error.
        // Jika ada error database lain, Laravel akan menanganinya dengan halaman error default.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'npm' => $request->npm,
            'password' => Hash::make($request->password),
            'role' => 'Mahasiswa', // Default role
        ]);

        // --- (Opsional) Dispatch Event User Registered ---
        event(new Registered($user));

        // --- LANGSUNG LOGIN USER YANG BARU REGISTER (Menggunakan Session Laravel) ---
        Auth::login($user);

        // --- REDIRECT KE HALAMAN SETELAH REGISTRASI BERHASIL ---
        // RouteServiceProvider::HOME biasanya '/dashboard' atau '/home'
        // Mengirim 'success' flash message ke session
        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }
}