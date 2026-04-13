@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
        <p class="text-lg text-gray-600">
            Selamat datang, {{ Auth::user()->name }}! 
            ({{ Auth::user()->email }} - Role: {{ Auth::user()->role }})
        </p>
    </div>
    
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Status Akun</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 border rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ Auth::user()->npm ?? 'N/A' }}</div>
                <div class="text-sm text-gray-500">NPM</div>
            </div>
            <div class="text-center p-4 border rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ Auth::user()->role }}</div>
                <div class="text-sm text-gray-500">Role</div>
            </div>
            <div class="text-center p-4 border rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ now()->format('d M Y') }}</div>
                <div class="text-sm text-gray-500">Tanggal</div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">Inventaris</h3>
            <p class="text-blue-600">Kelola peralatan laboratorium</p>
        </div>
        <div class="bg-green-50 border-l-4 border-green-400 p-6 rounded-r-lg">
            <h3 class="text-lg font-semibold text-green-800 mb-2">Peminjaman</h3>
            <p class="text-green-600">Lihat riwayat peminjaman</p>
        </div>
        <div class="bg-purple-50 border-l-4 border-purple-400 p-6 rounded-r-lg">
            <h3 class="text-lg font-semibold text-purple-800 mb-2">Laboratorium</h3>
            <p class="text-purple-600">Pesan ruang lab</p>
        </div>
    </div>
</div>
@endsection

