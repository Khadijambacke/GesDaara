<header class="h-24 bg-white/80 backdrop-blur-md border-b border-cedar-200 flex items-center justify-between px-4 md:px-6 lg:px-8 flex-shrink-0 z-30">

    <!-- Left Section -->
    <div class="flex items-center gap-6">

        <!-- Mobile Menu Button -->
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

        <!-- Title -->
        <div>
            <h2 class="text-2xl font-extrabold text-cedar-950 tracking-tight">
                Espace Administrateur
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
                    Khadija Mbacké
                </p>

                <p class="text-[10px] uppercase tracking-widest text-cedar-400 font-bold">
                    Administrateur
                </p>
            </div>

            <div class="w-11 h-11 rounded-2xl overflow-hidden border-2 border-cedar-100">

                <img src="https://ui-avatars.com/api/?name=Khadija+Mbacke&background=f5ebdf&color=3c1f19"
                     alt="Profile"
                     class="w-full h-full object-cover">
            </div>
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