<header class="h-24 bg-white/80 backdrop-blur-md border-b border-cedar-200 flex items-center justify-between px-4 md:px-6 lg:px-8 flex-shrink-0 z-30">

    <!-- Left Section -->
    <div class="flex items-center gap-6">

        <!-- Mobile Menu Button (Admin/Resp only) -->
        @if(in_array(Auth::user()->role, ['admin', 'responsable', 'responsble']))
        <button onclick="toggleSidebar()"
                class="lg:hidden p-2 bg-cedar-100 rounded-lg text-cedar-900">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        @else
        <!-- Member Logo -->
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-cedar-900 rounded-xl flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-cedar-950 hidden sm:block">
                SunuDaara
            </h1>
        </div>
        @endif

        <!-- Title -->
        <div>
            <h2 class="text-lg md:text-2xl font-extrabold text-cedar-950 tracking-tight">
                @if(Auth::user()->role === 'admin')
                    Espace Administrateur
                @elseif(in_array(Auth::user()->role, ['responsable', 'responsble']))
                    Espace Responsable
                @else
                    Espace Membre
                @endif
            </h2>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-6">

        <!-- Date -->
        <div class="hidden md:flex flex-col text-right">

            <p id="realtime-date-header" class="text-xs font-bold text-cedar-950 uppercase tracking-widest">
                ...
            </p>

            <p id="realtime-time-header" class="text-[10px] text-cedar-500 font-bold">
                Heure locale : --:--
            </p>
        </div>

        <!-- Divider -->
        <div class="w-px h-8 bg-cedar-200"></div>

        <!-- Notification -->
        <div class="relative group">

            <button class="p-3 bg-cedar-100 rounded-2xl text-cedar-800 hover:bg-cedar-200 transition-all">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                <!-- Badge -->
                <span class="absolute top-0 right-0 w-4 h-4 bg-cedar-600 text-white text-[9px] font-black rounded-full border-2 border-white flex items-center justify-center">
                    2
                </span>
            </button>
        </div>

        <!-- Profile -->
        <div class="flex items-center gap-3">

            <div class="hidden md:block text-right">

                <p class="text-xs font-bold text-cedar-950">
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </p>

                <p class="text-[10px] uppercase tracking-widest text-cedar-400 font-bold">
                    {{ Auth::user()->role === 'admin' ? 'Administrateur' : (in_array(Auth::user()->role, ['responsable', 'responsble']) ? 'Responsable' : 'Membre') }}
                </p>
            </div>


            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="ml-2 border-l border-cedar-200 pl-4">
                @csrf
                <button type="submit" class="p-2.5 bg-rose-50 hover:bg-rose-100 rounded-xl text-rose-600 hover:text-rose-700 transition-all shadow-sm" title="Se déconnecter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

    </div>

</header>

<script>
    function updateRealTimeHeader() {
        const now = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        let dateStr = now.toLocaleDateString('fr-FR', options);
        dateStr = dateStr.charAt(0).toUpperCase() + dateStr.slice(1);
        
        const timeStr = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        
        const dateEl = document.getElementById('realtime-date-header');
        const timeEl = document.getElementById('realtime-time-header');
        
        if (dateEl) dateEl.textContent = dateStr;
        if (timeEl) timeEl.textContent = `Heure locale : ${timeStr}`;
    }
    
    setInterval(updateRealTimeHeader, 1000);
    window.addEventListener('DOMContentLoaded', updateRealTimeHeader);
</script>