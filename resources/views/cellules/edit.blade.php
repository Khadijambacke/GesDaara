@extends('layouts.app')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Modifier la Cellule
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Mise à jour des informations de la section.
        </p>
    </div>
    
    <a href="{{ route('Toutcellule') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-white text-cedar-900 border border-cedar-200 hover:bg-cedar-50 rounded-2xl text-sm font-black shadow-sm transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden max-w-xl">
    
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">Informations de la section</h2>
        <p class="text-sm text-cedar-500 mt-1">Modifiez les champs ci-dessous pour mettre à jour la cellule.</p>
    </div>

    <form action="{{ route('updatecellule', $cellule->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            
            <!-- Numéro -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Numéro de la section</label>
                <input type="number" name="numerosection" value="{{ old('numerosection', $cellule->numerosection) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('numerosection') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Nom de la section</label>
                <input type="text" name="nomsection" value="{{ old('nomsection', $cellule->nomsection) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('nomsection') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Localité -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Localité</label>
                <input type="text" name="localite" value="{{ old('localite', $cellule->localite) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('localite') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-8 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
