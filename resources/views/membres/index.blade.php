@extends('layouts.app')

@section('content')
<!-- Top Section -->
@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
            @if(session('invitation_link'))
                <p class="text-xs text-emerald-600 mt-1 font-medium">Lien d'activation pour le membre (cliquez pour copier) :</p>
                <div class="mt-2 flex items-center gap-2">
                    <input type="text" readonly value="{{ session('invitation_link') }}" id="invitationLinkInput" class="bg-white border border-emerald-100 rounded-xl px-3 py-1.5 text-xs text-emerald-700 w-full sm:w-96 select-all outline-none font-mono">
                    <button onclick="navigator.clipboard.writeText('{{ session('invitation_link') }}'); alert('Lien copié dans le presse-papiers !');" class="bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-4 py-1.5 text-xs font-black transition-all">
                        Copier
                    </button>
                </div>
            @endif
        </div>
    </div>
@endif

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">

    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Gestion des Membres
        </h1>

        <p class="text-sm text-cedar-500 font-medium mt-2">
            Administration complète des membres du collectif.
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
        Ajouter un membre
    </button>
</div>


<!-- Table Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden min-h-[60vh] flex flex-col">

    <!-- Table Header -->
    <div class="p-8 border-b border-cedar-100 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-black text-cedar-950">
                Liste des Membres
            </h2>

            <p class="text-sm text-cedar-500 mt-1">
                Gestion et suivi des utilisateurs enregistrés.
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

                    <th class="px-4 py-4">Membre</th>
                    <th class="px-4 py-4">Mail</th>
                    <th class="px-4 py-4">Téléphone</th>
                    <th class="px-4 py-4">Rôle</th>
                    <th class="px-4 py-4 text-center">Actions</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-cedar-50">

                @foreach($membres as $user)
                <!-- Row -->
                <tr class="group hover:bg-cedar-50/50 transition-colors">

                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-cedar-100 flex items-center justify-center text-cedar-800 font-black text-xs">
                                {{ substr($user->prenom ?? $user->Prenom ?? $user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-cedar-950 whitespace-nowrap">
                                    {{ $user->prenom ?? $user->Prenom ?? '' }} {{ $user->nom ?? $user->Nom ?? $user->name ?? '' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-4">
                        <p class="text-xs md:text-sm text-cedar-950 whitespace-nowrap">
                            {{ $user->email }}
                        </p>
                    </td>

                    <td class="px-4 py-4">
                        <p class="text-sm text-cedar-950 whitespace-nowrap">
                            {{ $user->telephone ?? '-' }}
                        </p>
                    </td>

                    <!-- Role -->
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-3 py-1 bg-cedar-100 text-cedar-800 text-[10px] font-black rounded-xl border border-cedar-200 uppercase tracking-widest">
                            {{ $user->role ?? 'Membre' }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-2">

                            <!-- Edit -->
                            <a href="{{ Auth::user()->role === 'admin' ? route('editmemebre', $user->id) : route('responsable.editmembre', $user->id) }}" class="w-9 h-9 rounded-xl bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-all shadow-sm" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            <!-- Delete -->
                            <form action="{{ Auth::user()->role === 'admin' ? route('deletememebre', $user->id) : route('responsable.deletemembre', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
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
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<!-- Modal Création Membre -->
<div id="createModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto border border-cedar-100 transform transition-all">
        
        <div class="px-6 py-4 border-b border-cedar-100 flex justify-between items-center bg-cedar-50/50 sticky top-0 z-20 backdrop-blur-sm">
            <div>
                <h3 class="text-lg font-black text-cedar-950">Nouveau Membre</h3>
                <p class="text-[11px] text-cedar-500 font-medium">Informations de l'utilisateur</p>
            </div>
            <button onclick="document.getElementById('createModal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white border border-cedar-200 text-cedar-400 hover:text-cedar-900 hover:bg-cedar-50 flex items-center justify-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ Auth::user()->role === 'admin' ? route('storememebre') : route('responsable.storemembre') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Prénom</label>
                    <input type="text" name="prenom" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Nom</label>
                    <input type="text" name="nom" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Email</label>
                    <input type="email" name="email" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Adresse</label>
                    <input type="text" name="adresse" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Téléphone</label>
                    <div class="flex">
                        <select name="indicatif" class="bg-cedar-50 border border-cedar-200 border-r-0 rounded-l-lg pl-3 pr-7 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 z-10 cursor-pointer">
                            <option value="+221">+221</option>
                            <option value="+222">+222</option>
                            <option value="+223">+223</option>
                            <option value="+224">+224</option>
                            <option value="+225">+225</option>
                            <option value="+241">+241</option>
                            <option value="+33">+33</option>
                            <option value="+1">+1</option>
                        </select>
                        <input type="text" name="telephone" required placeholder="77 000 00 00" class="w-full bg-cedar-50 border border-cedar-200 rounded-r-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Cellule</label>
                    <select name="cellule_id" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="">Sélectionnez une cellule</option>
                        @foreach($cellules as $cellule)
                            <option value="{{ $cellule->id }}">{{ $cellule->nomsection }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Genre</label>
                    <select name="genre" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="homme">Homme / Garçon</option>
                        <option value="femme">Femme / Fille</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Rôle</label>
                    <select name="role" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="membre">Membre</option>
                        <option value="responsable">Responsable</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Prénom du Père</label>
                    <input type="text" name="nom_pere" class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Prénom/Nom de la Mère</label>
                    <input type="text" name="nom_mere" class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Catégorie d'Âge</label>
                    <select id="modal_type_membre" name="type_membre" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="adulte">Adulte</option>
                        <option value="adolescent">Adolescent</option>
                        <option value="enfant">Enfant</option>
                    </select>
                </div>

                <!-- SECTION : ADULTE -->
                <div id="modal-fields-adulte" class="sm:col-span-2 bg-gray-50 border border-gray-150 rounded-xl p-3 grid grid-cols-1 sm:grid-cols-2 gap-3" style="display: none;">
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">NIN (Identité)</label>
                        <input type="text" name="nin" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Profession</label>
                        <input type="text" name="profession" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                </div>

                <!-- SECTION : ADOLESCENT -->
                <div id="modal-fields-adolescent" class="sm:col-span-2 bg-gray-50 border border-gray-150 rounded-xl p-3 grid grid-cols-1 sm:grid-cols-2 gap-3" style="display: none;">
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Date de naissance</label>
                        <input type="date" name="date_naissance" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Établissement Scolaire</label>
                        <input type="text" name="etablissement_scolaire" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Niveau d'Études</label>
                        <input type="text" name="niveau_etudes" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Parent / Tuteur</label>
                        <input type="text" name="parent_tuteur_nom" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                </div>

                <!-- SECTION : ENFANT -->
                <div id="modal-fields-enfant" class="sm:col-span-2 bg-gray-50 border border-gray-150 rounded-xl p-3 grid grid-cols-1 sm:grid-cols-2 gap-3" style="display: none;">
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Date de naissance</label>
                        <input type="date" name="date_naissance" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Parent / Tuteur</label>
                        <input type="text" name="parent_tuteur_nom" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Téléphone Parent</label>
                        <input type="text" name="parent_tuteur_telephone" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Établissement (Opt)</label>
                        <input type="text" name="etablissement_scolaire" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-cedar-100 flex justify-end gap-3 sticky bottom-0 bg-white z-15">
                <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="px-4 py-2 bg-white text-cedar-900 border border-cedar-200 hover:bg-cedar-50 rounded-lg text-xs font-black transition-all">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-cedar-900 hover:bg-cedar-950 text-white rounded-lg text-xs font-black shadow-lg shadow-cedar-950/10 transition-all">
                    Créer le membre
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('modal_type_membre');
        const fieldsAdulte = document.getElementById('modal-fields-adulte');
        const fieldsAdolescent = document.getElementById('modal-fields-adolescent');
        const fieldsEnfant = document.getElementById('modal-fields-enfant');

        function toggleFields() {
            const val = typeSelect.value;
            // Hide all
            fieldsAdulte.style.display = 'none';
            fieldsAdolescent.style.display = 'none';
            fieldsEnfant.style.display = 'none';

            // Disable all inputs inside hidden blocks to prevent validation errors on submission
            fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = true);
            fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = true);
            fieldsEnfant.querySelectorAll('input, select').forEach(el => el.disabled = true);

            if (val === 'adulte') {
                fieldsAdulte.style.display = 'grid';
                fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = false);
            } else if (val === 'adolescent') {
                fieldsAdolescent.style.display = 'grid';
                fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = false);
            } else if (val === 'enfant') {
                fieldsEnfant.style.display = 'grid';
                fieldsEnfant.querySelectorAll('input, select').forEach(el => el.disabled = false);
            }
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', toggleFields);
            toggleFields();
        }
    });
</script>

@endsection
