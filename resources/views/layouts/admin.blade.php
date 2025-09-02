@props(['breadcrumbs' => []])

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

    <!-- Font awesome-->
    <script src="https://kit.fontawesome.com/597c768540.js" crossorigin="anonymous"></script>

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900"
    x-data="{
    sidebarOpen: false
    }"
    :class="{
        'overflow-y-hidden': sidebarOpen
    }">

    <div class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 opacity-50 z-20 sm:hidden"
        style="display: none;"
        x-show="sidebarOpen"
        x-on:click="sidebarOpen = false">
    </div>

    @include('layouts.partials.admin.navigation')
    @include('layouts.partials.admin.sidebar')

    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="flex justify-between items-center">
                @include('layouts.partials.admin.breadcrumb')
                @isset($action)
                    {{ $action }}
                @endisset
            </div>

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
