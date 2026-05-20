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

<!-- Cotisations List Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">
            Contributions Enregistrées
        </h2>
        <p class="text-xs text-cedar-500 mt-1">
            @if(Auth::user()->role === 'admin')
                Historique global des paiements et cotisations des membres pour cet événement.
            @else
                Historique des cotisations des membres de votre section (cellule) pour cet événement.
            @endif
        </p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left">
            <thead class="bg-cedar-50 border-b border-cedar-100">
                <tr class="text-[10px] uppercase tracking-[0.2em] text-cedar-500 font-black">
                    <th class="px-6 py-5">Référence</th>
                    <th class="px-6 py-5">Membre</th>
                    <th class="px-6 py-5">Section / Cellule</th>
                    <th class="px-6 py-5">Date</th>
                    <th class="px-6 py-5">Méthode</th>
                    <th class="px-6 py-5 text-right">Montant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50">
                @forelse($cotisations as $cotis)
                <tr class="hover:bg-cedar-50/50 transition-all">
                    <!-- Référence -->
                    <td class="px-6 py-5 text-xs font-extrabold text-cedar-950 tracking-wider">
                        {{ $cotis->numerocontributions }}
                    </td>
                    <!-- Membre -->
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-cedar-100 text-cedar-950 flex items-center justify-center font-black text-xs">
                                {{ strtoupper(substr($cotis->users->prenom ?? 'M', 0, 1) . substr($cotis->users->nom ?? 'B', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-cedar-950">{{ $cotis->users->prenom ?? 'Membre' }} {{ $cotis->users->nom ?? 'Inconnu' }}</p>
                                <p class="text-[9px] text-cedar-400 font-bold font-mono">{{ $cotis->users->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <!-- Cellule -->
                    <td class="px-6 py-5 text-xs font-semibold text-cedar-600">
                        {{ $cotis->users->cellule->nom ?? 'Aucune' }}
                    </td>
                    <!-- Date -->
                    <td class="px-6 py-5 text-xs font-medium text-cedar-900">
                        {{ \Carbon\Carbon::parse($cotis->datecotisations)->format('d/m/Y') }}
                    </td>
                    <!-- Méthode -->
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-cedar-50 border border-cedar-100 text-cedar-950 text-[10px] font-black rounded-lg uppercase tracking-wide">
                            {{ $cotis->methodepayement }}
                        </span>
                    </td>
                    <!-- Montant -->
                    <td class="px-6 py-5 text-xs font-black text-cedar-950 text-right">
                        {{ number_format($cotis->montantcotise, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-xs text-cedar-400 font-bold">
                        Aucune contribution n'a été enregistrée pour cet événement pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
