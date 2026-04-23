<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'A2') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>
        <script src="https://unpkg.com/alpinejs" defer></script>
        {{-- <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('theme', {
                    dark: localStorage.getItem('theme') !== 'light',
                    toggle() {
                        this.dark = !this.dark;
                        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                    }
                });
            });
        </script> --}}
    </head>
    <body class="font-sans antialiased transition-colors duration-300 bg-slate-100 dark:bg-slate-900">
        {{ $slot }}
    </body>
</html>
