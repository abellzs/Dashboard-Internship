<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-neutral-900 text-gray-800 dark:text-white flex flex-col">

        {{-- Header --}}
        <header class="w-full px-6 py-4 bg-white dark:bg-neutral-800 shadow">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-pioner.png') }}" alt="Pioner Logo" class="h-10">
                    <span class="font-semibold text-lg">Mulailah dari sini, langkah kecil untuk masa depan besar.</span>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        @fluxScripts
    </body>
</html>
