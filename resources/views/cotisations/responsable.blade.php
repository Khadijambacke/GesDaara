@extends('layouts.app')

@section('title', 'Cotisations de ma section - SunuDaara')

@section('content')
<!-- Styles spécifiques à l'impression -->
<style>
@media print {
    #sidebar, header, #overlay, form, .print\:hidden, button, a, nav, .md\:flex, .grid.grid-cols-1.sm\:grid-cols-3 {
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

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">Cotisations de ma section</h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Contributions des membres de votre section.
        </p>
    </div>
    
    <!-- Boutons d'export et d'impression -->
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto print:hidden">
        <a href="{{ route('cotisations.export', request()->query()) }}" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-white hover:bg-cedar-50 text-cedar-950 border border-cedar-200 rounded-2xl text-xs font-black shadow-sm transition-all w-full sm:w-auto">
            📥 Exporter les données (CSV)
        </a>
        <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-xs font-black shadow-lg shadow-cedar-950/10 transition-all w-full sm:w-auto">
            🖨️ Imprimer le rapport
        </button>
    </div>
</div>


<!-- KPIs -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-cedar-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-cedar-100 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-cedar-400 font-semibold uppercase tracking-wider">Membres</p>
            <p class="text-2xl font-black text-cedar-950">{{ $totalMembres }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-cedar-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-cedar-100 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-cedar-400 font-semibold uppercase tracking-wider">Ont cotisé</p>
            <p class="text-2xl font-black text-cedar-950">{{ $membresActifs }}</p>
        </div>
    </div>
    <div class="bg-cedar-900 rounded-2xl p-6 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cedar-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-cedar-300 font-semibold uppercase tracking-wider">Total collecté</p>
            <p class="text-2xl font-black text-white">{{ number_format($totalCotise, 0, ',', ' ') }} <span class="text-sm font-medium">FCFA</span></p>
        </div>
    </div>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('responsable.cotisations') }}" class="bg-white rounded-2xl border border-cedar-100 shadow-sm p-6 mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

        <!-- Recherche nom -->
        <div>
            <label class="block text-xs font-bold text-cedar-600 uppercase tracking-wider mb-2">Nom du membre</label>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Rechercher..."
                   class="w-full px-4 py-2.5 rounded-xl border border-cedar-200 bg-cedar-50 text-cedar-900 text-sm focus:outline-none focus:ring-2 focus:ring-cedar-400">
        </div>

        <!-- Filtre événement -->
        <div>
            <label class="block text-xs font-bold text-cedar-600 uppercase tracking-wider mb-2">Événement</label>
            <select name="evenement_id" class="w-full px-4 py-2.5 rounded-xl border border-cedar-200 bg-cedar-50 text-cedar-900 text-sm focus:outline-none focus:ring-2 focus:ring-cedar-400">
                <option value="">Tous les événements</option>
                @foreach($evenements as $evt)
                    <option value="{{ $evt->id }}" {{ $evenementId == $evt->id ? 'selected' : '' }}>
                        {{ $evt->numeroevent }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date début -->
        <div>
            <label class="block text-xs font-bold text-cedar-600 uppercase tracking-wider mb-2">Date début</label>
            <input type="date" name="date_debut" value="{{ $dateDebut }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-cedar-200 bg-cedar-50 text-cedar-900 text-sm focus:outline-none focus:ring-2 focus:ring-cedar-400">
        </div>

        <!-- Date fin -->
        <div>
            <label class="block text-xs font-bold text-cedar-600 uppercase tracking-wider mb-2">Date fin</label>
            <input type="date" name="date_fin" value="{{ $dateFin }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-cedar-200 bg-cedar-50 text-cedar-900 text-sm focus:outline-none focus:ring-2 focus:ring-cedar-400">
        </div>

        <!-- Boutons -->
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-bold transition-all">
                Filtrer
            </button>
            <a href="{{ route('responsable.cotisations') }}" class="px-4 py-2.5 bg-cedar-100 hover:bg-cedar-200 text-cedar-800 rounded-xl text-sm font-bold transition-all">
                ✕
            </a>
        </div>
    </div>
</form>

<!-- Tableau -->
<div class="bg-white rounded-2xl border border-cedar-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-cedar-50 border-b border-cedar-100">
                    <th class="text-left px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">Membre</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">Matricule</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">Solde compte</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">
                        {{ $evenementSelectionne ? 'Cotisé (' . $evenementSelectionne->numeroevent . ')' : 'Total cotisé (filtre)' }}
                    </th>
                    <th class="text-center px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">Versements</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-cedar-500 uppercase tracking-wider">Détail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50">
                @forelse($membres as $membre)
                <tr class="hover:bg-cedar-50/50 transition-colors">
                    <!-- Membre -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl overflow-hidden bg-cedar-100 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(($membre->prenom ?? $membre->Prenom) . ' ' . ($membre->nom ?? $membre->Nom)) }}&background=f5ebdf&color=3c1f19&size=64"
                                     alt="{{ $membre->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-cedar-900">{{ $membre->prenom ?? $membre->Prenom }} {{ $membre->nom ?? $membre->Nom }}</p>
                                <p class="text-xs text-cedar-400">{{ $membre->telephone ?? '—' }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Matricule -->
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-cedar-100 text-cedar-700 rounded-lg text-xs font-mono font-semibold">
                            {{ $membre->matricule ?? '—' }}
                        </span>
                    </td>

                    <!-- Solde compte -->
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-cedar-900">
                            {{ number_format($membre->compte ? $membre->compte->montant_total : 0, 0, ',', ' ') }}
                            <span class="text-xs font-normal text-cedar-400">FCFA</span>
                        </span>
                    </td>

                    <!-- Cotisé (filtré) -->
                    <td class="px-6 py-4 text-right">
                        @if($membre->montant_cotise_filtre > 0)
                            <span class="font-black text-cedar-800">
                                {{ number_format($membre->montant_cotise_filtre, 0, ',', ' ') }}
                                <span class="text-xs font-normal text-cedar-400">FCFA</span>
                            </span>
                        @else
                            <span class="text-cedar-300 font-medium">0 FCFA</span>
                        @endif
                    </td>

                    <!-- Nb versements -->
                    <td class="px-6 py-4 text-center">
                        @if($membre->nb_cotisations_filtre > 0)
                            <span class="inline-flex items-center justify-center w-7 h-7 bg-cedar-900 text-white rounded-lg text-xs font-bold">
                                {{ $membre->nb_cotisations_filtre }}
                            </span>
                        @else
                            <span class="text-cedar-300">—</span>
                        @endif
                    </td>

                    <!-- Détail cotisations -->
                    <td class="px-6 py-4">
                        @if($membre->detail_cotisations->count() > 0)
                            <div class="space-y-1 max-h-24 overflow-y-auto">
                                @foreach($membre->detail_cotisations as $cot)
                                <div class="text-xs text-cedar-600 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-cedar-400 rounded-full flex-shrink-0"></span>
                                    <span>{{ number_format($cot->montantcotise, 0, ',', ' ') }} FCFA</span>
                                    <span class="text-cedar-300">·</span>
                                    <span class="text-cedar-400">{{ \Carbon\Carbon::parse($cot->datecotisations)->format('d/m/Y') }}</span>
                                    @if($cot->evenement && !$evenementSelectionne)
                                        <span class="text-cedar-300">·</span>
                                        <span class="text-cedar-400 truncate max-w-20">{{ $cot->evenement->numeroevent }}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-cedar-300 text-xs">Aucune cotisation</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-cedar-50 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-cedar-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-cedar-400 font-medium">Aucun membre trouvé</p>
                            <p class="text-cedar-300 text-xs">Essayez de modifier vos filtres</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
