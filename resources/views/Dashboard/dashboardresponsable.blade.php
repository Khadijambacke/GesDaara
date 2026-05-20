@extends('layouts.app')

@section('title', 'Espace Responsable - SunuDaara')

@section('content')
<div class="space-y-8 animate-fade-in">
    
    <!-- Welcome Header Card -->
    <div class="bg-gradient-to-br from-cedar-900 via-cedar-950 to-cedar-900 rounded-[2.5rem] p-8 md:p-10 border border-cedar-850 shadow-2xl relative overflow-hidden">
        <div class="absolute -right-10 -top-10 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>

        <div class="relative z-10 space-y-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 bg-cedar-400 text-cedar-950 text-[10px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                    {{ $cellule->nomsection ?? 'Section locale' }}
                </span>
                <span class="px-3 py-1 bg-white/10 text-white text-[10px] font-black rounded-lg uppercase tracking-widest backdrop-blur-md">
                    Responsable de Section
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                Assalamou alaykoum, <span class="text-cedar-200">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
            </h1>
            <p class="text-sm text-cedar-200 max-w-2xl font-medium leading-relaxed">
                Bienvenue sur votre espace de gestion. Vous supervisez la section <strong>{{ $cellule->nomsection ?? 'N/A' }}</strong> (située à {{ $cellule->localite ?? 'N/A' }}). Suivez en temps réel les cotisations et contribuez à la vie active de votre communauté.
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Total Members -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-black text-cedar-400 uppercase tracking-widest">Membres Section</p>
                <h3 class="text-3xl font-black text-cedar-950 tracking-tight">{{ $totalMembres }}</h3>
                <p class="text-[10px] text-green-600 font-extrabold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block animate-pulse"></span>
                    Membres actifs
                </p>
            </div>
            <div class="w-14 h-14 bg-cedar-50 rounded-2xl flex items-center justify-center text-cedar-600 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Community Events -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-black text-cedar-400 uppercase tracking-widest">Événements</p>
                <h3 class="text-3xl font-black text-cedar-950 tracking-tight">{{ $evenementsActifs }}</h3>
                <p class="text-[10px] text-cedar-500 font-extrabold">Dans votre communauté</p>
            </div>
            <div class="w-14 h-14 bg-cedar-50 rounded-2xl flex items-center justify-center text-cedar-600 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Total Collected -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-black text-cedar-400 uppercase tracking-widest">Contributions Section</p>
                <h3 class="text-3xl font-black text-cedar-950 tracking-tight">{{ number_format($totalCotise, 0, ',', ' ') }} <span class="text-xs font-bold text-cedar-500">FCFA</span></h3>
                <p class="text-[10px] text-cedar-600 font-extrabold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>
                    Fonds collectés au total
                </p>
            </div>
            <div class="w-14 h-14 bg-cedar-50 rounded-2xl flex items-center justify-center text-cedar-600 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- Main Content Row -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Left: Latest Contributions Table -->
        <div class="xl:col-span-2 bg-white rounded-[2.5rem] p-8 border border-cedar-100 shadow-xl shadow-cedar-950/5">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-black text-cedar-950">Dernières Activités</h3>
                    <p class="text-xs text-cedar-400 font-bold mt-1">Derniers paiements enregistrés par les membres de votre section.</p>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-cedar-400 text-[10px] font-black uppercase tracking-widest border-b border-cedar-50">
                            <th class="pb-4">Membre</th>
                            <th class="pb-4">Date</th>
                            <th class="pb-4">Méthode</th>
                            <th class="pb-4 text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cedar-50">
                        @forelse($dernieresCotisations as $cotis)
                        <tr class="hover:bg-cedar-50/20 transition-all">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-cedar-50 text-cedar-900 flex items-center justify-center font-black text-xs">
                                        {{ strtoupper(substr($cotis->users->prenom ?? 'M', 0, 1) . substr($cotis->users->nom ?? 'B', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-cedar-950">{{ $cotis->users->prenom ?? 'Membre' }} {{ $cotis->users->nom ?? '' }}</p>
                                        <p class="text-[9px] text-cedar-400 font-bold">{{ $cotis->users->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <p class="text-xs font-bold text-cedar-900">{{ \Carbon\Carbon::parse($cotis->datecotisations)->format('d M Y') }}</p>
                            </td>
                            <td class="py-4">
                                <span class="px-2 py-0.5 bg-cedar-50 text-cedar-900 border border-cedar-100 text-[9px] font-black rounded-lg uppercase tracking-wide">
                                    {{ $cotis->methodepayement }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <p class="text-xs font-black text-cedar-950">{{ number_format($cotis->montantcotise, 0, ',', ' ') }} FCFA</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-xs text-cedar-400 font-black">
                                Aucune contribution enregistrée pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Quick Actions -->
        <div class="space-y-6">
            
            <!-- Quick Actions Panel -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-cedar-100 shadow-xl shadow-cedar-950/5">
                <h4 class="text-xs font-black text-cedar-950 uppercase tracking-widest mb-6">Actions Rapides</h4>
                
                <div class="space-y-4">
                    
                    <!-- Action: Add Member -->
                    <a href="{{ route('responsable.membres') }}" class="flex items-center gap-4 p-4 bg-cedar-50/50 hover:bg-cedar-50 border border-cedar-100 hover:border-cedar-200 rounded-2xl transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-cedar-900 text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-cedar-950">Ajouter un Membre</p>
                            <p class="text-[9px] text-cedar-500 font-bold">Enregistrer dans votre section</p>
                        </div>
                    </a>

                    <!-- Action: Record Contribution -->
                    <a href="{{ route('Toutevenement') }}" class="flex items-center gap-4 p-4 bg-cedar-50/50 hover:bg-cedar-50 border border-cedar-100 hover:border-cedar-200 rounded-2xl transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-cedar-900 text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-cedar-950">Enregistrer Cotisation</p>
                            <p class="text-[9px] text-cedar-500 font-bold">Log une nouvelle transaction</p>
                        </div>
                    </a>

                    <!-- Action: Manage Events -->
                    <a href="{{ route('Toutevenement') }}" class="flex items-center gap-4 p-4 bg-cedar-50/50 hover:bg-cedar-50 border border-cedar-100 hover:border-cedar-200 rounded-2xl transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-cedar-900 text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-cedar-950">Voir les Événements</p>
                            <p class="text-[9px] text-cedar-500 font-bold">Consulter les projets en cours</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
