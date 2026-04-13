@extends('layouts.app')

@section('title', 'Login - LabSys')

@push('styles')
{{-- CSS untuk animasi blob (sama seperti register) --}}
<style>
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 p-4 transition-colors duration-300 overflow-hidden">
    <div class="w-full max-w-md z-10">
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                {{-- Beaker Icon SVG --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white lucide lucide-beaker"><path d="M4.5 3h15"/><path d="M6 3v16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3"/><path d="M6 14h12"/></svg>
            </div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400">LabSys</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Laboratory Information System</p>
        </div>

        <div class="border-none shadow-xl overflow-hidden bg-white dark:bg-gray-800 rounded-lg">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
            <div class="p-6 space-y-1">
                <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Login</h2>
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    Enter your NPM and password to access the system
                </p>
            </div>

            <div class="p-6">
                {{-- Menampilkan error validasi dari Laravel (dari LoginRequest) --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Oops! Login Gagal:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Menampilkan flash message sukses (misalnya setelah logout atau redirect lain) --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                 @if (session('status')) {{-- Untuk pesan seperti reset password link sent --}}
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="space-y-4">
                        {{-- Input NPM --}}
                        <div>
                            <label for="npm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NPM (Student ID)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    {{-- AtSign Icon SVG --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 lucide lucide-at-sign"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"/></svg>
                                </span>
                                <input id="npm" name="npm" type="text" placeholder="Enter your NPM" value="{{ old('npm') }}" required autofocus
                                       class="block w-full h-12 pl-10 pr-3 py-2 border @error('npm') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                            </div>
                            @error('npm') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            {{-- Pesan error umum untuk npm/password salah biasanya ditampilkan di $errors->any() atau @error('npm') jika LoginRequest Anda set pesan untuk field 'npm' --}}
                        </div>

                        {{-- Input Password --}}
                        <div x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                 <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    {{-- Lock Icon SVG --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 lucide lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" placeholder="Enter your password" required autocomplete="current-password"
                                       class="block w-full h-12 pl-10 pr-10 py-2 border @error('password') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    {{-- Eye/EyeOff Icon SVGs --}}
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg x-show="showPassword" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Pilihan Role (UI SAJA, tidak dikirim ke backend untuk proses login standar Laravel) --}}
                        {{-- Jika role ini PENTING untuk backend login, Anda perlu menambahkannya sebagai field tersembunyi atau memodifikasi LoginRequest --}}
                        <div class="space-y-2" x-data="{ selectedRole: 'mahasiswa' }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Role</label>
                            <div class="flex flex-col space-y-1">
                                <label for="mahasiswa"
                                       class="flex items-center space-x-3 rounded-md border p-3 cursor-pointer transition-colors dark:border-gray-600"
                                       :class="{ 'bg-blue-50 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700 ring-2 ring-blue-500': selectedRole === 'mahasiswa', 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700': selectedRole !== 'mahasiswa' }">
                                    <input type="radio" name="role_ui" value="mahasiswa" id="mahasiswa" x-model="selectedRole" class="hidden">
                                     {{-- UserCircle Icon SVG --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 lucide lucide-user-circle"><path d="M18 20a6 6 0 0 0-12 0"/><circle cx="12" cy="10" r="4"/><circle cx="12" cy="12" r="10"/></svg>
                                    Mahasiswa (Student)
                                </label>
                                <label for="aslab"
                                       class="flex items-center space-x-3 rounded-md border p-3 cursor-pointer transition-colors dark:border-gray-600"
                                       :class="{ 'bg-purple-50 dark:bg-purple-900/30 border-purple-300 dark:border-purple-700 ring-2 ring-purple-500': selectedRole === 'aslab', 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700': selectedRole !== 'aslab' }">
                                    <input type="radio" name="role_ui" value="aslab" id="aslab" x-model="selectedRole" class="hidden">
                                    {{-- Users Icon SVG --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-500 lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    Aslab (Lab Assistant)
                                </label>
                            </div>
                            {{-- Jika Anda PERLU mengirim role ini ke backend:
                            <input type="hidden" name="role" :value="selectedRole">
                            Dan pastikan LoginRequest menangani field 'role' ini jika diperlukan untuk logika backend.
                            Biasanya, role didapat dari user setelah login, bukan sebagai input. --}}
                        </div>

                        {{-- Ingat Saya & Lupa Password --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Ingat Saya</label>
                            </div>
                            {{-- Anda bisa menambahkan link Lupa Password jika ada fiturnya --}}
                            {{-- <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Lupa password?
                                </a>
                            </div> --}}
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="w-full h-12 flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                             {{-- LogIn Icon SVG --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 lucide lucide-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                            Sign In
                        </button>
                    </div>
                </form>
            </div>

            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-400">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- Decorative elements --}}
    <div class="fixed top-20 right-20 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="fixed bottom-20 left-20 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="fixed bottom-40 right-40 w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
</div>
@endsection

@push('scripts')
{{-- Alpine.js sudah di-bundle di app.js jika Anda mengaturnya --}}
@endpush