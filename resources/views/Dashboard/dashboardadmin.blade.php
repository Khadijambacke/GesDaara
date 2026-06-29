<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SunuDaara</title>
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
                        },
                        emerald: {
                            50: '#f7f9f6',
                            100: '#ebf0ea',
                            200: '#d4dfd2',
                            300: '#b4c7b1',
                            400: '#8fa98b',
                            500: '#6f8c6b',
                            600: '#556f51',
                            650: '#486045',
                            700: '#42573f',
                            800: '#364634',
                            900: '#2d3a2b',
                            950: '#161d15',
                        },
                        green: {
                            50: '#f7f9f6',
                            100: '#ebf0ea',
                            200: '#d4dfd2',
                            300: '#b4c7b1',
                            400: '#8fa98b',
                            500: '#6f8c6b',
                            600: '#556f51',
                            650: '#486045',
                            700: '#42573f',
                            800: '#364634',
                            900: '#2d3a2b',
                            950: '#161d15',
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
</head>
<body class="flex min-h-screen overflow-hidden antialiased">

    <!-- Mobile Overlay -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-cedar-950/20 backdrop-blur-sm hidden lg:hidden z-40"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 sidebar-gradient text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col border-r border-cedar-900">
        
        <!-- Logo Section -->
        <div class="h-24 flex items-center px-8 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-cedar-400 rounded-xl flex items-center justify-center shadow-lg shadow-cedar-950/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">SunuDaara</h1>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-8 px-4 custom-scrollbar">
            <div class="space-y-1">
                <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">Principal</p>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-medium transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Tableau de bord</span>
                </a>

                <a href="{{route('Toutmembre')}}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Gestion des Membres</span>
                </a>

                <a href="{{ route('Toutcellule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                    </svg>
                    <span>Gestion des Cellules</span>
                </a>
            </div>

            <div class="mt-8 space-y-1">
                <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">Finance</p>
                
                <a href="{{ route('admin.cotisations') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Cotisations</span>
                </a>

                <a href="{{ route('admin.depenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    <span>Dépenses</span>
                </a>
            </div>

            <div class="mt-8 space-y-1">
                <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">Organisation</p>
                
                <a href="{{ route('Toutevenement') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Événements</span>
                </a>

                <a href="{{ route('admin.commissions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Commissions</span>
                </a>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-6 bg-cedar-950/50">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/5 border border-white/10">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold truncate">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                    <p class="text-[10px] text-cedar-400 truncate uppercase tracking-tighter">Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 hover:bg-white/10 rounded-lg text-cedar-400 hover:text-white transition-all" title="Se déconnecter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Header -->
        <header class="h-24 bg-white/80 backdrop-blur-md border-b border-cedar-200 flex items-center justify-between px-10 flex-shrink-0 z-30">
            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 bg-cedar-100 rounded-lg text-cedar-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                <div>
                    <h2 class="text-2xl font-extrabold text-cedar-950 tracking-tight">Espace Administrateur</h2>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col text-right">
                    <p id="realtime-date-admin" class="text-xs font-bold text-cedar-950 uppercase tracking-widest">...</p>
                    <p id="realtime-time-admin" class="text-[10px] text-cedar-500 font-bold">Heure locale: --:--</p>
                </div>
                
                <div class="w-px h-8 bg-cedar-200"></div>

                <div class="relative group">
                    <button class="p-3 bg-cedar-100 rounded-2xl text-cedar-800 hover:bg-cedar-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 w-4 h-4 bg-cedar-600 text-white text-[9px] font-black rounded-full border-2 border-white flex items-center justify-center">2</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 space-y-10 custom-scrollbar">
            
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- KPI 1: Membres -->
                <div class="bg-white rounded-[2rem] p-6 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex items-center gap-5">
                    <div class="w-14 h-14 bg-cedar-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-cedar-400 font-black uppercase tracking-wider truncate">Total Membres</p>
                        <p class="text-xl xl:text-2xl font-black text-cedar-950 mt-1 whitespace-nowrap">{{ number_format($totalMembres, 0, ',', ' ') }}</p>
                    </div>
                </div>

                <!-- KPI 2: Total Cotisé -->
                <div class="bg-cedar-900 rounded-[2rem] p-6 text-white shadow-xl shadow-cedar-950/10 flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-cedar-300 font-black uppercase tracking-wider truncate">Total Cotisé</p>
                        <p class="text-xl xl:text-2xl font-black mt-1 whitespace-nowrap">{{ number_format($totalCotise, 0, ',', ' ') }} <span class="text-xs font-semibold text-cedar-200">F</span></p>
                    </div>
                </div>

                <!-- KPI 3: Événements Actifs -->
                <div class="bg-white rounded-[2rem] p-6 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex items-center gap-5">
                    <div class="w-14 h-14 bg-cedar-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-cedar-400 font-black uppercase tracking-wider truncate">Événements Actifs</p>
                        <p class="text-xl xl:text-2xl font-black text-cedar-950 mt-1 whitespace-nowrap">{{ number_format($evenementsActifs, 0, ',', ' ') }}</p>
                    </div>
                </div>

                <!-- KPI 4: Cellules -->
                <div class="bg-white rounded-[2rem] p-6 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex items-center gap-5">
                    <div class="w-14 h-14 bg-cedar-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-cedar-400 font-black uppercase tracking-wider truncate">Cellules / Sections</p>
                        <p class="text-xl xl:text-2xl font-black text-cedar-950 mt-1 whitespace-nowrap">{{ number_format($totalCellules, 0, ',', ' ') }}</p>
                    </div>
                </div>
            </div>
           
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
                
                <!-- Transactions / Table Section -->
                <div class="xl:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-5 md:p-8 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-cedar-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        
                        <div class="flex justify-between items-end mb-10 relative z-10">
                            <div>
                                <h3 class="text-2xl font-black text-cedar-950 tracking-tight">Dernières Activités Financières</h3>
                                <p class="text-sm text-cedar-500 font-medium mt-1">Suivi détaillé des cotisations récentes par communauté.</p>
                            </div>
                            <button class="px-6 py-3 bg-cedar-900 text-cedar-50 text-xs font-bold rounded-2xl hover:bg-cedar-950 shadow-lg shadow-cedar-950/20 transition-all flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                </svg>
                                Nouvelle Opération
                            </button>
                        </div>

                        <div class="overflow-hidden relative z-10">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-cedar-400 text-[11px] font-black uppercase tracking-[0.2em] border-b border-cedar-100">
                                        <th class="pb-6">Identité du Membre</th>
                                        <th class="pb-6">Date d'opération</th>
                                        <th class="pb-6">Montant</th>
                                        <th class="pb-6 text-center">État</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-cedar-50">
                                    @forelse($dernieresCotisations as $cotis)
                                    @php
                                        $mbr = $cotis->users;
                                        $initials = $mbr ? strtoupper(substr($mbr->prenom ?? $mbr->Prenom ?? 'M', 0, 1) . substr($mbr->nom ?? $mbr->Nom ?? 'B', 0, 1)) : '??';
                                    @endphp
                                    <tr class="group hover:bg-cedar-50/50 transition-colors">
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-cedar-100 flex items-center justify-center font-black text-cedar-900 text-sm">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-cedar-950">{{ $mbr ? ($mbr->prenom ?? $mbr->Prenom) : 'Membre Inconnu' }} {{ $mbr ? ($mbr->nom ?? $mbr->Nom) : '' }}</p>
                                                    <p class="text-[11px] text-cedar-500 font-bold uppercase tracking-widest">{{ ($mbr && $mbr->cellule) ? $mbr->cellule->nomsection : 'Sans section' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-bold text-cedar-900">{{ \Carbon\Carbon::parse($cotis->datecotisations)->format('d M Y') }}</p>
                                            <p class="text-[10px] text-cedar-400 font-bold">{{ $cotis->created_at ? $cotis->created_at->format('H:i:s') : '--:--:--' }}</p>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-black text-cedar-950">{{ number_format($cotis->montantcotise, 0, ',', ' ') }} <span class="text-[10px] text-cedar-500">FCFA</span></p>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 bg-green-50 text-green-700 text-[10px] font-black rounded-xl border border-green-100 uppercase tracking-widest">{{ str_replace('_', ' ', $cotis->methodepayement) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-xs text-cedar-400 font-bold">Aucune cotisation récente</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('admin.cotisations') }}" class="px-8 py-3 text-[11px] font-black text-cedar-800 uppercase tracking-[0.2em] bg-cedar-50 rounded-2xl hover:bg-cedar-100 transition-all">Consulter l'intégralité</a>
                        </div>
                    </div>
                </div>

                <!-- Lateral / Activity Section -->
                <div class="space-y-10">
                    
                    <!-- Calendar / Next Event -->
                    <div class="bg-cedar-900 rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 text-white shadow-2xl shadow-cedar-950/20 relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform duration-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        
                        <h4 class="text-xl font-black mb-6 relative z-10">Prochain Événement</h4>
                        
                        @if($prochainEvenement)
                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10 relative z-10 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 bg-cedar-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest">{{ $prochainEvenement->statut }}</span>
                                <span class="text-[11px] font-bold text-cedar-200 uppercase tracking-widest">{{ \Carbon\Carbon::parse($prochainEvenement->datedebut)->diffForHumans() }}</span>
                            </div>
                            <p class="text-lg font-extrabold leading-tight">{{ $prochainEvenement->titre }}</p>
                            <div class="flex items-center gap-2 mt-4 text-cedar-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs font-medium">{{ $prochainEvenement->lieu ?? 'Lieu non défini' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('Toutevenement') }}" class="block w-full text-center py-4 bg-cedar-100 text-cedar-950 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-white transition-all shadow-xl shadow-black/10">Planifier & Gérer</a>
                        @else
                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10 relative z-10 mb-8 text-center text-cedar-200">
                            Aucun événement à venir
                        </div>
                        <a href="{{ route('Toutevenement') }}" class="block w-full text-center py-4 bg-cedar-100 text-cedar-950 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-white transition-all shadow-xl shadow-black/10">Créer un événement</a>
                        @endif
                    </div>

                    <!-- Responsibles List -->
                    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-5 md:p-8 border border-cedar-100 shadow-xl shadow-cedar-950/5">
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-8">Responsables de Zone</h4>
                        
                        <div class="space-y-6">
                            @forelse($responsables as $resp)
                            @php
                                $initials = strtoupper(substr($resp->prenom ?? $resp->Prenom ?? 'R', 0, 1) . substr($resp->nom ?? $resp->Nom ?? 'S', 0, 1));
                            @endphp
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-2xl overflow-hidden border-2 border-cedar-50 bg-cedar-500 flex items-center justify-center font-bold text-white text-xs">{{ $initials }}</div>
                                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-4 border-white"></div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-cedar-950 group-hover:text-cedar-600 transition-colors">{{ $resp->prenom ?? $resp->Prenom }} {{ $resp->nom ?? $resp->Nom }}</p>
                                        <p class="text-[10px] text-cedar-400 font-bold uppercase tracking-widest">{{ $resp->cellule->nomsection ?? 'Sans section' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('Toutmembre') }}" class="p-2 text-cedar-300 hover:text-cedar-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                            @empty
                            <p class="text-xs text-cedar-400 font-bold text-center py-6">Aucun responsable assigné</p>
                            @endforelse
                        </div>

                        <div class="mt-8 pt-6 border-t border-cedar-50">
                            <a href="{{ route('Toutmembre') }}" class="block text-center w-full text-[10px] font-black text-cedar-500 hover:text-cedar-950 uppercase tracking-[0.2em] transition-all">Consulter tout l'annuaire</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Data Visualizations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pb-10">
                <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-2">Répartition par Section</h4>
                        <p class="text-xs text-cedar-400 font-bold mb-8">Statistiques de contribution par zone</p>
                    </div>
                    @php
                        $maxSectionTotal = $repartitionSections->max('total') ?: 1;
                    @endphp
                    <div class="flex items-end gap-3 h-32 w-full justify-between px-2">
                        @forelse($repartitionSections as $sec)
                            @php
                                $height = ($sec->total / $maxSectionTotal) * 100;
                                $height = max(10, min(100, $height));
                            @endphp
                            <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                                <div class="absolute -top-8 bg-cedar-950 text-white text-[9px] px-2 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20 shadow-md">
                                    {{ number_format($sec->total, 0, ',', ' ') }} FCFA
                                </div>
                                <div class="w-full bg-cedar-700 rounded-t-xl hover:bg-cedar-500 transition-all duration-300 cursor-pointer" style="height: {{ $height }}%;"></div>
                                <span class="mt-2 text-[9px] font-black text-cedar-400 uppercase tracking-widest truncate w-full text-center" title="{{ $sec->nomsection }}">
                                    {{ substr($sec->nomsection, 0, 5) }}.
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-cedar-400 font-bold text-center w-full py-12">Aucune donnée de section</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-2">Progression Mensuelle</h4>
                        <p class="text-xs text-cedar-400 font-bold mb-8">Flux de cotisations validées</p>
                    </div>
                    @php
                        $maxMonthTotal = $progressionMensuelle->max('total') ?: 1;
                        $points = "";
                        $count = count($progressionMensuelle);
                        foreach($progressionMensuelle as $index => $pm) {
                            $x = $count > 1 ? ($index / ($count - 1)) * 100 : 50;
                            $y = 40 - (($pm->total / $maxMonthTotal) * 35);
                            $points .= "$x,$y ";
                        }
                    @endphp
                    <div class="relative h-32 w-full flex items-center justify-center border-b border-l border-cedar-100 px-2">
                        @if($count > 0)
                        <svg class="w-full h-full" viewBox="0 0 100 40" preserveAspectRatio="none">
                            @php
                                $areaPoints = "0,40 " . $points . " 100,40";
                                if($count === 1) { $areaPoints = "0,40 50,20 100,40"; }
                            @endphp
                            <polygon points="{{ $areaPoints }}" fill="url(#grad)" opacity="0.15" />
                            <path d="M {{ $count === 1 ? '0,20 L 100,20' : str_replace(' ', ' L ', trim($points)) }}" fill="none" stroke="#b36443" stroke-width="2.5" stroke-linecap="round" />
                            
                            <defs>
                                <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#b36443" />
                                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                        </svg>
                        
                        @foreach($progressionMensuelle as $index => $pm)
                            @php
                                $left = $count > 1 ? ($index / ($count - 1)) * 88 + 6 : 50;
                                $top = 100 - (($pm->total / $maxMonthTotal) * 80);
                                $top = max(10, min(90, $top));
                            @endphp
                            <div class="absolute w-2 h-2 bg-cedar-950 rounded-full group cursor-pointer" style="left: {{ $left }}%; top: {{ $top }}%;">
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-cedar-950 text-white text-[8px] font-bold rounded px-1.5 py-0.5 shadow-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                    {{ $pm->mois }} : {{ number_format($pm->total, 0, ',', ' ') }} F
                                </div>
                            </div>
                        @endforeach
                        @else
                        <p class="text-xs text-cedar-400 font-bold text-center">Aucune cotisation enregistrée</p>
                        @endif
                    </div>
                    <div class="mt-6 flex justify-between text-[9px] font-black text-cedar-400 uppercase tracking-widest px-2">
                        @foreach($progressionMensuelle as $pm)
                            @php
                                $dateObj = \Carbon\Carbon::createFromFormat('Y-m', $pm->mois);
                                $monthName = $dateObj->translatedFormat('M');
                            @endphp
                            <span>{{ $monthName }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ===== MA CARTE OFFICIELLE (Admin) ===== -->
            <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 pb-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-black text-cedar-950">Ma Carte Officielle</h2>
                    <span class="text-xs text-cedar-400 font-semibold">Carte de l'administrateur</span>
                </div>

                <div id="member-card-render"
                     class="w-full max-w-[520px] rounded-[1.2rem] overflow-hidden shadow-2xl border border-cedar-200 select-none"
                     style="background: #fbf6f1;">

                    <div style="background: linear-gradient(135deg, #3c1f19 0%, #62372c 60%, #955039 100%); height: 10px;"></div>

                    <div class="flex" style="min-height: 200px;">
                        <div class="flex flex-col items-center justify-between py-5 px-4 flex-shrink-0"
                             style="width: 140px; background: linear-gradient(180deg, #3c1f19 0%, #62372c 100%);">
                            <div class="text-center">
                                <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center mx-auto mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#dbb696" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <p style="color: #dbb696; font-size: 8px; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase;">SunuDaara</p>
                            </div>
                            <div class="rounded-xl overflow-hidden border-2 shadow-lg" style="width: 88px; height: 100px; border-color: rgba(219,182,150,0.4); background: #2d1612;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->prenom . ' ' . Auth::user()->nom) }}&background=f5ebdf&color=3c1f19&bold=true&size=128&format=png"
                                     alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="text-center">
                                <span style="background: rgba(219,182,150,0.15); color: #dbb696; font-size: 8px; font-weight: 900; letter-spacing: 0.12em; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(219,182,150,0.3);">
                                    Administrateur
                                </span>
                            </div>
                        </div>

                        <div style="width: 1px; background: #e9d4bf; flex-shrink: 0;"></div>

                        <div class="flex flex-col justify-between flex-1 py-4 px-5">
                            <div class="border-b pb-2 mb-3" style="border-color: #e9d4bf;">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p style="font-size: 10px; font-weight: 900; color: #795039; letter-spacing: 0.2em; text-transform: uppercase;">Carte de Membre</p>
                                        <h3 style="font-size: 15px; font-weight: 900; color: #3c1f19; letter-spacing: 0.05em; text-transform: uppercase; margin-top: 1px;">
                                            {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                                        </h3>
                                    </div>
                                    <span style="font-size: 9px; font-weight: 900; color: #b36443; letter-spacing: 0.15em; text-transform: uppercase; background: #f5ebdf; padding: 3px 8px; border-radius: 6px; border: 1px solid #e9d4bf;">SUNUDAARA</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-x-4 gap-y-3 flex-1">
                                <div class="col-span-2">
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Prénom & Nom</p>
                                    <p style="font-size: 13px; font-weight: 900; color: #3c1f19; text-transform: uppercase;">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Matricule</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">{{ Auth::user()->matricule ?? 'Non assigné' }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Né(e) le</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        @php $dn = Auth::user()->date_naissance; echo $dn ? \Carbon\Carbon::parse($dn)->format('d/m/Y') : 'Non renseignée'; @endphp
                                    </p>
                                </div>
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Téléphone</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">{{ Auth::user()->telephone ?? 'Non renseigné' }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Membre depuis</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : 'Récemment' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Cellule / Section</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">{{ Auth::user()->cellule->nomsection ?? 'Non assignée' }}</p>
                                </div>
                            </div>

                            <div class="flex items-end justify-between mt-3 pt-2 border-t" style="border-color: #e9d4bf;">
                                <div>
                                    <p style="font-size: 8px; color: #b36443; font-weight: 600;">Document officiel de la communauté</p>
                                    <p style="font-size: 7px; color: #cc926b; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;">ID : SD-{{ strtoupper(substr(Auth::user()->matricule ?? Auth::id(), 0, 8)) }}</p>
                                </div>
                                <div style="background: white; padding: 4px; border-radius: 8px; border: 1px solid #e9d4bf;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=56x56&data={{ urlencode('SunuDaara|MAT:' . (Auth::user()->matricule ?? Auth::user()->id) . '|' . Auth::user()->prenom . ' ' . Auth::user()->nom . '|TEL:' . (Auth::user()->telephone ?? 'N/A')) }}&color=3c1f19&bgcolor=ffffff&margin=1"
                                         alt="QR Code" style="width: 56px; height: 56px; display: block;" crossorigin="anonymous">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="background: linear-gradient(135deg, #3c1f19 0%, #62372c 100%); height: 6px;"></div>
                </div>
            </div>
            <!-- ===== FIN CARTE ADMIN ===== -->

        </div>
    </main>

    <!-- Sidebar Control Logic & Real-time Clock -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function updateRealTime() {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            let dateStr = now.toLocaleDateString('fr-FR', options);
            dateStr = dateStr.charAt(0).toUpperCase() + dateStr.slice(1);
            
            const timeStr = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            const dateEl = document.getElementById('realtime-date-admin');
            const timeEl = document.getElementById('realtime-time-admin');
            
            if (dateEl) dateEl.textContent = dateStr;
            if (timeEl) timeEl.textContent = `Heure locale: ${timeStr}`;
        }
        
        setInterval(updateRealTime, 1000);
        window.addEventListener('DOMContentLoaded', updateRealTime);
    </script>

</body>
</html>