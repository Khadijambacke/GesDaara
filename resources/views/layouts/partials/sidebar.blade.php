<aside id="sidebar" class="fixed lg:static h-screen inset-y-0 left-0 w-64 sidebar-gradient text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col border-r border-cedar-900">
        
    <!-- Logo Section -->
    <div class="h-24 flex items-center px-8 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cedar-400 rounded-xl flex items-center justify-center shadow-lg shadow-cedar-950/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>

            <div>
                <h1 class="text-xl font-bold tracking-tight">
                    SunuDaara
                </h1>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-8 px-4 custom-scrollbar">

        <!-- Principal -->
        <div class="space-y-1">

            <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">
                Principal
            </p>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-medium transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-300"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>

                <span>Tableau de bord</span>
            </a>

            <!-- Membres -->
            @if(in_array(Auth::user()->role, ['admin', 'responsable', 'responsble']))
            <a href="{{ in_array(Auth::user()->role, ['responsable', 'responsble']) ? route('responsable.membres') : route('Toutmembre') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>

                <span>{{ in_array(Auth::user()->role, ['responsable', 'responsble']) ? 'Membres de ma section' : 'Gestion des Membres' }}</span>
            </a>
            @endif

            <!-- Cellules -->
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('Toutcellule') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                </svg>

                <span>Gestion des Cellules</span>
            </a>
            @endif

        </div>

        <!-- Finance -->
        <div class="mt-8 space-y-1">

            <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">
                Finance
            </p>

            <!-- Cotisations -->
            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span>Cotisations</span>
            </a>

            <!-- Flux -->
            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z" />
                </svg>

                <span>Flux Financiers</span>
            </a>

        </div>

        <!-- Organisation -->
        <div class="mt-8 space-y-1">

            <p class="text-[10px] px-4 text-cedar-300 uppercase font-bold tracking-widest mb-4 opacity-60">
                Organisation
            </p>

            <!-- Événements -->
            <a href="{{ route('Toutevenement') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <span>Événements</span>
            </a>

            <!-- Communautés -->
            @if(Auth::user()->role === 'admin')
            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 text-cedar-100 transition-all group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-cedar-400 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                </svg>

                <span>Communautés</span>
            </a>
            @endif

        </div>
    </div>

    <!-- User Info -->
    <div class="p-6 bg-cedar-950/50">

        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/5 border border-white/10">

            <div class="w-10 h-10 rounded-xl overflow-hidden bg-cedar-400 p-0.5">
                <img src="https://ui-avatars.com/api/?name=Khadija+Mbacke&background=f5ebdf&color=3c1f19"
                     alt="User">
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold truncate">
                    K. Mbacké
                </p>

                <p class="text-[10px] text-cedar-400 truncate uppercase tracking-tighter">
                    Administrateur
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-1.5 hover:bg-white/10 rounded-lg text-cedar-400 hover:text-white transition-all" title="Se déconnecter">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
    
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>

        </div>
    </div>

</aside>