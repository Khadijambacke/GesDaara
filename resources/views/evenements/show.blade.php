@extends('layouts.app')

@section('title', 'Détails Événement - SunuDaara')

@section('content')
<!-- Styles spécifiques à l'impression -->
<style>
@media print {
    #sidebar, header, #overlay, form, .print\:hidden, button, a, nav, .mb-6 {
        display: none !important;
    }
    body, main, .flex-1, .overflow-y-auto {
        background: white !important;
        color: black !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: visible !important;
        height: auto !important;
    }
    .shadow-sm, .shadow-md, .shadow-xl {
        box-shadow: none !important;
        border: none !important;
    }
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    th, td {
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 12px 10px !important;
    }
}
</style>

<!-- Back navigation -->
<div class="mb-6 flex justify-between items-center print:hidden">
    <a href="{{ route('Toutevenement') }}" class="inline-flex items-center gap-2 text-cedar-600 hover:text-cedar-900 text-xs font-black uppercase tracking-wider transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour aux Événements
    </a>
    
    <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-cedar-50 text-cedar-950 border border-cedar-200 rounded-xl text-xs font-black shadow-sm transition-all">
        🖨️ Imprimer le rapport
    </button>
</div>


<!-- Success Message -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-bold flex items-center gap-3 shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    {{ session('success') }}
</div>
@endif

<!-- Error Messages -->
@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm font-bold space-y-1 shadow-sm">
    @foreach($errors->all() as $err)
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $err }}</span>
        </div>
    @endforeach
</div>
@endif


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

<div class="bg-gradient-to-br from-white to-cedar-50 rounded-[2rem] md:rounded-[2.5rem] p-5 md:p-8 md:p-6 md:p-10 border border-cedar-100 shadow-xl shadow-cedar-950/5 relative overflow-hidden mb-10">
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
            
            <div class="flex flex-wrap gap-4 text-xs font-semibold text-cedar-500 pt-2">
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
<<<<<<< HEAD
<div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-5 md:p-8 border-b border-cedar-100">
=======
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-8 border-b border-cedar-100">
>>>>>>> origin/master
        <h2 class="text-xl font-black text-cedar-950">Cotisations par Section</h2>
        <p class="text-xs text-cedar-500 mt-1">Vue d'ensemble des contributions groupées par section/cellule.</p>
    </div>
    <div class="overflow-x-auto">
