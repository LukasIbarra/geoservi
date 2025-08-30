<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Geoservi Spa'))</title>
    <link rel="icon" href="/img/logo-geoservi.ico">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- AOS, Swiper, SweetAlert, etc -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- DataTables CSS (solo si se usa en esta vista) -->
    @stack('datatable-css')

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans bg-gray-50 text-gray-800">
    <div id="app">

        <main>
            @include('layouts_pag.navbar')
            @yield('content')
            @include('layouts_pag.footer')
        </main>

        <!-- Modal de Contacto Mejorado -->
        @include('components.contact-modal-improved')

    </div>

    <!-- External JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- DataTables JS (solo si se usa) -->
    @stack('datatable-js')

    <!-- Init scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({ duration: 1200, once: true });
        });
    </script>

    @stack('scripts')
</body>

</html>
