@extends('layouts.app')

@section('title', 'Espace Membre - SunuDaara')

@section('content')
<!-- html2canvas CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl animate-fade-in shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl animate-fade-in shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header / Welcome Banner -->
    <div class="relative overflow-hidden rounded-[2rem] md:rounded-[2.5rem] bg-gradient-to-r from-cedar-950 via-cedar-900 to-cedar-800 text-white p-5 md:p-8 md:p-6 md:p-10 shadow-xl shadow-cedar-950/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(219,182,150,0.12),transparent_55%)] pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-emerald-400/5 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300 text-xs font-black uppercase tracking-wider">
                    Espace Membre Officiel
                </span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight">
                    Jërëjëf, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </h1>
                <p class="text-cedar-200 text-sm max-w-xl font-medium leading-relaxed">
                    Ravi de vous revoir dans votre tableau de bord. Suivez l'actualité de votre communauté, de votre section et gérez vos contributions en toute sérénité.
                </p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md border border-white/10 px-6 py-4 rounded-3xl flex flex-col items-start md:items-end gap-1">
                <span class="text-[10px] text-cedar-300 font-bold uppercase tracking-widest">Matricule Unique</span>
                <span class="text-xl font-black text-emerald-400 font-mono tracking-wide">
                    {{ Auth::user()->matricule ?? 'Non assigné' }}
                </span>
                <span class="text-xs text-white/80 font-medium">
                    Section : {{ Auth::user()->cellule->nomsection ?? 'Sans section' }}
                </span>
                <span class="text-[10px] text-emerald-300/80 font-extrabold uppercase tracking-wider mt-1">
                    Compte : {{ Auth::user()->compte->numerocompte ?? 'Non assigné' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs (Sleek Horizontal Bar) -->
    <div class="flex overflow-x-auto bg-white p-2 rounded-3xl border border-cedar-100 shadow-md shadow-cedar-950/5 custom-scrollbar gap-2">
        <button onclick="switchTab('overview')" id="tab-overview" class="tab-btn active-tab flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-black transition-all whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Tableau de Bord
        </button>
        <button onclick="switchTab('profile-card')" id="tab-profile-card" class="tab-btn inactive-tab flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-black transition-all whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Mon Profil & Carte
        </button>
        <button onclick="switchTab('events')" id="tab-events" class="tab-btn inactive-tab flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-black transition-all whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Événements
            @if(($evenementsCommunaute->count() + $evenementsSection->count()) > 0)
                <span class="px-2 py-0.5 text-[10px] bg-emerald-600 text-white rounded-full font-black">
                    {{ $evenementsCommunaute->count() + $evenementsSection->count() }}
                </span>
            @endif
        </button>
        <button onclick="switchTab('contributions')" id="tab-contributions" class="tab-btn inactive-tab flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-black transition-all whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Mes Cotisations
        </button>
    </div>

    <!-- TAB 1: OVERVIEW -->
    <div id="content-overview" class="tab-content space-y-6">
        <!-- Quick Stats Banner -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-cedar-100 shadow-md shadow-cedar-950/5 flex items-center justify-between">
                <div>
                    <span class="text-xs text-cedar-400 font-bold uppercase tracking-wider">Solde de mon Compte</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">
                        {{ number_format(Auth::user()->compte->montant_total ?? 0, 0, ',', ' ') }} FCFA
                    </h3>
                    <p class="text-[10px] text-cedar-400 font-mono mt-1">N° {{ Auth::user()->compte->numerocompte ?? 'Non assigné' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-cedar-100 shadow-md shadow-cedar-950/5 flex items-center justify-between">
                <div>
                    <span class="text-xs text-cedar-400 font-bold uppercase tracking-wider">Événements en cours</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">
                        {{ $evenementsActifs->count() }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-cedar-100 shadow-md shadow-cedar-950/5 flex items-center justify-between">
                <div>
                    <span class="text-xs text-cedar-400 font-bold uppercase tracking-wider">Ma Section</span>
                    <h3 class="text-xl font-black text-cedar-900 mt-1 truncate max-w-[200px]" title="{{ Auth::user()->cellule->nomsection ?? 'Sans section' }}">
                        {{ Auth::user()->cellule->nomsection ?? 'Non assigné' }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-cedar-50 text-cedar-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
            <!-- Dernières Activités — pleine largeur -->
            <div class="bg-white p-6 rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-md shadow-cedar-950/5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-black text-cedar-950">Dernières Activités</h2>
                            <p class="text-xs text-cedar-400 font-medium mt-1">Historique récent de vos paiements enregistrés.</p>
                        </div>
                        <button onclick="openCotiserModal()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-xl shadow-md shadow-cedar-900/10 transition-all flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Cotiser Maintenant
                        </button>
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse($dernieresCotisations as $cot)
                            <div class="flex items-center justify-between p-4 bg-cedar-50/35 hover:bg-cedar-50 rounded-2xl border border-cedar-100/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-cedar-100 text-cedar-800 flex items-center justify-center">
                                        @if($cot->methodepayement === 'wave')
                                            <span class="font-black text-xs text-blue-600">W</span>
                                        @elseif($cot->methodepayement === 'orange_money')
                                            <span class="font-black text-xs text-orange-500">OM</span>
                                        @elseif($cot->methodepayement === 'free_money')
                                            <span class="font-black text-xs text-red-600">F</span>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-cedar-950">{{ $cot->evenement->numeroevent ?? 'Cotisation Générale' }}</p>
                                        <p class="text-[10px] text-cedar-400 font-bold uppercase tracking-wider mt-0.5">
                                            {{ $cot->methodepayement ? strtoupper(str_replace('_', ' ', $cot->methodepayement)) : 'CASH' }} • {{ $cot->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="font-extrabold text-sm text-emerald-600">
                                    + {{ number_format($cot->montantcotise, 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-cedar-50/20 border border-dashed border-cedar-100 rounded-2xl">
                                <p class="text-sm text-cedar-400 font-bold">Aucune cotisation enregistrée pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="border-t border-cedar-50 pt-4 mt-6">
                    <button onclick="switchTab('contributions')" class="text-xs font-black text-cedar-800 hover:text-cedar-950 flex items-center gap-1 transition-colors">
                        Voir tout l'historique de mes cotisations
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div id="content-profile-card" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Membership Card - Full Width -->
            <div class="lg:col-span-3 flex flex-col items-center gap-6 bg-white p-6 rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5">
                <div class="flex items-center justify-between w-full px-2">
                    <h2 class="text-lg font-black text-cedar-950">Ma Carte Officielle</h2>
                    <span class="text-xs text-cedar-400 font-semibold">Aperçu de la carte de membre</span>
                </div>

                <!-- ===== CARTE MEMBRE - FORMAT PAYSAGE ===== -->
                <div id="member-card-render"
                     class="w-full max-w-[520px] rounded-[1.2rem] overflow-hidden shadow-2xl border border-cedar-200 select-none"
                     style="background: #fbf6f1; font-family: 'Plus Jakarta Sans', sans-serif;">

                    <!-- Bande supérieure colorée -->
                    <div style="background: linear-gradient(135deg, #3c1f19 0%, #62372c 60%, #955039 100%); height: 10px;"></div>

                    <div class="flex" style="min-height: 200px;">

                        <!-- ========== COLONNE GAUCHE : Photo + Rôle ========== -->
                        <div class="flex flex-col items-center justify-between py-5 px-4 flex-shrink-0"
                             style="width: 140px; background: linear-gradient(180deg, #3c1f19 0%, #62372c 100%);">

                            <!-- Logo + titre org -->
                            <div class="text-center">
                                <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center mx-auto mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#dbb696" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <p style="color: #dbb696; font-size: 8px; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase;">SunuDaara</p>
                            </div>

                            <!-- Photo du membre -->
                            <div class="rounded-xl overflow-hidden border-2 shadow-lg"
                                 style="width: 88px; height: 100px; border-color: rgba(219,182,150,0.4); background: #2d1612;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->prenom . ' ' . Auth::user()->nom) }}&background=f5ebdf&color=3c1f19&bold=true&size=128&format=png"
                                     alt="Photo membre"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            <!-- Badge rôle -->
                            <div class="text-center">
                                <span style="background: rgba(219,182,150,0.15); color: #dbb696; font-size: 8px; font-weight: 900; letter-spacing: 0.12em; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(219,182,150,0.3);">
                                    {{ Auth::user()->role === 'admin' ? 'Administrateur' : (in_array(Auth::user()->role, ['responsable', 'responsble']) ? 'Responsable' : 'Membre') }}
                                </span>
                            </div>
                        </div>

                        <!-- Séparateur vertical -->
                        <div style="width: 1px; background: #e9d4bf; flex-shrink: 0;"></div>

                        <!-- ========== COLONNE DROITE : Informations ========== -->
                        <div class="flex flex-col justify-between flex-1 py-4 px-5">

                            <!-- En-tête carte -->
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

                            <!-- Grille infos -->
                            <div class="grid grid-cols-2 gap-x-4 gap-y-3 flex-1">

                                <!-- Prénom & Nom -->
                                <div class="col-span-2">
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Prénom & Nom</p>
                                    <p style="font-size: 13px; font-weight: 900; color: #3c1f19; letter-spacing: 0.03em; text-transform: uppercase;">
                                        {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                                    </p>
                                </div>

                                <!-- Matricule -->
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Matricule</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        {{ Auth::user()->matricule ?? 'Non assigné' }}
                                    </p>
                                </div>

                                <!-- Né(e) le -->
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Né(e) le</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        @php
                                            $dn = Auth::user()->date_naissance;
                                            echo $dn ? (\Carbon\Carbon::parse($dn)->format('d/m/Y')) : 'Non renseignée';
                                        @endphp
                                    </p>
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Téléphone</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        {{ Auth::user()->telephone ?? 'Non renseigné' }}
                                    </p>
                                </div>

                                <!-- Membre depuis -->
                                <div>
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Membre depuis</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        {{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : 'Récemment' }}
                                    </p>
                                </div>

                                <!-- Section -->
                                <div class="col-span-2">
                                    <p style="font-size: 8px; font-weight: 900; color: #795039; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 1px;">Cellule / Section</p>
                                    <p style="font-size: 12px; font-weight: 700; color: #3c1f19;">
                                        {{ Auth::user()->cellule->nomsection ?? 'Non assignée' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Pied de carte : QR + document info -->
                            <div class="flex items-end justify-between mt-3 pt-2 border-t" style="border-color: #e9d4bf;">
                                <div>
                                    <p style="font-size: 8px; color: #b36443; font-weight: 600;">Document officiel de la communauté</p>
                                    <p style="font-size: 7px; color: #cc926b; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;">ID : SD-{{ strtoupper(substr(Auth::user()->matricule ?? Auth::id(), 0, 8)) }}</p>
                                </div>
                                <!-- QR Code -->
                                <div style="background: white; padding: 4px; border-radius: 8px; border: 1px solid #e9d4bf;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=56x56&data={{ urlencode('SunuDaara|MAT:' . (Auth::user()->matricule ?? Auth::user()->id) . '|' . Auth::user()->prenom . ' ' . Auth::user()->nom . '|TEL:' . (Auth::user()->telephone ?? 'N/A')) }}&color=3c1f19&bgcolor=ffffff&margin=1"
                                         alt="QR Code"
                                         style="width: 56px; height: 56px; display: block;"
                                         crossorigin="anonymous">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bande inférieure -->
                    <div style="background: linear-gradient(135deg, #3c1f19 0%, #62372c 100%); height: 6px;"></div>
                </div>
                <!-- ===== FIN CARTE ===== -->

                <button onclick="downloadMyCard()" class="w-full max-w-[520px] py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-2xl shadow-xl shadow-cedar-950/10 transition-all flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Télécharger ma carte (PNG)
                </button>
            </div>

            <!-- Profile Details Form/View -->

            <div class="lg:col-span-2 bg-white p-5 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 space-y-6">
                <div class="border-b border-cedar-50 pb-4">
                    <h2 class="text-xl font-black text-cedar-900">Informations de Profil</h2>
                    <p class="text-xs text-cedar-400 mt-0.5">Détails de votre fiche d'inscription officielle.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom & Nom -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Prénom & Nom</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    </div>

                    <!-- Email -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Adresse Email</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->email }}</span>
                    </div>

                    <!-- Téléphone -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Téléphone</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->telephone ?? '-' }}</span>
                    </div>

                    <!-- Adresse -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Adresse Physique</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->adresse ?? '-' }}</span>
                    </div>

                    <!-- Genre -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Genre</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block uppercase">{{ Auth::user()->genre === 'homme' ? 'Homme' : 'Femme' }}</span>
                    </div>

                    <!-- Statut Matrimonial -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Statut Matrimonial</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->situation_matrimoniale ?? 'Non défini' }}</span>
                    </div>

                    <!-- Date de naissance -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Date de Naissance</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">
                            {{ Auth::user()->date_naissance ? (Auth::user()->date_naissance instanceof \Carbon\Carbon ? Auth::user()->date_naissance->format('d/m/Y') : \Carbon\Carbon::parse(Auth::user()->date_naissance)->format('d/m/Y')) : '-' }}
                        </span>
                    </div>

                    <!-- Filiation -->
                    <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                        <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Filiation</span>
                        <span class="text-sm font-bold text-cedar-950 mt-1 block">Fils/Fille de {{ Auth::user()->nom_pere }} et {{ Auth::user()->nom_mere }}</span>
                    </div>

                    <!-- Type Membre Section -->
                    <div class="md:col-span-2 border-t border-cedar-50 pt-4 mt-2">
                        <h3 class="text-xs font-black text-cedar-900 uppercase tracking-widest mb-3">Statut & Activité</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                                <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Catégorie de membre</span>
                                <span class="inline-flex items-center px-3 py-1 bg-cedar-100 text-cedar-950 text-xs font-black rounded-lg uppercase mt-1.5">
                                    {{ Auth::user()->type_membre === 'adulte' ? 'Adulte' : 'Adolescent' }}
                                </span>
                            </div>

                            @if(Auth::user()->type_membre === 'adulte')
                                <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                                    <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Profession</span>
                                    <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->profession ?? '-' }}</span>
                                </div>
                                <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50 md:col-span-2">
                                    <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">NIN (Numéro Identité Nationale)</span>
                                    <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->nin ?? '-' }}</span>
                                </div>
                            @else
                                <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                                    <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Formation / Études</span>
                                    <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->niveau_etudes ?? '-' }}</span>
                                </div>
                                <div class="bg-cedar-50/20 p-4 rounded-2xl border border-cedar-50/50">
                                    <span class="block text-[10px] font-black text-cedar-400 uppercase tracking-widest">Téléphone du Tuteur</span>
                                    <span class="text-sm font-bold text-cedar-950 mt-1 block">{{ Auth::user()->parent_tuteur_telephone ?? '-' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: EVENTS -->
    <div id="content-events" class="tab-content hidden space-y-8">
        <!-- Section: Community Events -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-cedar-50 pb-2">
                <div>
                    <h2 class="text-xl font-black text-cedar-950">Événements de la Communauté</h2>
                    <p class="text-xs text-cedar-400 font-medium">Activités globales pour toute la communauté.</p>
                </div>
                <span class="px-3 py-1 bg-cedar-100 text-cedar-800 text-xs font-black rounded-lg uppercase">
                    {{ $evenementsCommunaute->count() }} évé.
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($evenementsCommunaute as $event)
                    @php
                        $percentage = $event->objectifmontant > 0 ? min(100, round(($event->montantotalparticipe / $event->objectifmontant) * 100)) : 0;
                    @endphp
                    <div class="bg-white p-6 rounded-[2.2rem] border border-cedar-100 shadow-md shadow-cedar-950/5 space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase {{ $event->statut === 'En_cours' ? 'bg-emerald-100 text-emerald-800' : ($event->statut === 'planifie' ? 'bg-blue-100 text-blue-800' : 'bg-cedar-100 text-cedar-800') }}">
                                    {{ $event->statut === 'En_cours' ? 'En Cours' : ($event->statut === 'planifie' ? 'Planifié' : 'Clôturé') }}
                                </span>
                                <span class="text-xs font-mono font-bold text-cedar-400">#{{ $event->numeroevent }}</span>
                            </div>

                            <h3 class="text-lg font-black text-cedar-900 leading-tight">{{ $event->libelleevent ?? $event->numeroevent }}</h3>

                            <!-- Dates -->
                            <div class="flex items-center gap-4 text-xs text-cedar-400 font-semibold bg-cedar-50/50 p-2.5 rounded-xl border border-cedar-100/30">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Début: {{ $event->datedebut instanceof \Carbon\Carbon ? $event->datedebut->format('d/m/Y') : \Carbon\Carbon::parse($event->datedebut)->format('d/m/Y') }}
                                </div>
                                <div class="w-1.5 h-1.5 bg-cedar-300 rounded-full"></div>
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Clôture: {{ $event->datecloture instanceof \Carbon\Carbon ? $event->datecloture->format('d/m/Y') : \Carbon\Carbon::parse($event->datecloture)->format('d/m/Y') }}
                                </div>
                            </div>


                        </div>

                        @php
                            $userParticipation = $event->participationsRelation->where('user_id', Auth::user()->id)->first();
                        @endphp

                        @if($userParticipation)
                            @php
                                $indivPercentage = $userParticipation->montant_total_prevu > 0
                                    ? min(100, round(($userParticipation->montant_paye / $userParticipation->montant_total_prevu) * 100))
                                    : 0;
                                $objectifAtteint = $userParticipation->montant_paye >= $userParticipation->montant_total_prevu && $userParticipation->montant_total_prevu > 0;
                            @endphp
                            <div class="space-y-1.5 pt-2 border-t border-cedar-100/50">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-cedar-500 font-extrabold flex items-center gap-1.5">
                                        Mon engagement
                                        @if($event->statut !== 'termine')
                                            <button onclick="openEngagementModal({{ $event->id }}, '{{ addslashes($event->libelleevent ?? $event->numeroevent) }}', {{ $userParticipation->montant_total_prevu }})" class="text-cedar-400 hover:text-cedar-900 transition-colors p-0.5 rounded-md hover:bg-cedar-50" title="Modifier">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </span>
                                    <span class="text-cedar-950 font-black">{{ number_format($userParticipation->montant_total_prevu, 0, ',', ' ') }} FCFA</span>
                                </div>

                                @if($objectifAtteint)
                                    {{-- Option A : objectif atteint → badge vert, pas de montant restant --}}
                                    <div class="flex items-center gap-2 py-2 px-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-black text-emerald-700">Objectif atteint ✓</span>
                                    </div>
                                @else
                                    <div class="w-full bg-cedar-100 h-2 rounded-full overflow-hidden relative">
                                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $indivPercentage }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] font-bold text-cedar-400">
                                        <span>Versé : {{ number_format($userParticipation->montant_paye, 0, ',', ' ') }} FCFA</span>
                                        <span class="text-emerald-600 font-extrabold">{{ $indivPercentage }}% versé</span>
                                    </div>
                                @endif
                            </div>

                            @if($event->statut !== 'termine')
                                <button onclick="openCotiserModal({{ $event->id }})" class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-xs font-black rounded-2xl shadow-lg shadow-emerald-900/20 transition-all flex items-center justify-center gap-2 mt-4 transform hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Payer ma cotisation
                                </button>
                            @else
                                <div class="w-full py-3 text-center text-xs font-bold text-cedar-400 bg-cedar-50 rounded-2xl mt-4">
                                    Événement clôturé
                                </div>
                            @endif
                        @else
                            @if($event->statut !== 'termine')
                                <div class="mt-4 p-5 rounded-2xl bg-gradient-to-b from-cedar-50/50 to-white border border-cedar-200/60 text-center space-y-3 shadow-inner">
                                    <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-cedar-900">Définissez votre objectif</h4>
                                        <p class="text-[10px] text-cedar-400 font-semibold mt-1">Quel montant souhaitez-vous contribuer pour cet événement ? Fixez un but pour commencer.</p>
                                    </div>
                                    <button onclick="openEngagementModal({{ $event->id }}, '{{ addslashes($event->libelleevent ?? $event->numeroevent) }}')" class="w-full py-3 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-xl shadow-md transition-all mt-2">
                                        Fixer mon objectif (FCFA)
                                    </button>
                                </div>
                            @else
                                <div class="w-full py-3 text-center text-xs font-bold text-cedar-400 bg-cedar-50 rounded-2xl mt-4">
                                    Événement clôturé
                                </div>
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-3xl border border-dashed border-cedar-200">
                        <p class="text-sm text-cedar-400 font-bold">Aucun événement communautaire disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section: Section/Cellule Events -->
        <div class="space-y-4 pt-4">
            <div class="flex items-center justify-between border-b border-cedar-50 pb-2">
                <div>
                    <h2 class="text-xl font-black text-cedar-950">Événements de ma Section ({{ Auth::user()->cellule->nomsection ?? 'Section' }})</h2>
                    <p class="text-xs text-cedar-400 font-medium">Activités réservées uniquement aux membres de votre cellule locale.</p>
                </div>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-black rounded-lg uppercase">
                    {{ $evenementsSection->count() }} évé.
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($evenementsSection as $event)
                    @php
                        $percentage = $event->objectifmontant > 0 ? min(100, round(($event->montantotalparticipe / $event->objectifmontant) * 100)) : 0;
                    @endphp
                    <div class="bg-white p-6 rounded-[2.2rem] border border-cedar-100 shadow-md shadow-cedar-950/5 space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase {{ $event->statut === 'En_cours' ? 'bg-emerald-100 text-emerald-800' : ($event->statut === 'planifie' ? 'bg-blue-100 text-blue-800' : 'bg-cedar-100 text-cedar-800') }}">
                                    {{ $event->statut === 'En_cours' ? 'En Cours' : ($event->statut === 'planifie' ? 'Planifié' : 'Clôturé') }}
                                </span>
                                <span class="text-xs font-mono font-bold text-cedar-400">#{{ $event->numeroevent }}</span>
                            </div>

                            <h3 class="text-lg font-black text-cedar-900 leading-tight">{{ $event->libelleevent ?? $event->numeroevent }}</h3>

                            <!-- Dates -->
                            <div class="flex items-center gap-4 text-xs text-cedar-400 font-semibold bg-cedar-50/50 p-2.5 rounded-xl border border-cedar-100/30">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Début: {{ $event->datedebut instanceof \Carbon\Carbon ? $event->datedebut->format('d/m/Y') : \Carbon\Carbon::parse($event->datedebut)->format('d/m/Y') }}
                                </div>
                                <div class="w-1.5 h-1.5 bg-cedar-300 rounded-full"></div>
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2500/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Clôture: {{ $event->datecloture instanceof \Carbon\Carbon ? $event->datecloture->format('d/m/Y') : \Carbon\Carbon::parse($event->datecloture)->format('d/m/Y') }}
                                </div>
                            </div>


                        </div>

                        @php
                            $userParticipation = $event->participationsRelation->where('user_id', Auth::user()->id)->first();
                        @endphp

                        @if($userParticipation)
                            @php
                                $indivPercentage = $userParticipation->montant_total_prevu > 0 ? min(100, round(($userParticipation->montant_paye / $userParticipation->montant_total_prevu) * 100)) : 0;
                            @endphp
                            <div class="space-y-1.5 pt-2 border-t border-cedar-100/50">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-cedar-500 font-extrabold flex items-center gap-1.5">
                                        Mon engagement
                                        @if($event->statut !== 'termine')
                                            <button onclick="openEngagementModal({{ $event->id }}, '{{ addslashes($event->libelleevent ?? $event->numeroevent) }}', {{ $userParticipation->montant_total_prevu }})" class="text-cedar-400 hover:text-cedar-900 transition-colors p-0.5 rounded-md hover:bg-cedar-50" title="Modifier mon engagement">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </span>
                                    <span class="text-cedar-950 font-black">{{ number_format($userParticipation->montant_total_prevu, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="w-full bg-cedar-100 h-2 rounded-full overflow-hidden relative">
                                    <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $indivPercentage }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-bold text-cedar-400">
                                    <span>Versé : {{ number_format($userParticipation->montant_paye, 0, ',', ' ') }} FCFA</span>
                                    <span class="text-emerald-600 font-extrabold">{{ $indivPercentage }}% versé</span>
                                </div>
                            </div>

                            @if($event->statut !== 'termine')
                                <button onclick="openCotiserModal({{ $event->id }})" class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-xs font-black rounded-2xl shadow-lg shadow-emerald-900/20 transition-all flex items-center justify-center gap-2 mt-4 transform hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Payer ma cotisation
                                </button>
                            @else
                                <button disabled class="w-full py-3.5 bg-cedar-100 text-cedar-400 text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 cursor-not-allowed mt-4">
                                    Événement Clôturé
                                </button>
                            @endif
                        @else
                            @if($event->statut !== 'termine')
                                <div class="mt-4 p-5 rounded-2xl bg-gradient-to-b from-cedar-50/50 to-white border border-cedar-200/60 text-center space-y-3 shadow-inner">
                                    <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-cedar-900">Définissez votre objectif</h4>
                                        <p class="text-[10px] text-cedar-400 font-semibold mt-1">Quel montant souhaitez-vous contribuer pour cet événement ? Fixez un but pour commencer.</p>
                                    </div>
                                    <button onclick="openEngagementModal({{ $event->id }}, '{{ addslashes($event->libelleevent ?? $event->numeroevent) }}')" class="w-full py-3 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-xl shadow-md transition-all mt-2">
                                        Fixer mon objectif (FCFA)
                                    </button>
                                </div>
                            @else
                                <div class="w-full py-3 text-center text-xs font-bold text-cedar-400 bg-cedar-50 rounded-2xl mt-4">
                                    Événement clôturé
                                </div>
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-3xl border border-dashed border-cedar-200">
                        <p class="text-sm text-cedar-400 font-bold">Aucun événement de section planifié pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 4: CONTRIBUTIONS -->
    <div id="content-contributions" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 text-white p-6 rounded-3xl shadow-lg shadow-cedar-900/10 flex items-center justify-between">
                <div>
                    <span class="text-xs text-emerald-200 font-bold uppercase tracking-wider">Cumul de mes versements</span>
                    <h3 class="text-3xl font-black mt-2">
                        {{ number_format($cotisations->sum('montantcotise'), 0, ',', ' ') }} FCFA
                    </h3>
                </div>
                <div class="w-14 h-14 bg-white/10 rounded-2xl border border-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-cedar-800 to-cedar-900 text-white p-6 rounded-3xl shadow-lg shadow-cedar-900/10 flex items-center justify-between">
                <div>
                    <span class="text-xs text-cedar-300 font-bold uppercase tracking-wider">Nombre de cotisations</span>
                    <h3 class="text-3xl font-black mt-2">
                        {{ $cotisations->count() }} transaction(s)
                    </h3>
                </div>
                <div class="w-14 h-14 bg-white/10 rounded-2xl border border-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-md shadow-cedar-950/5 space-y-4">
            <div class="flex items-center justify-between border-b border-cedar-50 pb-4">
                <div>
                    <h2 class="text-lg font-black text-cedar-950">Historique des Cotisations</h2>
                    <p class="text-xs text-cedar-400 font-medium">Reçus de paiements numériques émis à votre nom.</p>
                </div>
                <button onclick="openCotiserModal()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-xl transition-all flex items-center gap-1 shadow-md shadow-cedar-900/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Faire une cotisation
                </button>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-cedar-50/50 text-[10px] uppercase tracking-widest text-cedar-500 font-black">
                            <th class="p-4 rounded-l-2xl">Reçu / Référence</th>
                            <th class="p-4">Événement</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Mode de Paiement</th>
                            <th class="p-4 text-right rounded-r-2xl">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cedar-50/50 font-bold text-sm text-cedar-950">
                        @forelse($cotisations as $cot)
                            <tr class="hover:bg-cedar-50/10 transition-colors">
                                <td class="p-4 font-mono text-xs text-cedar-500">{{ $cot->numerocontributions }}</td>
                                <td class="p-4">{{ $cot->evenement->numeroevent ?? 'Général' }}</td>
                                <td class="p-4 text-xs font-semibold text-cedar-500">
                                    {{ $cot->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $cot->methodepayement === 'wave' ? 'bg-blue-50 text-blue-700 border border-blue-200' : ($cot->methodepayement === 'orange_money' ? 'bg-orange-50 text-orange-700 border border-orange-200' : ($cot->methodepayement === 'free_money' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-cedar-50 text-cedar-800 border border-cedar-200')) }}">
                                        {{ str_replace('_', ' ', $cot->methodepayement) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right text-emerald-600 font-extrabold">
                                    {{ number_format($cot->montantcotise, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-sm text-cedar-400 font-bold">Aucune cotisation enregistrée pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT: INTERACTIVE COTISATION MODAL -->
<div id="cotisation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] w-full max-w-lg border border-cedar-100 shadow-2xl overflow-hidden flex flex-col justify-between max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-5 bg-cedar-950 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-md font-black">Nouvelle Cotisation</h3>
                    <p class="text-[10px] text-cedar-300 font-bold uppercase tracking-widest leading-none mt-1">Espace de Paiement sécurisé</p>
                </div>
            </div>
            <button onclick="closeCotiserModal()" class="p-2 text-cedar-400 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="cotisation-form" method="POST" action="{{ route('membre.cotisations.store') }}" class="flex-1 overflow-y-auto p-6 space-y-6">
            @csrf
            
            <!-- STEP 1: EVENT AND AMOUNT -->
            <div id="modal-step-1" class="space-y-5">
                <!-- Select Event -->
                <div class="space-y-1.5">
                    <label for="evenement_id" class="block text-[10px] font-black text-cedar-455 uppercase tracking-widest">Choisir l'Événement</label>
                    <div class="relative">
                        <select id="evenement_id" name="evenement_id" required class="w-full bg-cedar-50/50 border border-cedar-100 rounded-2xl py-3.5 px-4 font-bold text-sm text-cedar-950 focus:outline-none focus:border-emerald-500 focus:bg-white transition-all appearance-none">
                            <option value="" disabled selected>-- Sélectionnez un événement --</option>
                            @foreach($evenementsActifs as $ev)
                                <option value="{{ $ev->id }}">
                                    {{ $ev->libelleevent ?? $ev->numeroevent }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-cedar-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Input Amount -->
                <div class="space-y-1.5">
                    <label for="montantcotise" class="block text-[10px] font-black text-cedar-455 uppercase tracking-widest">Montant de la cotisation (FCFA)</label>
                    <input type="number" id="montantcotise" name="montantcotise" min="1" required placeholder="Saisir le montant en FCFA" class="w-full bg-cedar-50/50 border border-cedar-100 rounded-2xl py-3.5 px-4 font-bold text-sm text-cedar-950 focus:outline-none focus:border-emerald-500 focus:bg-white transition-all">
                    
                    <!-- Quick Select Pills -->
                    <div class="flex flex-wrap gap-2 pt-1">
                        <button type="button" onclick="setQuickAmount(1000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                            1 000 F
                        </button>
                        <button type="button" onclick="setQuickAmount(5000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                            5 000 F
                        </button>
                        <button type="button" onclick="setQuickAmount(10000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                            10 000 F
                        </button>
                        <button type="button" onclick="setQuickAmount(25000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                            25 000 F
                        </button>
                        <button type="button" onclick="setQuickAmount(50000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                            50 000 F
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-cedar-50">
                    <button type="button" onclick="goToStep(2)" class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-2xl shadow-lg transition-all flex items-center justify-center gap-1.5">
                        Continuer vers le Paiement
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="ro            <!-- STEP 2: PAYMENT METHOD -->
            <div id="modal-step-2" class="space-y-5 hidden">
                <span class="block text-[10px] font-black text-cedar-455 uppercase tracking-widest mb-1">Sélectionner un Moyen de Paiement</span>
                
                <div class="grid grid-cols-1 gap-3">
                    <!-- Wave -->
                    <div class="relative">
                        <input type="radio" id="pay_method_wave" name="methodepayement" value="wave" class="peer hidden" required>
                        <label for="pay_method_wave" class="flex items-center justify-between p-4 bg-white border-2 border-cedar-100 hover:border-blue-300 rounded-2xl cursor-pointer transition-all hover:bg-slate-50/50 peer-checked:border-blue-500 peer-checked:bg-blue-50/20 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-sm border border-blue-200">
                                    W
                                </div>
                                <div>
                                    <span class="block font-black text-sm text-cedar-950">Wave Mobile Money</span>
                                    <span class="block text-[10px] text-cedar-400 font-semibold mt-0.5">Paiement instantané sans frais</span>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-cedar-200 group-hover:border-blue-400 peer-checked:bg-blue-600 peer-checked:border-blue-600 flex items-center justify-center transition-all">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Orange Money -->
                    <div class="relative">
                        <input type="radio" id="pay_method_om" name="methodepayement" value="orange_money" class="peer hidden">
                        <label for="pay_method_om" class="flex items-center justify-between p-4 bg-white border-2 border-cedar-100 hover:border-orange-300 rounded-2xl cursor-pointer transition-all hover:bg-slate-50/50 peer-checked:border-orange-500 peer-checked:bg-orange-50/20 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-black text-xs border border-orange-200">
                                    OM
                                </div>
                                <div>
                                    <span class="block font-black text-sm text-cedar-950">Orange Money</span>
                                    <span class="block text-[10px] text-cedar-400 font-semibold mt-0.5">Validation par code secret #144#</span>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-cedar-200 group-hover:border-orange-400 peer-checked:bg-orange-500 peer-checked:border-orange-500 flex items-center justify-center transition-all">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Free Money -->
                    <div class="relative">
                        <input type="radio" id="pay_method_free" name="methodepayement" value="free_money" class="peer hidden">
                        <label for="pay_method_free" class="flex items-center justify-between p-4 bg-white border-2 border-cedar-100 hover:border-red-300 rounded-2xl cursor-pointer transition-all hover:bg-slate-50/50 peer-checked:border-red-500 peer-checked:bg-red-50/20 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-black text-xs border border-red-200">
                                    FM
                                </div>
                                <div>
                                    <span class="block font-black text-sm text-cedar-950">Free Money</span>
                                    <span class="block text-[10px] text-cedar-400 font-semibold mt-0.5">Confirmation rapide par téléphone</span>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-cedar-200 group-hover:border-red-400 peer-checked:bg-red-600 peer-checked:border-red-600 flex items-center justify-center transition-all">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Bank -->
                    <div class="relative">
                        <input type="radio" id="pay_method_bank" name="methodepayement" value="bank" class="peer hidden">
                        <label for="pay_method_bank" class="flex items-center justify-between p-4 bg-white border-2 border-cedar-100 hover:border-cedar-400 rounded-2xl cursor-pointer transition-all hover:bg-slate-50/50 peer-checked:border-cedar-900 peer-checked:bg-cedar-50/30 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cedar-50 text-cedar-800 flex items-center justify-center border border-cedar-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-black text-sm text-cedar-900">Virement ou Carte Bancaire</span>
                                    <span class="block text-[10px] text-cedar-400 font-semibold mt-0.5">Pour les montants plus importants</span>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-cedar-200 group-hover:border-cedar-600 peer-checked:bg-cedar-900 peer-checked:border-cedar-900 flex items-center justify-center transition-all">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-cedar-50">
                    <button type="button" onclick="goToStep(1)" class="w-1/3 py-4 bg-cedar-100 hover:bg-cedar-200 text-cedar-900 text-xs font-black rounded-2xl transition-all">
                        Retour
                    </button>
                    <button type="button" onclick="triggerSimulatedPayment()" class="w-2/3 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-2xl shadow-lg transition-all flex items-center justify-center gap-1.5">
                        Confirmer & Payer
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- STEP 3: SIMULATED PAYMENT WINDOW -->
            <div id="modal-step-3" class="hidden flex flex-col items-center justify-center py-16 space-y-4 text-center">
                <div class="w-16 h-16 rounded-full bg-cedar-50 flex items-center justify-center text-cedar-950 relative mb-2">
                    <!-- Spinner / Load -->
                    <div id="carrier-loader" class="absolute inset-0 rounded-full border-4 border-cedar-100 border-t-emerald-600 animate-spin"></div>
                    <!-- Success Icon (hidden initially) -->
                    <div id="carrier-success-icon" class="hidden absolute inset-0 bg-emerald-600 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    
                </div>
                
                <div class="space-y-1">
                    <h4 class="text-sm font-black text-cedar-950" id="carrier-title">Traitement de votre cotisation</h4>
                    <p class="text-xs text-cedar-500 font-bold" id="carrier-instruction">Simulation du paiement mobile en cours...</p>
                    <p class="text-[9px] text-cedar-400 uppercase tracking-widest mt-2">
                        Ne fermez pas cette fenêtre pendant l'autorisation.
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- STYLES -->
<style>
    .tab-btn {
        outline: none;
    }
    .active-tab {
        background-color: #3c1f19; /* cedar-950 */
        color: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.05);
    }
    .inactive-tab {
        background-color: transparent;
        color: #62372c; /* cedar-900 */
    }
    .inactive-tab:hover {
        background-color: #fbf6f1; /* cedar-50 */
        color: #3c1f19;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<!-- SCRIPTS -->
<script>
    // Tab switching logic
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active-tab');
            btn.classList.add('inactive-tab');
        });
        
        // Show selected tab content
        const targetContent = document.getElementById(`content-${tabId}`);
        if (targetContent) {
            targetContent.classList.remove('hidden');
            targetContent.classList.add('animate-fade-in');
        }
        
        // Add active class to selected button
        const targetBtn = document.getElementById(`tab-${tabId}`);
        if (targetBtn) {
            targetBtn.classList.add('active-tab');
            targetBtn.classList.remove('inactive-tab');
        }
        
        // Save state in localStorage
        localStorage.setItem('activeMemberTab', tabId);
    }
    
    // Restore tab state on page load
    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = localStorage.getItem('activeMemberTab');
        if (savedTab && document.getElementById(`tab-${savedTab}`)) {
            switchTab(savedTab);
        }
    });

    // Download Membership Card Logic
    function downloadMyCard() {
        const cardElement = document.getElementById('member-card-render');
        const matricule = "{{ Auth::user()->matricule ?? 'membre' }}";
        
        // Afficher un loader temporaire sur le bouton
        const btn = event.currentTarget;
        const origContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Génération de l'image...`;

        html2canvas(cardElement, {
            scale: 3, // Super haute résolution
            useCORS: true, 
            backgroundColor: null,
            logging: false
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = `carte_membre_${matricule}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            // Rétablir le bouton
            btn.disabled = false;
            btn.innerHTML = origContent;
        }).catch(err => {
            console.error("Erreur lors de la capture de la carte :", err);
            btn.disabled = false;
            btn.innerHTML = origContent;
        });
    }

    // Modal Control
    function openCotiserModal(eventId = null) {
        const modal = document.getElementById('cotisation-modal');
        modal.classList.remove('hidden');
        
        if (eventId) {
            const select = document.getElementById('evenement_id');
            select.value = eventId;
        }
        
        goToStep(1);
    }
    
    function closeCotiserModal() {
        const modal = document.getElementById('cotisation-modal');
        modal.classList.add('hidden');
    }
    
    function setQuickAmount(amount) {
        document.getElementById('montantcotise').value = amount;
    }
    
    function goToStep(stepNum) {
        document.getElementById('modal-step-1').classList.add('hidden');
        document.getElementById('modal-step-2').classList.add('hidden');
        document.getElementById('modal-step-3').classList.add('hidden');
        
        document.getElementById(`modal-step-${stepNum}`).classList.remove('hidden');
        document.getElementById(`modal-step-${stepNum}`).classList.add('animate-fade-in');
    }

    // Simulate carrier payment screen
    function triggerSimulatedPayment() {
        const form = document.getElementById('cotisation-form');
        const evSelect = document.getElementById('evenement_id');
        const amtInput = document.getElementById('montantcotise');
        
        // Basic inputs validate
        if (!evSelect.value || !amtInput.value || amtInput.value <= 0) {
            goToStep(1);
            form.reportValidity();
            return;
        }
        
        // Find checked payment method
        const paymentRadio = form.querySelector('input[name="methodepayement"]:checked');
        if (!paymentRadio) {
            alert("Veuillez sélectionner un moyen de paiement.");
            return;
        }
        
        const method = paymentRadio.value;
        const amount = parseFloat(amtInput.value).toLocaleString('fr-FR') + " FCFA";
        
        // Setup Step 3 (Simulated payment window)
        const loader = document.getElementById('carrier-loader');
        const successIcon = document.getElementById('carrier-success-icon');
        const title = document.getElementById('carrier-title');
        const instruction = document.getElementById('carrier-instruction');
        
        // Reset states
        loader.classList.remove('hidden');
        successIcon.classList.add('hidden');
        title.textContent = 'Traitement en cours';
        instruction.textContent = 'Simulation du paiement mobile en cours...';
        
        goToStep(3);
        
        // Simulating loading & success transition
        setTimeout(() => {
            loader.classList.add('hidden');
            successIcon.classList.remove('hidden');
            title.textContent = 'Paiement Réussi';
            instruction.textContent = 'Votre cotisation a été enregistrée avec succès.';
            
            // Submit form to Laravel database after 1 second of success screen
            setTimeout(() => {
                form.submit();
            }, 1000);
        }, 1500);
    }

    // Engagement Modal Logic
    function openEngagementModal(eventId, eventName, currentAmount = '') {
        const modal = document.getElementById('engagement-modal');
        modal.classList.remove('hidden');
        document.getElementById('engagement_evenement_id').value = eventId;
        document.getElementById('engagement_evenement_title').textContent = eventName;
        document.getElementById('montant_total_prevu').value = currentAmount;
    }
    
    function closeEngagementModal() {
        const modal = document.getElementById('engagement-modal');
        modal.classList.add('hidden');
    }
    
    function setEngagementAmount(amount) {
        document.getElementById('montant_total_prevu').value = amount;
    }
</script>

<!-- COMPONENT: INTERACTIVE ENGAGEMENT MODAL -->
<div id="engagement-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] w-full max-w-lg border border-cedar-100 shadow-2xl overflow-hidden flex flex-col justify-between max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-5 bg-cedar-950 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-amber-400/20 flex items-center justify-center border border-amber-400/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-md font-black">Engagement de Participation</h3>
                    <p class="text-[10px] text-cedar-300 font-bold uppercase tracking-widest leading-none mt-1">Objectif de contribution</p>
                </div>
            </div>
            <button onclick="closeEngagementModal()" class="p-2 text-cedar-400 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="engagement-form" method="POST" action="{{ route('membre.participations.store') }}" class="p-6 space-y-6">
            @csrf
            
            <input type="hidden" name="evenement_id" id="engagement_evenement_id" value="">

            <div class="space-y-3">
                <p class="text-sm text-cedar-600 font-semibold leading-relaxed">
                    Saisissez le montant total que vous vous engagez à cotiser pour l'événement : <strong class="text-cedar-950" id="engagement_evenement_title">--</strong>.
                </p>
            </div>

            <!-- Input Amount -->
            <div class="space-y-1.5">
                <label for="montant_total_prevu" class="block text-[10px] font-black text-cedar-455 uppercase tracking-widest">Montant Total Prévu (FCFA)</label>
                <input type="number" id="montant_total_prevu" name="montant_total_prevu" min="1" required placeholder="Saisir le montant de votre engagement en FCFA" class="w-full bg-cedar-50/50 border border-cedar-100 rounded-2xl py-3.5 px-4 font-bold text-sm text-cedar-950 focus:outline-none focus:border-amber-400 focus:bg-white transition-all">
                
                <!-- Quick Select Pills -->
                <div class="flex flex-wrap gap-2 pt-1">
                    <button type="button" onclick="setEngagementAmount(5000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                        5 000 F
                    </button>
                    <button type="button" onclick="setEngagementAmount(10000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                        10 000 F
                    </button>
                    <button type="button" onclick="setEngagementAmount(25000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                        25 000 F
                    </button>
                    <button type="button" onclick="setEngagementAmount(50000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                        50 000 F
                    </button>
                    <button type="button" onclick="setEngagementAmount(100000)" class="px-4 py-2 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-extrabold rounded-xl border border-cedar-100/30 transition-all">
                        100 000 F
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-2xl shadow-lg shadow-cedar-950/10 transition-all flex items-center justify-center gap-1.5 mt-4">
                Valider mon engagement
            </button>
        </form>
    </div>
</div>
@endsection