<<<<<<< HEAD
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
=======
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
>>>>>>> origin/master
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
            <button onclick="closeCotisationModal()" class="text-white/60 hover:text-white text-xl">&times;</button>
        </div>

        {{-- Étape 1 : Formulaire --}}
        <form id="cot-form" action="{{ route('membre.cotisations.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">

            <div>
                <label class="block text-xs font-black text-cedar-700 mb-2">Montant (FCFA)</label>
                <input type="number" name="montantcotise" id="cot-montant" min="1" placeholder="Ex: 5000" required
                    class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200">
            </div>

            <div>
                <label class="block text-xs font-black text-cedar-700 mb-3">Méthode de paiement</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <button type="button" onclick="selectPayment(this,'wave')"
                        class="pay-opt p-4 rounded-xl border-2 border-cedar-100 transition-all text-center hover:border-blue-300">
                        <div class="text-2xl mb-1">🌊</div>
                        <div class="text-[11px] font-black text-cedar-700">Wave</div>
                    </button>
                    <button type="button" onclick="selectPayment(this,'orange_money')"
                        class="pay-opt p-4 rounded-xl border-2 border-cedar-100 transition-all text-center hover:border-orange-300">
                        <div class="text-2xl mb-1">📱</div>
                        <div class="text-[11px] font-black text-cedar-700">Orange Money</div>
                    </button>
                    <button type="button" onclick="selectPayment(this,'free_money')"
                        class="pay-opt p-4 rounded-xl border-2 border-cedar-100 transition-all text-center hover:border-green-300">
                        <div class="text-2xl mb-1">💸</div>
                        <div class="text-[11px] font-black text-cedar-700">Free Money</div>
                    </button>
                    <button type="button" onclick="selectPayment(this,'bank')"
                        class="pay-opt p-4 rounded-xl border-2 border-cedar-100 transition-all text-center hover:border-cedar-300">
                        <div class="text-2xl mb-1">🏦</div>
                        <div class="text-[11px] font-black text-cedar-700">Banque</div>
                    </button>
                </div>
                <input type="hidden" name="methodepayement" id="cot-methode">
                <p id="methode-err" class="text-[10px] text-red-500 mt-2 hidden">⚠ Choisissez une méthode de paiement.</p>
            </div>

            <button type="button" onclick="startPaymentSimulation()"
                class="w-full py-3 bg-cedar-950 text-white text-xs font-black rounded-xl hover:bg-cedar-800 transition-all shadow-lg">
                Confirmer le paiement
            </button>
        </form>

        {{-- Étape 2 : Simulation visuelle haute fidélité --}}
        <div id="pay-sim" class="hidden p-0">
            <!-- Dynamic operator header -->
            <div id="sim-header" class="px-6 py-4 text-white font-black flex justify-between items-center text-xs tracking-wider">
                <span id="sim-header-provider">OPERATOR</span>
                <span id="sim-header-title">SECURE TRANSACT</span>
            </div>
            
            <div class="p-6 space-y-5">
                <!-- Screen A: Phone Form (Wave, OM, Free) -->
                <div id="sim-screen-phone" class="space-y-4">
                    <p class="text-xs text-cedar-600 font-bold leading-relaxed">
                        Pour payer <strong id="sim-display-amount" class="text-cedar-950">0</strong> FCFA, veuillez saisir votre numéro de téléphone :
                    </p>
                    <div>
                        <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Numéro de téléphone (Sénégal)</label>
                        <input type="tel" id="sim-phone" placeholder="77 123 45 67" required
                            class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                    </div>
                    
                    <!-- Orange Money Payment Code Specifics -->
                    <div id="sim-om-code-wrapper" class="hidden space-y-1.5">
                        <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest">Code de Paiement OM (*144#)</label>
                        <input type="password" id="sim-om-code" placeholder="ex: 123456" maxlength="6"
                            class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                        <p class="text-[9px] text-cedar-400 font-medium">Composez le *144# puis option Paiement pour générer un code.</p>
                    </div>

                    <button type="button" id="sim-btn-phone" onclick="goToOTPScreen()"
                        class="w-full py-3 text-white text-xs font-black rounded-xl transition-all shadow-md">
                        Valider et Continuer
                    </button>
                </div>

                <!-- Screen B: Bank Form (Bank Credit Cards) -->
                <div id="sim-screen-bank" class="hidden space-y-4">
                    <p class="text-xs text-cedar-600 font-bold leading-relaxed">
                        Saisissez vos coordonnées de paiement pour valider le virement de <strong id="sim-bank-amount" class="text-cedar-950">0</strong> FCFA :
                    </p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Titulaire du compte</label>
                            <input type="text" id="sim-card-name" placeholder="Nom Complet"
                                class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Numéro de carte</label>
                            <input type="text" id="sim-card-number" placeholder="4000 1234 5678 9010"
                                class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Expiration</label>
                                <input type="text" id="sim-card-expiry" placeholder="MM/AA"
                                    class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">CVV</label>
                                <input type="password" id="sim-card-cvv" placeholder="•••" maxlength="3"
                                    class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:outline-none focus:ring-2 focus:ring-cedar-900">
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="startLoadingSimulation()"
                        class="w-full py-3 bg-cedar-900 text-white text-xs font-black rounded-xl transition-all shadow-md">
                        Valider le transfert bancaire
                    </button>
                </div>

                <!-- Screen C: SMS OTP Validation Code (Wave, Free, OM) -->
                <div id="sim-screen-otp" class="hidden space-y-4">
                    <p class="text-xs text-cedar-600 font-bold leading-relaxed">
                        Un code de vérification SMS (OTP) a été simulé. Entrez le code à 4 chiffres pour confirmer le débit de <strong id="sim-otp-amount" class="text-cedar-950">0</strong> FCFA :
                    </p>
                    <div>
                        <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Code de validation OTP</label>
                        <input type="text" id="sim-otp" placeholder="ex: 1234" maxlength="4"
                            class="w-full px-4 py-3 border border-cedar-200 rounded-xl text-lg font-black text-cedar-900 text-center tracking-widest focus:outline-none focus:ring-2 focus:ring-cedar-900">
                    </div>
                    <button type="button" id="sim-btn-otp" onclick="startLoadingSimulation()"
                        class="w-full py-3 text-white text-xs font-black rounded-xl transition-all shadow-md">
                        Confirmer la transaction
                    </button>
                </div>

                <!-- Screen D: Central Loading Spinner -->
                <div id="sim-screen-loading" class="hidden py-8 text-center space-y-4">
                    <div class="w-14 h-14 rounded-full border-4 border-cedar-100 border-t-cedar-950 animate-spin mx-auto"></div>
                    <p id="sim-loading-label" class="text-sm font-black text-cedar-950">Initialisation de la transaction...</p>
                    <p class="text-[10px] text-cedar-400 font-medium">Traitement hautement sécurisé de vos fonds</p>
                </div>

                <!-- Screen E: Success validation tick -->
                <div id="sim-screen-success" class="hidden py-8 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl mx-auto shadow-sm">✓</div>
                    <p class="text-sm font-black text-cedar-950">Paiement Réussi !</p>
                    <p class="text-[10px] text-cedar-400">Merci de votre contribution au Daara.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endisset

