<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="svg">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @filamentStyles

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

    {{-- Header --}}
    @include('components.layouts.app.header')

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.layouts.app.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>

    @livewireScripts

    @filamentScripts

</body>
</html>
