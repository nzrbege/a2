<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'A2') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRhzxePa6asDwpHgFgkVZazQTwMls=" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/alpinejs" defer></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('theme', {
                    dark: localStorage.getItem('theme') !== 'light',
                    toggle() {
                        this.dark = !this.dark;
                        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                    }
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased transition-colors duration-300 bg-slate-100 dark:bg-slate-900" 
          :class="$store.theme.dark ? 'dark' : ''"> <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b transition-colors duration-300 bg-white border-slate-200 shadow-sm dark:bg-slate-800 dark:border-slate-700/60">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <h2 class="text-base font-semibold text-slate-700 dark:text-slate-200">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
            </main>

            @stack('scripts')
        </div>
    </body>
</html>