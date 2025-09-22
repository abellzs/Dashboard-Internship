<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>Internship Witel Yogya Jateng Selatan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Konten full screen -->
    <main class="w-full min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer (optional, bisa dihilangkan atau dibuat fixed) -->
    <footer class="text-center text-sm text-gray-400 py-4">
        &copy; 2025 Pioneer. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
