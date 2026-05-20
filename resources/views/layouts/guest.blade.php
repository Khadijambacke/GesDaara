<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="h-screen w-screen flex flex-col items-center justify-start pt-10 sm:pt-16 p-6 bg-cedar-50/50 overflow-hidden">
            
            <div class="mb-6 flex flex-col items-center">
                <a href="/" class="flex flex-col items-center gap-3">
                    <div class="w-16 h-16 bg-cedar-900 text-cedar-50 rounded-2xl flex items-center justify-center shadow-lg shadow-cedar-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black text-cedar-950 tracking-tight">SunuDaara</h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl shadow-cedar-950/5 border border-cedar-100 rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>
