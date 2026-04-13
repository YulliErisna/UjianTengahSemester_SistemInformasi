<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Menggunakan locale aplikasi Laravel --}}
  <head>
    <meta charset="utf-8" />
    {{-- Asumsikan favicon.ico ada di folder backend/public/ --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta
      name="description"
      content="@yield('meta_description', 'Deskripsi default aplikasi LabSys Anda')" {{-- Deskripsi bisa dinamis per halaman --}}
    />
    {{-- Asumsikan logo192.png ada di folder backend/public/ --}}
    <link rel="apple-touch-icon" href="{{ asset('logo192.png') }}" />
    {{-- Asumsikan manifest.json ada di folder backend/public/ --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}" />

    {{-- Judul halaman akan dinamis --}}
    <title>@yield('title', config('app.name', 'LabSys'))</title> {{-- Judul default atau dari config app.name --}}

    {{-- Memuat CSS dan JS utama yang dikompilasi oleh Vite --}}
    {{-- Pastikan file ini ada: backend/resources/css/app.css dan backend/resources/js/app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Untuk CSS tambahan yang spesifik per halaman (jika ada) --}}
    @stack('styles')
  </head>
  <body>
    <noscript>Anda perlu mengaktifkan JavaScript untuk menjalankan aplikasi ini.</noscript>

    {{-- Tempat konten utama dari view Blade lain akan diinjeksikan --}}
    {{-- Ini menggantikan <div id="root"></div> --}}
    <div id="app-container"> {{-- Anda bisa memberi ID jika mau, tapi tidak harus 'root' --}}
        {{-- Anda bisa menambahkan elemen layout global di sini, seperti header, sidebar, dll. --}}
        {{-- @include('layouts.partials.header') --}}
        {{-- @include('layouts.partials.sidebar') --}}

        <main class="py-4"> {{-- Contoh wrapper main content --}}
            @yield('content')
        </main>

        {{-- @include('layouts.partials.footer') --}}
    </div>

    {{-- Untuk skrip JavaScript tambahan yang spesifik per halaman (jika ada) --}}
    @stack('scripts')
  </body>
</html>