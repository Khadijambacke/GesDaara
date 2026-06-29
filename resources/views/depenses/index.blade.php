@extends('layouts.app')

@section('title', 'Gestion des Dépenses - SunuDaara')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Gestion des Dépenses
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Suivi et enregistrement des dépenses (logistique, repas, matériel) par événement.
        </p>
    </div>

    @if(in_array(Auth::user()->role, ['admin', 'owner', 'responsable', 'responsble']))
    <!-- Add Expense Button -->
    <button onclick="document.getElementById('createDepenseModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all w-full md:w-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        Enregistrer une dépense
    </button>
    @endif
</div>

<!-- Success Message -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-bold flex items-center gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    {{ session('success') }}
</div>
@endif

<!-- Error Messages -->
@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm font-bold space-y-1">
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

<!-- Expenses Table Card -->
<div class="bg-white rounded-[2rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-cedar-50/50 border-b border-cedar-100">
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500">Désignation / Libellé</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500">Montant</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500">Date</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500">Événement Associé</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500">Justificatif</th>
                    @if(in_array(Auth::user()->role, ['admin', 'owner']))
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-wider text-cedar-500 text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-100 text-sm font-semibold text-cedar-950">
                @forelse($depenses as $depense)
                <tr class="hover:bg-cedar-50/30 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-red-600 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-cedar-950">{{ $depense->libelle }}</p>
                                <p class="text-xs text-cedar-400 font-medium">Réf #DEP-{{ $depense->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-red-600 font-black">
                        - {{ number_format($depense->montant, 0, ',', ' ') }} F
                    </td>
                    <td class="px-6 py-5 text-cedar-500 font-bold">
                        {{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-5">
                        @if($depense->evenement)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-cedar-50 text-cedar-900 border border-cedar-200 text-xs font-black rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-cedar-600"></span>
                            {{ $depense->evenement->numeroevent }}
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-500 border border-gray-200 text-xs font-medium rounded-lg">
                            Générale
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        @if($depense->justificatif)
                        <a href="{{ asset('storage/' . $depense->justificatif) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 text-xs font-bold rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Voir la pièce
                        </a>
                        @else
                        <span class="text-xs text-cedar-400 font-medium italic">-</span>
                        @endif
                    </td>
                    @if(in_array(Auth::user()->role, ['admin', 'owner']))
                    <td class="px-6 py-5 text-right">
                        <form action="{{ route('admin.depenses.destroy', $depense->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette dépense ?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-all" title="Supprimer la dépense">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-cedar-400 font-medium">
                        Aucune dépense enregistrée pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Expense -->
<div id="createDepenseModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-[2rem] w-full max-w-lg max-h-[95vh] overflow-y-auto border border-cedar-100 shadow-2xl p-6 md:p-8 relative">
        <button onclick="document.getElementById('createDepenseModal').classList.add('hidden')" class="absolute top-6 right-6 p-2 text-cedar-400 hover:text-cedar-950 rounded-xl hover:bg-cedar-50 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-2xl font-black text-cedar-950 tracking-tight mb-2">Enregistrer une dépense</h3>
        <p class="text-sm text-cedar-500 font-medium mb-6">Associez une dépense logistique ou matérielle à un événement communautaire.</p>

        <form action="{{ route('admin.depenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- Libellé -->
            <div class="space-y-1.5">
                <label for="libelle" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Libellé / Désignation</label>
                <input type="text" name="libelle" id="libelle" placeholder="Ex: Achat de bâche, Location sonorisation..." required
                       class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all">
            </div>

            <!-- Montant -->
            <div class="space-y-1.5">
                <label for="montant" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Montant (FCFA)</label>
                <input type="number" name="montant" id="montant" placeholder="Ex: 75000" min="0" required
                       class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all">
            </div>

            <!-- Date -->
            <div class="space-y-1.5">
                <label for="date_depense" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Date de la Dépense</label>
                <input type="date" name="date_depense" id="date_depense" value="{{ date('Y-m-d') }}" required
                       class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all">
            </div>

            <!-- Événement lié -->
            <div class="space-y-1.5">
                <label for="evenement_id" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Événement lié</label>
                <select name="evenement_id" id="evenement_id"
                        class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all">
                    <option value="">-- Dépense générale (Aucun événement spécifique) --</option>
                    @foreach($evenements as $event)
                        <option value="{{ $event->id }}">{{ $event->numeroevent }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Justificatif -->
            <div class="space-y-1.5">
                <label for="justificatif" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Justificatif (Optionnel)</label>
                <div class="relative w-full">
                    <input type="file" name="justificatif" id="justificatif" accept="image/*,application/pdf"
                           class="w-full px-5 py-3.5 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-cedar-900 file:text-white hover:file:bg-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all cursor-pointer">
                </div>
                <p class="text-[10px] text-cedar-400 font-medium">Formats acceptés : PDF, JPG, PNG (Max 5Mo)</p>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="document.getElementById('createDepenseModal').classList.add('hidden')"
                        class="w-full py-4 border border-cedar-200 text-cedar-600 hover:bg-cedar-50 rounded-2xl text-sm font-black transition-all">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