@push('scripts')
<script>
function closeCotisationModal() {
    document.getElementById('cotisation-modal').classList.add('hidden');
    // Réinitialiser le formulaire principal
    document.getElementById('cot-form').classList.remove('hidden');
    document.getElementById('pay-sim').classList.add('hidden');
    
    // Réinitialiser les écrans de simulation
    document.getElementById('sim-screen-phone').classList.add('hidden');
    document.getElementById('sim-screen-bank').classList.add('hidden');
    document.getElementById('sim-screen-otp').classList.add('hidden');
    document.getElementById('sim-screen-loading').classList.add('hidden');
    document.getElementById('sim-screen-success').classList.add('hidden');
    
    // Vider les champs
    document.getElementById('cot-methode').value = '';
    document.getElementById('sim-phone').value = '';
    document.getElementById('sim-om-code').value = '';
    document.getElementById('sim-otp').value = '';
    document.getElementById('sim-card-name').value = '';
    document.getElementById('sim-card-number').value = '';
    document.getElementById('sim-card-expiry').value = '';
    document.getElementById('sim-card-cvv').value = '';
    
    // Réinitialiser le style des boutons de paiement
    document.querySelectorAll('.pay-opt').forEach(b => {
        b.className = b.className.replace(/border-(blue|orange|green|cedar)-500/g,'border-cedar-100')
                                 .replace(/bg-(blue|orange|green|cedar)-50/g,'');
    });
}

function selectPayment(btn, method) {
    document.querySelectorAll('.pay-opt').forEach(b => {
        b.classList.remove('border-blue-500','bg-blue-50','border-orange-500','bg-orange-50',
                           'border-green-500','bg-green-50','border-cedar-500','bg-cedar-50');
        b.classList.add('border-cedar-100');
    });
    const map = { 
        wave: ['border-blue-500','bg-blue-50'], 
        orange_money: ['border-orange-500','bg-orange-50'],
        free_money: ['border-green-500','bg-green-50'], 
        bank: ['border-cedar-500','bg-cedar-50'] 
    };
    btn.classList.remove('border-cedar-100');
    btn.classList.add(...map[method]);
    document.getElementById('cot-methode').value = method;
    document.getElementById('methode-err').classList.add('hidden');
}

