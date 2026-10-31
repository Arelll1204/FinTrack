<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FinTrack') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-page-bg text-text-primary min-h-screen selection:bg-accent selection:text-page-bg flex flex-col justify-between">
        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <!-- Minimal Footer -->
        <footer class="py-4 text-center text-xs text-text-secondary/60 border-t border-border/40">
            &copy; {{ date('Y') }} FinTrack &bull; Personal Financial Management. All rights reserved.
        </footer>
    </body>
</html>
