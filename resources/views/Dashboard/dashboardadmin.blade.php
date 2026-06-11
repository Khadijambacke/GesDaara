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
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-medium transition-all group">
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
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Cotisations</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    <span>Flux Financiers</span>
                </a>
            </div>

            <div class="mt-8 space-y-1">
                <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">Organisation</p>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Événements</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Communautés</span>
                </a>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-6 bg-cedar-950/50">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/5 border border-white/10">
                <div class="w-10 h-10 rounded-xl overflow-hidden bg-cedar-400 p-0.5">
                    <img src="https://ui-avatars.com/api/?name=Khadija+Mbacke&background=f5ebdf&color=3c1f19" alt="User">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold truncate">K. Mbacké</p>
                    <p class="text-[10px] text-cedar-400 truncate uppercase tracking-tighter">Administrateur</p>
                </div>
                <button class="p-1.5 hover:bg-white/10 rounded-lg text-cedar-400 hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
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
        <div class="flex-1 overflow-y-auto p-10 space-y-10 custom-scrollbar">
            
            <!-- Removed Statistics Cards per request -->

            <!-- Main Dashboard Sections -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
                
                <!-- Transactions / Table Section -->
                <div class="xl:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
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
                                    <tr class="group hover:bg-cedar-50/50 transition-colors">
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-cedar-100 flex items-center justify-center font-black text-cedar-900 text-sm">SM</div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-cedar-950">Saliou MBACKE</p>
                                                    <p class="text-[11px] text-cedar-500 font-bold uppercase tracking-widest">Section Dakar-Plateau</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-bold text-cedar-900">11 Mai 2026</p>
                                            <p class="text-[10px] text-cedar-400 font-bold">12:45:08</p>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-black text-cedar-950">5,000 <span class="text-[10px] text-cedar-500">FCFA</span></p>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 bg-green-50 text-green-700 text-[10px] font-black rounded-xl border border-green-100 uppercase tracking-widest">Validé</span>
                                        </td>
                                    </tr>
                                    <tr class="group hover:bg-cedar-50/50 transition-colors">
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-cedar-100 flex items-center justify-center font-black text-cedar-900 text-sm">AF</div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-cedar-950">Awa FALL</p>
                                                    <p class="text-[11px] text-cedar-500 font-bold uppercase tracking-widest">Section Touba-Mbacké</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-bold text-cedar-900">11 Mai 2026</p>
                                            <p class="text-[10px] text-cedar-400 font-bold">10:30:22</p>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-black text-cedar-950">10,000 <span class="text-[10px] text-cedar-500">FCFA</span></p>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 bg-green-50 text-green-700 text-[10px] font-black rounded-xl border border-green-100 uppercase tracking-widest">Validé</span>
                                        </td>
                                    </tr>
                                    <tr class="group hover:bg-cedar-50/50 transition-colors">
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-cedar-100 flex items-center justify-center font-black text-cedar-900 text-sm">ID</div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-cedar-950">Ibrahima DIOP</p>
                                                    <p class="text-[11px] text-cedar-500 font-bold uppercase tracking-widest">Section Saint-Louis</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-bold text-cedar-900">10 Mai 2026</p>
                                            <p class="text-[10px] text-cedar-400 font-bold">18:15:45</p>
                                        </td>
                                        <td class="py-6">
                                            <p class="text-sm font-black text-cedar-950">2,500 <span class="text-[10px] text-cedar-500">FCFA</span></p>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 bg-cedar-100 text-cedar-700 text-[10px] font-black rounded-xl border border-cedar-200 uppercase tracking-widest">Attente</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-8 flex justify-center">
                            <button class="px-8 py-3 text-[11px] font-black text-cedar-800 uppercase tracking-[0.2em] bg-cedar-50 rounded-2xl hover:bg-cedar-100 transition-all">Consulter l'intégralité</button>
                        </div>
                    </div>
                </div>

                <!-- Lateral / Activity Section -->
                <div class="space-y-10">
                    
                    <!-- Calendar / Next Event -->
                    <div class="bg-cedar-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-cedar-950/20 relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 opacity-10 group-hover:rotate-12 transition-transform duration-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        
                        <h4 class="text-xl font-black mb-6 relative z-10">Événement National</h4>
                        
                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10 relative z-10 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 bg-cedar-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest">Confirmé</span>
                                <span class="text-[11px] font-bold text-cedar-200 uppercase tracking-widest">Mardi prochain</span>
                            </div>
                            <p class="text-lg font-extrabold leading-tight">Grande Conférence annuelle du Collectif</p>
                            <div class="flex items-center gap-2 mt-4 text-cedar-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs font-medium">Grande Mosquée de Dakar</span>
                            </div>
                        </div>

                        <button class="w-full py-4 bg-cedar-100 text-cedar-950 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-white transition-all shadow-xl shadow-black/10">Planifier & Gérer</button>
                    </div>

                    <!-- Responsibles List -->
                    <div class="bg-white rounded-[2.5rem] p-8 border border-cedar-100 shadow-xl shadow-cedar-950/5">
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-8">Responsables de Zone</h4>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-2xl overflow-hidden border-2 border-cedar-50 bg-cedar-500 flex items-center justify-center font-bold text-white text-xs">MG</div>
                                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-4 border-white"></div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-cedar-950 group-hover:text-cedar-600 transition-colors">Moussa GUEYE</p>
                                        <p class="text-[10px] text-cedar-400 font-bold uppercase tracking-widest">Dakar Nord-Ouest</p>
                                    </div>
                                </div>
                                <button class="p-2 text-cedar-300 hover:text-cedar-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-2xl overflow-hidden border-2 border-cedar-50 bg-cedar-400 flex items-center justify-center font-bold text-white text-xs">FS</div>
                                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-4 border-white"></div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-cedar-950 group-hover:text-cedar-600 transition-colors">Fatou SOW</p>
                                        <p class="text-[10px] text-cedar-400 font-bold uppercase tracking-widest">Région de Thiès</p>
                                    </div>
                                </div>
                                <button class="p-2 text-cedar-300 hover:text-cedar-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-cedar-50">
                            <button class="w-full text-[10px] font-black text-cedar-500 hover:text-cedar-950 uppercase tracking-[0.2em] transition-all">Consulter tout l'annuaire</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Data Visualizations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pb-10">
                <div class="bg-white rounded-[2.5rem] p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-2">Répartition par Communauté</h4>
                        <p class="text-xs text-cedar-400 font-bold mb-8">Statistiques globales du réseau</p>
                    </div>
                    <div class="flex items-end gap-3 h-32 w-full">
                        <div class="flex-1 bg-cedar-950 rounded-t-2xl hover:opacity-80 transition-opacity" style="height: 40%"></div>
                        <div class="flex-1 bg-cedar-700 rounded-t-2xl hover:opacity-80 transition-opacity" style="height: 70%"></div>
                        <div class="flex-1 bg-cedar-500 rounded-t-2xl hover:opacity-80 transition-opacity" style="height: 50%"></div>
                        <div class="flex-1 bg-cedar-300 rounded-t-2xl hover:opacity-80 transition-opacity" style="height: 90%"></div>
                        <div class="flex-1 bg-cedar-200 rounded-t-2xl hover:opacity-80 transition-opacity" style="height: 30%"></div>
                    </div>
                    <div class="mt-6 flex justify-between text-[9px] font-black text-cedar-400 uppercase tracking-widest">
                        <span>Dkr</span><span>Ths</span><span>Mck</span><span>Stl</span><span>Kld</span>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-black text-cedar-950 uppercase tracking-[0.2em] mb-2">Progression Mensuelle</h4>
                        <p class="text-xs text-cedar-400 font-bold mb-8">Flux de cotisations validées</p>
                    </div>
                    <div class="relative h-32 w-full flex items-center justify-center border-b border-l border-cedar-100">
                        <!-- Simplified path for wave -->
                        <svg class="w-full h-full px-2" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <path d="M0 35 Q 25 10, 50 30 T 100 5" fill="none" stroke="#b36443" stroke-width="3" stroke-linecap="round" />
                            <circle cx="50" cy="30" r="2" fill="#3c1f19" />
                        </svg>
                        <div class="absolute bottom-2 left-10 p-2 bg-cedar-950 text-white text-[8px] font-bold rounded shadow-lg">Hausse +15%</div>
                    </div>
                    <div class="mt-6 flex justify-between text-[9px] font-black text-cedar-400 uppercase tracking-widest">
                        <span>Jan</span><span>Fev</span><span>Mar</span><span>Avr</span><span>Mai</span>
                    </div>
                </div>
            </div>

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