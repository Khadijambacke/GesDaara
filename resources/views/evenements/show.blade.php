@extends('layouts.app')

@section('title', 'Détails Événement - SunuDaara')

@section('content')
<!-- Back navigation -->
<div class="mb-6">
    <a href="{{ route('Toutevenement') }}" class="inline-flex items-center gap-2 text-cedar-600 hover:text-cedar-900 text-xs font-black uppercase tracking-wider transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour aux Événements
    </a>
</div>

<!-- Event Info Card -->
@php
    $percentage = $evenement->objectifmontant > 0 ? min(100, round(($evenement->montantotalparticipe / $evenement->objectifmontant) * 100)) : 0;
    
    // Statut styling
    $statusClass = 'bg-cedar-100 text-cedar-800 border-cedar-200';
    $statusText = 'Planifié';
    if (trim($evenement->statut) === 'En_cours') {
        $statusClass = 'bg-green-100 text-green-800 border-green-200';
        $statusText = 'En Cours';
    } elseif (trim($evenement->statut) === 'termine') {
        $statusClass = 'bg-gray-100 text-gray-800 border-gray-200';
        $statusText = 'Terminé';
    }
@endphp

<div class="bg-gradient-to-br from-white to-cedar-50 rounded-[2.5rem] p-8 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 relative overflow-hidden mb-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
        <!-- Event Name and Status -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 bg-cedar-900 text-white text-[10px] font-black rounded-lg uppercase tracking-wider">
                    ID # {{ $evenement->id }}
                </span>
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold border {{ $statusClass }}">
                    {{ $statusText }}
                </span>
            </div>
            
            <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
                {{ $evenement->numeroevent }}
            </h1>
            
            <div class="flex flex-wrap gap-4 text-xs font-semibold text-cedar-550 pt-2">
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Début : {{ \Carbon\Carbon::parse($evenement->datedebut)->format('d/m/Y') }}</span>
                </div>
                
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Fin : {{ \Carbon\Carbon::parse($evenement->datecloture)->format('d/m/Y') }}</span>
                </div>
                
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Mise minimale : <strong>{{ number_format($evenement->cotisations, 0, ',', ' ') }} F</strong></span>
                </div>
            </div>
        </div>

        <!-- Progress Tracker -->
        <div class="bg-white p-6 rounded-[2rem] border border-cedar-100 shadow-md">
            <div class="flex justify-between items-end mb-3">
                <span class="text-[10px] font-black text-cedar-400 uppercase tracking-wider">Collecté</span>
                <span class="text-sm font-black text-cedar-950">{{ $percentage }}%</span>
            </div>
            
            <div class="w-full bg-cedar-50 h-3 rounded-full overflow-hidden border border-cedar-100 mb-3">
                <div class="bg-gradient-to-r from-cedar-700 to-cedar-900 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>

            <div class="flex justify-between text-xs font-bold mt-2">
                <span class="text-cedar-900">{{ number_format($evenement->montantotalparticipe, 0, ',', ' ') }} F</span>
                <span class="text-cedar-400">sur {{ number_format($evenement->objectifmontant, 0, ',', ' ') }} F</span>
            </div>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- ADMIN / OWNER VIEW: Cotisations par Section  --}}
{{-- ============================================ --}}
@isset($cotisationsParSection)
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">Cotisations par Section</h2>
        <p class="text-xs text-cedar-500 mt-1">Vue d'ensemble des contributions groupées par section/cellule.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-cedar-50 border-b border-cedar-100">
                <tr class="text-[10px] uppercase tracking-[0.2em] text-cedar-500 font-black">
                    <th class="px-6 py-5">Section</th>
                    <th class="px-6 py-5 text-center">Transactions</th>
                    <th class="px-6 py-5 text-right">Total Cotisé</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50">
                @forelse($cotisationsParSection as $section)
                <tr class="hover:bg-cedar-50/50 transition-all">
                    <td class="px-6 py-5 text-xs font-extrabold text-cedar-950">{{ $section->nom_section }}</td>
                    <td class="px-6 py-5 text-xs font-bold text-cedar-600 text-center">{{ $section->nombre_transactions }}</td>
                    <td class="px-6 py-5 text-xs font-black text-cedar-950 text-right">{{ number_format($section->total_cotise, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-12 text-center text-xs text-cedar-400 font-bold">Aucune cotisation enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endisset

{{-- ============================================ --}}
{{-- RESPONSABLE VIEW: Membres de la section      --}}
{{-- ============================================ --}}
@isset($membresSection)
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">Membres de votre Section</h2>
        <p class="text-xs text-cedar-500 mt-1">Cotisations et engagements des membres de votre cellule pour cet événement.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-cedar-50 border-b border-cedar-100">
                <tr class="text-[10px] uppercase tracking-[0.2em] text-cedar-500 font-black">
                    <th class="px-6 py-5">Membre</th>
                    <th class="px-6 py-5">Compte</th>
                    <th class="px-6 py-5">Engagement</th>
                    <th class="px-6 py-5 text-right">Cotisé</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50">
                @forelse($membresSection as $membre)
                @php
                    $participation = $membre->participations->first();
                    $prevu = $participation->montant_total_prevu ?? 0;
                    $paye = $membre->total_cotise_event ?? 0;
                    $pctMembre = $prevu > 0 ? min(100, round(($paye / $prevu) * 100)) : 0;
                @endphp
                <tr class="hover:bg-cedar-50/50 transition-all">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-cedar-100 text-cedar-950 flex items-center justify-center font-black text-xs">
                                {{ strtoupper(substr($membre->prenom ?? 'M', 0, 1) . substr($membre->nom ?? 'B', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-cedar-950">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                <p class="text-[9px] text-cedar-400 font-bold">{{ $membre->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-xs font-bold text-cedar-600">
                        {{ $membre->compte ? number_format($membre->compte->montant_total, 0, ',', ' ') . ' F' : 'N/A' }}
                    </td>
                    <td class="px-6 py-5">
                        @if($prevu > 0)
                        <div class="space-y-1">
                            <div class="flex justify-between text-[9px] font-bold">
                                <span class="text-cedar-600">{{ number_format($paye, 0, ',', ' ') }} / {{ number_format($prevu, 0, ',', ' ') }} F</span>
                                <span class="text-cedar-950">{{ $pctMembre }}%</span>
                            </div>
                            <div class="w-full bg-cedar-50 h-2 rounded-full overflow-hidden border border-cedar-100">
                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-700 h-full rounded-full" style="width: {{ $pctMembre }}%"></div>
                            </div>
                        </div>
                        @else
                        <span class="px-2 py-0.5 bg-cedar-100 text-cedar-700 text-[9px] font-black rounded-md">Non défini</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-xs font-black text-cedar-950 text-right">{{ number_format($paye, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-xs text-cedar-400 font-bold">Aucun membre dans votre section.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endisset

{{-- ============================================ --}}
{{-- MEMBRE VIEW: Objectif + Cotiser + Historique  --}}
{{-- ============================================ --}}
@isset($mesCotisations)
@php
    $prevuM = $maParticipation->montant_total_prevu ?? 0;
    $payeM = $maParticipation->montant_paye ?? 0;
    $pctM = $prevuM > 0 ? min(100, round(($payeM / $prevuM) * 100)) : 0;
@endphp

{{-- Mon Objectif Personnel --}}
<div class="bg-gradient-to-br from-white to-cedar-50 rounded-[2.5rem] p-8 border border-cedar-100 shadow-xl shadow-cedar-950/5 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
        <div>
            <h2 class="text-lg font-black text-cedar-950 mb-1">Mon Objectif Personnel</h2>
            <p class="text-xs text-cedar-500">Définissez le montant que vous souhaitez contribuer à cet événement.</p>
            @if($prevuM > 0)
            <div class="mt-4 space-y-2">
                <div class="flex justify-between text-xs font-bold">
                    <span class="text-cedar-700">{{ number_format($payeM, 0, ',', ' ') }} F cotisés</span>
                    <span class="text-cedar-950">{{ $pctM }}%</span>
                </div>
                <div class="w-full bg-cedar-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-700 h-full rounded-full transition-all duration-500" style="width: {{ $pctM }}%"></div>
                </div>
                <p class="text-[10px] text-cedar-400 font-bold">Objectif : {{ number_format($prevuM, 0, ',', ' ') }} FCFA</p>
            </div>
            @endif
        </div>
        <div class="flex justify-end">
            <button onclick="document.getElementById('engagement-modal').classList.remove('hidden')"
                class="px-6 py-3 bg-cedar-950 text-white text-xs font-black rounded-2xl hover:bg-cedar-800 transition-all shadow-lg">
                {{ $prevuM > 0 ? '✏️ Modifier mon objectif' : '🎯 Définir mon objectif' }}
            </button>
        </div>
    </div>
</div>

{{-- Bouton Cotiser --}}
<div class="bg-gradient-to-r from-cedar-950 to-cedar-800 rounded-[2.5rem] p-8 text-white mb-8 shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIi8+PC9zdmc+')] opacity-50"></div>
    <div class="relative flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-black">Cotiser pour cet événement</h3>
            <p class="text-xs text-cedar-200 mt-1">Effectuez un paiement sécurisé via Wave, Orange Money ou Free Money.</p>
        </div>
        <button onclick="document.getElementById('cotisation-modal').classList.remove('hidden')"
            class="px-8 py-4 bg-white text-cedar-950 text-xs font-black rounded-2xl hover:bg-cedar-50 transition-all shadow-lg whitespace-nowrap">
            💰 Cotiser maintenant
        </button>
    </div>
</div>

{{-- Historique de mes cotisations --}}
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">Mes Contributions</h2>
        <p class="text-xs text-cedar-500 mt-1">Historique de vos cotisations pour cet événement.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-cedar-50 border-b border-cedar-100">
                <tr class="text-[10px] uppercase tracking-[0.2em] text-cedar-500 font-black">
                    <th class="px-6 py-5">Référence</th>
                    <th class="px-6 py-5">Date</th>
                    <th class="px-6 py-5">Méthode</th>
                    <th class="px-6 py-5 text-right">Montant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50">
                @forelse($mesCotisations as $cotis)
                <tr class="hover:bg-cedar-50/50 transition-all">
                    <td class="px-6 py-5 text-xs font-extrabold text-cedar-950">{{ $cotis->numerocontributions }}</td>
                    <td class="px-6 py-5 text-xs font-medium text-cedar-900">{{ \Carbon\Carbon::parse($cotis->datecotisations)->format('d/m/Y') }}</td>
                    <td class="px-6 py-5"><span class="px-3 py-1 bg-cedar-50 border border-cedar-100 text-cedar-950 text-[10px] font-black rounded-lg uppercase">{{ $cotis->methodepayement }}</span></td>
                    <td class="px-6 py-5 text-xs font-black text-cedar-950 text-right">{{ number_format($cotis->montantcotise, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-xs text-cedar-400 font-bold">Vous n'avez pas encore cotisé pour cet événement.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL: Définir l'objectif --}}
<div id="engagement-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden">
        <div class="px-6 py-5 bg-cedar-950 text-white flex items-center justify-between">
            <h3 class="text-sm font-black">🎯 Mon Engagement</h3>
            <button onclick="document.getElementById('engagement-modal').classList.add('hidden')" class="text-white/60 hover:text-white text-xl">&times;</button>
        </div>
        <form action="{{ route('membre.participations.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
            <div>
                <label class="block text-xs font-black text-cedar-700 mb-2">Montant objectif (FCFA)</label>
                <input type="number" name="montant_total_prevu" min="1" value="{{ $prevuM ?: '' }}" placeholder="Ex: 50000" required
                    class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200">
            </div>
            <button type="submit" class="w-full py-3 bg-cedar-950 text-white text-xs font-black rounded-xl hover:bg-cedar-800 transition-all">
                Enregistrer mon objectif
            </button>
        </form>
    </div>
</div>

{{-- MODAL: Cotisation avec choix paiement --}}
<div id="cotisation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 bg-cedar-950 text-white flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black">💰 Nouvelle Cotisation</h3>
                <p class="text-[10px] text-cedar-300 mt-0.5">Espace de paiement sécurisé</p>
            </div>
            <button onclick="document.getElementById('cotisation-modal').classList.add('hidden')" class="text-white/60 hover:text-white text-xl">&times;</button>
        </div>
        <form action="{{ route('membre.cotisations.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">

            {{-- Montant --}}
            <div>
                <label class="block text-xs font-black text-cedar-700 mb-2">Montant (FCFA)</label>
                <input type="number" name="montantcotise" min="1" placeholder="Ex: 5000" required
                    class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200">
            </div>

            {{-- Méthode de paiement --}}
            <div>
                <label class="block text-xs font-black text-cedar-700 mb-3">Méthode de paiement</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="methodepayement" value="wave" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-cedar-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all text-center">
                            <div class="text-lg mb-1">🌊</div>
                            <span class="text-[10px] font-black text-cedar-700 peer-checked:text-blue-700">Wave</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="methodepayement" value="orange_money" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-cedar-100 peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all text-center">
                            <div class="text-lg mb-1">🍊</div>
                            <span class="text-[10px] font-black text-cedar-700 peer-checked:text-orange-700">Orange Money</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="methodepayement" value="free_money" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-cedar-100 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all text-center">
                            <div class="text-lg mb-1">📱</div>
                            <span class="text-[10px] font-black text-cedar-700 peer-checked:text-green-700">Free Money</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="methodepayement" value="bank" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-cedar-100 peer-checked:border-cedar-500 peer-checked:bg-cedar-50 transition-all text-center">
                            <div class="text-lg mb-1">🏦</div>
                            <span class="text-[10px] font-black text-cedar-700 peer-checked:text-cedar-800">Banque</span>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-cedar-950 text-white text-xs font-black rounded-xl hover:bg-cedar-800 transition-all shadow-lg">
                Confirmer le paiement
            </button>
        </form>
    </div>
</div>
@endisset

@endsection
