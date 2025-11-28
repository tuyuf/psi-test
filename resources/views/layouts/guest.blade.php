<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi Psikologi')</title>

    {{-- CSS/asset proyek kamu. Pakai yang sama seperti layout utama --}}
    {{-- Jika proyekmu ada file app.css/js via Vite/Mix, aktifkan salah satu di bawah --}}
    {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <style>
        /* bantu pusatkan konten 1 layar */
        .vh-100 { min-height: 100vh; }
    </style>
</head>
<body class="bg-light">
    {{-- TANPA NAVBAR/ SIDEBAR --}}

    {{-- Konten halaman guest --}}
    <main>
        @yield('content')
    </main>

    {{-- JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