function startPaymentSimulation() {
    const montant = document.getElementById('cot-montant').value;
    const methode = document.getElementById('cot-methode').value;
    
    if (!montant || Number(montant) < 1) {
        document.getElementById('cot-montant').reportValidity();
        return;
    }
    if (!methode) {
        document.getElementById('methode-err').classList.remove('hidden');
        return;
    }

    // Remplir les montants affichés dans les écrans
    const formattedAmount = Number(montant).toLocaleString('fr-FR');
    document.getElementById('sim-display-amount').textContent = formattedAmount;
    document.getElementById('sim-bank-amount').textContent = formattedAmount;
    document.getElementById('sim-otp-amount').textContent = formattedAmount;

    // Configurer le branding de l'opérateur
    const header = document.getElementById('sim-header');
    const providerSpan = document.getElementById('sim-header-provider');
    const phoneBtn = document.getElementById('sim-btn-phone');
    const otpBtn = document.getElementById('sim-btn-otp');
    const omCodeWrapper = document.getElementById('sim-om-code-wrapper');
    
    // Réinitialiser les classes de couleur
    header.className = "px-6 py-4 text-white font-black flex justify-between items-center text-xs tracking-wider ";
    phoneBtn.className = "w-full py-3 text-white text-xs font-black rounded-xl transition-all shadow-md ";
    otpBtn.className = "w-full py-3 text-white text-xs font-black rounded-xl transition-all shadow-md ";
    omCodeWrapper.classList.add('hidden');

    if (methode === 'wave') {
        header.classList.add('bg-blue-500');
        phoneBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
        otpBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
        providerSpan.textContent = '🌊 WAVE SENEGAL';
        
        document.getElementById('sim-screen-phone').classList.remove('hidden');
        document.getElementById('sim-screen-bank').classList.add('hidden');
    } else if (methode === 'orange_money') {
        header.classList.add('bg-orange-500');
        phoneBtn.classList.add('bg-orange-500', 'hover:bg-orange-600');
        otpBtn.classList.add('bg-orange-500', 'hover:bg-orange-600');
        providerSpan.textContent = '🍊 ORANGE MONEY';
        omCodeWrapper.classList.remove('hidden');
        
        document.getElementById('sim-screen-phone').classList.remove('hidden');
        document.getElementById('sim-screen-bank').classList.add('hidden');
    } else if (methode === 'free_money') {
        header.classList.add('bg-red-600');
        phoneBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        otpBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        providerSpan.textContent = '🔴 FREE MONEY';
        
        document.getElementById('sim-screen-phone').classList.remove('hidden');
        document.getElementById('sim-screen-bank').classList.add('hidden');
    } else if (methode === 'bank') {
        header.classList.add('bg-cedar-950');
        providerSpan.textContent = '🏛️ SYSTEME BANCAIRE';
        
        document.getElementById('sim-screen-phone').classList.add('hidden');
        document.getElementById('sim-screen-bank').classList.remove('hidden');
    }

    // Masquer le formulaire initial et afficher l'interface de simulation
    document.getElementById('cot-form').classList.add('hidden');
    document.getElementById('pay-sim').classList.remove('hidden');
}

function goToOTPScreen() {
    const phone = document.getElementById('sim-phone').value;
    const methode = document.getElementById('cot-methode').value;
    
    if (!phone || phone.trim().length < 9) {
        alert("Veuillez saisir un numéro de téléphone valide.");
        document.getElementById('sim-phone').focus();
        return;
    }
    
    if (methode === 'orange_money') {
        const omCode = document.getElementById('sim-om-code').value;
        if (!omCode || omCode.trim().length < 4) {
            alert("Veuillez saisir votre code de paiement OM (*144#).");
            document.getElementById('sim-om-code').focus();
            return;
        }
    }

    // Afficher l'écran de chargement temporaire
    document.getElementById('sim-screen-phone').classList.add('hidden');
    document.getElementById('sim-screen-loading').classList.remove('hidden');
    document.getElementById('sim-loading-label').textContent = "Vérification du compte client...";

    setTimeout(() => {
        document.getElementById('sim-screen-loading').classList.add('hidden');
        document.getElementById('sim-screen-otp').classList.remove('hidden');
        // Préremplir un code OTP factice dans la console pour l'UX
        document.getElementById('sim-otp').value = Math.floor(1000 + Math.random() * 9000);
    }, 1200);
}

