@extends('layouts.app')

@section('title', 'Gestion des Événements - SunuDaara')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Gestion des Événements
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Suivi des événements communautaires et des contributions financières.
        </p>
    </div>

    @if(in_array(Auth::user()->role, ['admin', 'responsable', 'responsble']))
    <!-- Add Event Button -->
    <button onclick="document.getElementById('createEventModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all w-full md:w-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        Créer un événement
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

<!-- Events Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($evenements as $event)
        @php
            $percentage = $event->objectifmontant > 0 ? min(100, round(($event->montantotalparticipe / $event->objectifmontant) * 100)) : 0;
            
            // verifications de la statut de l'evenemnt
            $statusClass = 'bg-cedar-100 text-cedar-800 border-cedar-200';
            $statusText = 'Planifié';
            if (trim($event->statut) === 'En_cours') {
                $statusClass = 'bg-green-100 text-green-800 border-green-200';
                $statusText = 'En Cours';
            } elseif (trim($event->statut) === 'termine') {
                $statusClass = 'bg-gray-100 text-gray-800 border-gray-200';
                $statusText = 'Terminé';
            }
        @endphp
        
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 p-5 md:p-8 flex flex-col justify-between hover:scale-[1.02] hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
            
            <div>
                <!-- Header Card -->
                <div class="flex justify-between items-start mb-6">
                    <span class="px-3 py-1 bg-cedar-50 text-cedar-950 text-[10px] font-black rounded-lg border border-cedar-100 uppercase tracking-wider">
                        # {{ $event->id }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold border {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </div>
                
                <!-- Event Title -->
                <h3 class="text-xl font-black text-cedar-950 tracking-tight line-clamp-2">
                    {{ $event->numeroevent }}
                </h3>
                
                <!-- Dates Info -->
                <div class="flex items-center gap-2 text-cedar-400 text-xs font-semibold mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Du {{ \Carbon\Carbon::parse($event->datedebut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($event->datecloture)->format('d/m/Y') }}</span>
                </div>

                <!-- Financial targets & progress -->
                <div class="mt-8 space-y-3">
                    <div class="flex justify-between items-end text-xs">
                        <span class="text-cedar-400 font-extrabold uppercase">Collecté</span>
                        <span class="text-cedar-950 font-black">{{ number_format($event->montantotalparticipe, 0, ',', ' ') }} / {{ number_format($event->objectifmontant, 0, ',', ' ') }} F</span>
                    </div>
                    
                    <div class="w-full bg-cedar-50 h-3 rounded-full overflow-hidden border border-cedar-100">
                        <div class="bg-gradient-to-r from-cedar-700 to-cedar-900 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center text-[10px] text-cedar-400 font-bold">
                        <span>Cotisation p.m. : <strong>{{ number_format($event->cotisations, 0, ',', ' ') }} F</strong></span>
                        <span class="text-cedar-850 font-black">{{ $percentage }}%</span>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-8 pt-6 border-t border-cedar-50 flex flex-col gap-3">
                <div class="flex gap-3">
                    <!-- View Event -->
                    <a href="{{ route('showevent', $event->id) }}" class="flex-1 text-center py-3 bg-cedar-50 hover:bg-cedar-100 text-cedar-950 text-xs font-black rounded-xl transition-all border border-cedar-100">
                        Voir détails
                    </a>

                    <!-- Log Cotisation Button -->
                    <button onclick="openCotisationModal('{{ $event->id }}', '{{ addslashes($event->numeroevent) }}')" class="flex-1 py-3 bg-cedar-900 hover:bg-cedar-950 text-white text-xs font-black rounded-xl transition-all shadow-md">
                        Cotiser
                    </button>
                </div>

                @if(in_array(Auth::user()->role, ['admin', 'responsable', 'responsble']))
                <!-- Admin Event Controls -->
                <div class="flex justify-end items-center gap-4 mt-2">
                    <a href="{{ route('editevent', $event->id) }}" class="text-xs text-cedar-600 hover:text-cedar-900 font-bold">
                        Modifier
                    </a>
                    
                    <form method="POST" action="{{ route('deleteevent', $event->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ? Toutes les cotisations associées seront également supprimées.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold">
                            Supprimer
                        </button>
                    </form>
                </div>
                @endif
            </div>

        </div>
    @empty
        <div class="md:col-span-3 text-center py-16 bg-white rounded-[2rem] md:rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-cedar-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-cedar-950 font-black text-xl">Aucun événement disponible</p>
            <p class="text-cedar-500 font-semibold text-sm mt-2">Les événements créés par l'administration apparaîtront ici.</p>
        </div>
    @endforelse
