@extends('layouts.app')

@section('title', 'Modifier l\'Événement - SunuDaara')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Modifier l'Événement
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Mettez à jour les informations et les objectifs de cet événement.
        </p>
    </div>
    
    <a href="{{ route('Toutevenement') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-white text-cedar-900 border border-cedar-200 hover:bg-cedar-50 rounded-2xl text-sm font-black shadow-sm transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour aux événements
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden max-w-2xl">
    
    <div class="p-8 border-b border-cedar-100 bg-cedar-50/50">
        <h2 class="text-xl font-black text-cedar-950">Détails de l'Événement</h2>
        <p class="text-xs text-cedar-500 mt-1">Modifiez les champs ci-dessous pour mettre à jour la planification.</p>
    </div>

    <form method="POST" action="{{ route('updateevent', $evenement->id) }}" class="p-8 space-y-6">
        @csrf
        @method('PUT')

        <!-- Numero / Libellé de l'événement -->
        <div>
            <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Nom / Libellé de l'événement</label>
            <input type="text" name="numeroevent" value="{{ old('numeroevent', $evenement->numeroevent) }}" required placeholder="ex: Magal Touba 2026, Travaux Daara..." 
                   class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none transition-all">
            @error('numeroevent') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Objectif & Cotisation p.m. -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Objectif (FCFA)</label>
                <input type="number" name="objectifmontant" value="{{ old('objectifmontant', (int)$evenement->objectifmontant) }}" required min="0" placeholder="ex: 1500000" 
                       class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none transition-all">
                @error('objectifmontant') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Cotisation p.m. (FCFA)</label>
                <input type="number" name="cotisations" value="{{ old('cotisations', (int)$evenement->cotisations) }}" required min="0" placeholder="ex: 5000" 
                       class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none transition-all">
                @error('cotisations') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Dates de Début & Clôture -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Date de début</label>
                <input type="date" name="datedebut" value="{{ old('datedebut', $evenement->datedebut) }}" required 
                       class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none transition-all">
                @error('datedebut') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Date de clôture</label>
                <input type="date" name="datecloture" value="{{ old('datecloture', $evenement->datecloture) }}" required 
                       class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none transition-all">
                @error('datecloture') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Statut -->
        <div>
            <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Statut de l'événement</label>
            <select name="statut" class="w-full px-4 py-3 bg-cedar-50 border border-cedar-200 rounded-xl text-sm font-bold text-cedar-900 focus:bg-white focus:ring-2 focus:ring-cedar-900 outline-none cursor-pointer transition-all">
                <option value="planifie" {{ old('statut', trim($evenement->statut)) === 'planifie' ? 'selected' : '' }}>Planifié</option>
                <option value="En_cours" {{ old('statut', trim($evenement->statut)) === 'En_cours' ? 'selected' : '' }}>En cours</option>
                <option value="termine" {{ old('statut', trim($evenement->statut)) === 'termine' ? 'selected' : '' }}>Terminé</option>
            </select>
            @error('statut') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4 border-t border-cedar-100 flex justify-end">
            <button type="submit" class="px-8 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