function startLoadingSimulation() {
    const methode = document.getElementById('cot-methode').value;
    
    // Cacher les écrans précédents
    document.getElementById('sim-screen-otp').classList.add('hidden');
    document.getElementById('sim-screen-bank').classList.add('hidden');
    
    // Afficher l'écran de chargement final
    document.getElementById('sim-screen-loading').classList.remove('hidden');
    document.getElementById('sim-loading-label').textContent = "Demande d'autorisation de débit en cours...";

    setTimeout(() => {
        document.getElementById('sim-loading-label').textContent = "Transaction en cours de finalisation...";
        setTimeout(() => {
            // Afficher le succès
            document.getElementById('sim-screen-loading').classList.add('hidden');
            document.getElementById('sim-screen-success').classList.remove('hidden');
            
            setTimeout(() => {
                // Soumettre le formulaire
                document.getElementById('cot-form').submit();
            }, 1500);
        }, 1500);
    }, 1500);
}
function printReceipt(cotis, eventName, userName) {
    const formattedAmount = Number(cotis.montantcotise).toLocaleString('fr-FR');
    const methodMap = {
        cash: 'Espèces',
        wave: 'Wave',
        orange_money: 'Orange Money',
        free_money: 'Free Money',
        bank: 'Virement bancaire'
    };
    const method = methodMap[cotis.methodepayement] || cotis.methodepayement;
    const date = new Date(cotis.datecotisations).toLocaleDateString('fr-FR');
    
    const printWindow = window.open('', '_blank', 'width=600,height=500');
    printWindow.document.write(`
        <html>
        <head>
            <title>Reçu de Cotisation</title>
            <style>
                body {
                    font-family: 'Courier New', Courier, monospace;
                    padding: 30px;
                    color: #3c1f19;
                    background-color: #fcfbf7;
                }
                .receipt-container {
                    border: 2px dashed #8c6b53;
                    padding: 25px;
                    border-radius: 12px;
                    max-width: 480px;
                    margin: auto;
                    background: white;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #8c6b53;
                    padding-bottom: 12px;
                    margin-bottom: 20px;
                }
                .header h2 {
                    margin: 0;
                    font-size: 22px;
                    text-transform: uppercase;
                    color: #3c1f19;
                    letter-spacing: 1px;
                }
                .header p {
                    margin: 5px 0 0 0;
                    font-size: 11px;
                    color: #8c6b53;
                    font-weight: bold;
                }
                .row {
                    display: flex;
                    justify-content: space-between;
                    margin: 12px 0;
                    font-size: 13px;
                }
                .amount-box {
                    background: #f7f3e8;
                    border: 1.5px solid #8c6b53;
                    padding: 12px;
                    text-align: center;
                    font-size: 20px;
                    font-weight: bold;
                    margin: 25px 0;
                    border-radius: 8px;
                    color: #3c1f19;
                }
                .footer {
                    text-align: center;
                    font-size: 10px;
                    margin-top: 30px;
                    border-top: 1px dashed #e2dcd0;
                    padding-top: 12px;
                    color: #8c6b53;
                }
            </style>
        </head>
        <body>
            <div class="receipt-container">
                <div class="header">
                    <h2>SUNUDAARA - REÇU</h2>
                    <p>Gestion solidaire de la communauté</p>
                </div>
                <div class="row">
                    <span><strong>N° Transaction:</strong></span>
                    <span>\${cotis.numerocontributions}</span>
                </div>
                <div class="row">
                    <span><strong>Date:</strong></span>
                    <span>\${date}</span>
                </div>
                <div class="row">
                    <span><strong>Membre:</strong></span>
                    <span>\${userName}</span>
                </div>
                <div class="row">
                    <span><strong>Événement:</strong></span>
                    <span>\${eventName}</span>
                </div>
                <div class="row">
                    <span><strong>Moyen de Paiement:</strong></span>
                    <span>\${method}</span>
                </div>
                <div class="amount-box">
                    Montant : \${formattedAmount} FCFA
                </div>
                <div class="footer">
                    <p>Merci pour votre contribution au Daara !</p>
                    <p>Document généré électroniquement</p>
                </div>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() { window.close(); }, 500);
                }
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

</script>
@endpush


@endsection
