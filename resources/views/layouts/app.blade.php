<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cedar: {
                            50: '#fbf6f1',
                            100: '#f5ebdf',
                            200: '#e9d4bf',
                            300: '#dbb696',
                            400: '#cc926b',
                            500: '#c1784e',
                            600: '#b36443',
                            700: '#955039',
                            800: '#794133',
                            900: '#62372c',
                            950: '#3c1f19',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #fbf6f1; /* cedar-50 */
            color: #3c1f19; /* cedar-950 */
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #3c1f19 0%, #62372c 100%);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #dbb696;
            border-radius: 10px;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen overflow-hidden antialiased">

    {{-- Overlay --}}
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/20 hidden lg:hidden z-40">
    </div>

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col h-screen overflow-hidden">

        {{-- Header --}}
        @include('layouts.partials.header')

        {{-- Page Content --}}
        <div class="flex-1 overflow-y-auto p-6 lg:p-10">

            @yield('content')

        </div>

    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

</body>
</html>