</div>

<!-- ================= MODAL DE CRÉATION D'ÉVÉNEMENT (ADMIN ONLY) ================= -->
@if(in_array(Auth::user()->role, ['admin', 'responsable', 'responsble']))
<div id="createEventModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] w-full max-w-lg mx-4 p-5 md:p-8 max-h-[90vh] overflow-y-auto border border-cedar-100 shadow-2xl relative">
        <button onclick="document.getElementById('createEventModal').classList.add('hidden')" class="absolute top-6 right-6 p-2 bg-cedar-50 rounded-full text-cedar-500 hover:text-cedar-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-2xl font-black text-cedar-950 tracking-tight mb-2">Créer un nouvel événement</h3>
        <p class="text-xs text-cedar-500 font-medium mb-6">Planifiez et définissez les objectifs de contribution.</p>

        <form method="POST" action="{{ route('storeevent') }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Nom / Libellé de l'événement</label>
                <input type="text" name="numeroevent" required placeholder="ex: Magal Touba 2026, Travaux Daara..." class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Objectif (FCFA)</label>
                    <input type="number" name="objectifmontant" required min="0" placeholder="ex: 1500000" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Cotisation p.m. (FCFA)</label>
                    <input type="number" name="cotisations" required min="0" placeholder="ex: 5000" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Date de début</label>
                    <input type="date" name="datedebut" required class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Date de clôture</label>
                    <input type="date" name="datecloture" required class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Statut de départ</label>
                <select name="statut" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                    <option value="planifie">Planifié</option>
                    <option value="En_cours">En cours</option>
                    <option value="termine">Terminé</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-lg shadow-cedar-950/20 transition-all mt-4">
                Créer l'événement
            </button>
        </form>
    </div>
</div>
@endif

<!-- ================= MODAL D'ENREGISTREMENT DE COTISATION ================= -->
<div id="cotisationModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] w-full max-w-lg mx-4 p-5 md:p-8 max-h-[90vh] overflow-y-auto border border-cedar-100 shadow-2xl relative">
        <button onclick="document.getElementById('cotisationModal').classList.add('hidden')" class="absolute top-6 right-6 p-2 bg-cedar-50 rounded-full text-cedar-500 hover:text-cedar-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-2xl font-black text-cedar-950 tracking-tight mb-1">Enregistrer une Cotisation</h3>
        <p id="cotisationModalEventName" class="text-xs text-cedar-500 font-extrabold underline mb-6">Événement : --</p>

        <form method="POST" action="{{ route('storecotisation') }}" class="space-y-5">
            @csrf
            
            <!-- Hidden Event ID input -->
            <input type="hidden" name="evenement_id" id="cotisationEventId" value="">

            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Matricule du Membre</label>
                <input type="text" name="matricule" placeholder="ex: SD-2026-1234" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none mb-3">
                
                <div class="text-center text-xs font-bold text-cedar-400 my-2">— OU SÉLECTIONNER DANS LA LISTE —</div>
                
                <select name="membre_id" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                    <option value="">-- Choisir un membre --</option>
                    @foreach($membres as $mbr)
                        <option value="{{ $mbr->id }}">{{ $mbr->prenom }} {{ $mbr->nom }} ({{ $mbr->matricule }} - {{ $mbr->cellule->nomsection ?? 'Sans section' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Montant Cotisé (FCFA)</label>
                    <input type="number" name="montantcotise" required min="0" placeholder="ex: 5000" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                </div>
                
                <div>
                    <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Méthode de Paiement</label>
                    <select name="methodepayement" required class="w-full px-4 py-3 bg-cedar-50 border border-cedar-100 rounded-xl text-sm font-semibold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none">
                        <option value="cash">Espèces (Cash)</option>
                        <option value="wave">Wave</option>
                        <option value="orange_money">Orange Money</option>
                        <option value="free_money">Free Money</option>
                        <option value="bank">Virement Bancaire</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-lg shadow-cedar-950/20 transition-all mt-4">
                Valider la contribution
            </button>
        </form>
    </div>
</div>

<script>
    function openCotisationModal(eventId, eventName) {
        document.getElementById('cotisationEventId').value = eventId;
        document.getElementById('cotisationModalEventName').textContent = "Événement : " + eventName;
        document.getElementById('cotisationModal').classList.remove('hidden');
    }
</script>
@endsection
