@extends('layouts.app')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">

    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Gestion des Cellules
        </h1>

        <p class="text-sm text-cedar-500 font-medium mt-2">
            Administration complète des cellules de votre communauté.
        </p>
    </div>

    <!-- Add Button -->
    <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all w-full md:w-auto">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M12 4v16m8-8H4" />
        </svg>
        Ajouter une cellule
    </button>
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

<!-- Table Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden min-h-[60vh] flex flex-col">

    <!-- Table Header -->
    <div class="p-8 border-b border-cedar-100 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-black text-cedar-950">
                Liste des Cellules
            </h2>

            <p class="text-sm text-cedar-500 mt-1">
                Suivi et gestion des sections de la communauté.
            </p>
        </div>

        <!-- Search -->
        <div class="hidden md:flex items-center bg-cedar-50 rounded-2xl px-4 py-3 w-72">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 text-cedar-400"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>

            <input type="text"
                   placeholder="Rechercher..."
                   class="bg-transparent outline-none border-none w-full text-sm text-cedar-900 placeholder:text-cedar-400 ml-3">
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto w-full">

        <table class="w-full text-left">

            <thead class="bg-cedar-50 border-b border-cedar-100">

                <tr class="text-[11px] uppercase tracking-[0.2em] text-cedar-500 font-black">

                    <th class="px-6 py-5">Numéro</th>
                    <th class="px-6 py-5">Nom de la section</th>
                    <th class="px-6 py-5">Localité</th>
                    <th class="px-6 py-5">Membres rattachés</th>
                    <th class="px-6 py-5 text-center">Actions</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-cedar-50">

                @forelse($cellules as $cellule)
                <!-- Row -->
                <tr class="group hover:bg-cedar-50/50 transition-colors">

                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-3 py-1 bg-cedar-100 text-cedar-900 text-xs font-black rounded-lg">
                            #{{ $cellule->numerosection }}
                        </span>
                    </td>

                    <td class="px-6 py-5">
                        <p class="text-sm font-black text-cedar-950">
                            {{ $cellule->nomsection }}
                        </p>
                    </td>

                    <td class="px-6 py-5">
                        <p class="text-sm text-cedar-950">
                            {{ $cellule->localite }}
                        </p>
                    </td>

                    <!-- Members count -->
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-4 py-1.5 bg-cedar-50 text-cedar-800 text-xs font-black rounded-xl border border-cedar-100">
                            {{ $cellule->users_count ?? 0 }} membres
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">

                            <!-- Copy self-registration link -->
                            <button onclick="navigator.clipboard.writeText('{{ route('section.register', ['cellule_token' => $cellule->registration_token]) }}'); alert('Lien d\'auto-inscription pour {{ addslashes($cellule->nomsection) }} copié dans le presse-papiers !');" class="w-9 h-9 rounded-xl bg-emerald-50 hover:bg-emerald-100 flex items-center justify-center transition-all shadow-sm" title="Copier le lien d'auto-inscription">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </button>

                            <!-- Edit -->
                            <a href="{{ route('editcellule', $cellule->id) }}" class="w-9 h-9 rounded-xl bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-all shadow-sm" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('deletecellule', $cellule->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette cellule ? Les membres rattachés seront détachés.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-100 flex items-center justify-center transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-cedar-500 font-bold">
                        Aucune cellule enregistrée pour le moment.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

<!-- Modal Création Cellule -->
<div id="createModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden border border-cedar-100 transform transition-all">
        
        <div class="px-6 py-4 border-b border-cedar-100 flex justify-between items-center bg-cedar-50/50">
            <div>
                <h3 class="text-lg font-black text-cedar-950">Nouvelle Cellule</h3>
                <p class="text-[11px] text-cedar-500 font-medium">Informations de la section</p>
            </div>
            <button onclick="document.getElementById('createModal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white border border-cedar-200 text-cedar-400 hover:text-cedar-900 hover:bg-cedar-50 flex items-center justify-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('storecellule') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Numéro de la section</label>
                    <input type="number" name="numerosection" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Nom de la section</label>
                    <input type="text" name="nomsection" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Localité</label>
                    <input type="text" name="localite" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-cedar-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="px-4 py-2 bg-white text-cedar-900 border border-cedar-200 hover:bg-cedar-50 rounded-lg text-xs font-black transition-all">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-cedar-900 hover:bg-cedar-950 text-white rounded-lg text-xs font-black shadow-lg shadow-cedar-950/10 transition-all">
                    Créer la cellule
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
