<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Icono de pestaña -->
        <link rel="icon" href="{{ asset('assets/icon/logo.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @stack('css')

        <!-- Font awesome-->
        <script src="https://kit.fontawesome.com/597c768540.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('shop.navigation')

            <!-- Page Content -->
            <main class="flex-1 content-center">
                {{ $slot }}
            </main>

            <div class="mt-8">
                @include('layouts.partials.shop.footer')
            </div>

        </div>

        @stack('modals')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireScripts

        @stack('js')

        @if (session('swal'))
            <script>
                Swal.fire({!! json_encode(session('swal')) !!})
            </script>
        @endif

        <script>
            Livewire.on('swal', data => {
                Swal.fire(data[0]);
            });
        </script>
    </body>
</html>
