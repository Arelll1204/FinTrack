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
    <body class="font-sans antialiased bg-page-bg text-text-primary min-h-screen">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col md:flex-row bg-page-bg">
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Mobile top bar -->
                <div class="md:hidden flex items-center justify-between bg-nav-bg border-b border-border px-4 py-3 sticky top-0 z-30">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-accent/15 border border-accent/30 flex items-center justify-center text-accent font-bold text-base">
                            FT
                        </div>
                        <span class="font-bold text-text-primary text-lg tracking-tight">FinTrack</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen"
                            type="button"
                            aria-label="Toggle navigation"
                            class="p-2 rounded-lg text-text-secondary hover:text-text-primary hover:bg-surface focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-surface/40 border-b border-border">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
