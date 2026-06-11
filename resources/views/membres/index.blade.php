@extends('layouts.app')

@section('content')
<!-- html2canvas CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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

    <!-- Buttons côte à côte -->
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <!-- Button 1: manual add -->
        <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-xs font-black shadow-lg shadow-cedar-950/10 transition-all w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter manuellement
        </button>
        <!-- Button 2: invite link -->
        <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-white hover:bg-cedar-50 text-cedar-950 border border-cedar-200 rounded-2xl text-xs font-black shadow-sm transition-all w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cedar-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 10.742l5.136-2.568m-5.136 5.652l5.136 2.568M19 12a3 3 0 11-6 0 3 3 0 016 0zm-11 5a3 3 0 11-6 0 3 3 0 016 0zm0-10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Inviter par lien
        </button>
    </div>
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cedar-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" placeholder="Rechercher..." class="bg-transparent outline-none border-none w-full text-sm text-cedar-900 placeholder:text-cedar-400 ml-3">
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
                            <!-- Card generator -->
                            <button onclick="openCardModal({{ json_encode($user) }}, '{{ $user->cellule->nomsection ?? 'Sans Section' }}', '{{ $user->communaute->nom ?? $user->cellule->communaute->nom ?? 'Ma Communauté' }}')" class="w-9 h-9 rounded-xl bg-purple-50 hover:bg-purple-100 flex items-center justify-center transition-all shadow-sm" title="Carte de membre">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2v-5a2 2 0 00-2-2h-5l-4-4z" />
                                </svg>
                            </button>

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
                
                <!-- NIN (Identité) -->
                <div id="modal-nin-container" class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">NIN (Numéro d'Identité National)</label>
                    <input type="text" name="nin" id="modal_nin" class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>

                <!-- Date de naissance -->
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Date de Naissance</label>
                    <input type="date" name="date_naissance" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>

                <!-- Genre -->
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Genre</label>
                    <select name="genre" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                </div>

                <!-- Statut Matrimonial -->
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Statut Matrimonial</label>
                    <select name="situation_matrimoniale" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="Célibataire">Célibataire</option>
                        <option value="Marié(e)">Marié(e)</option>
                        <option value="Divorcé(e)">Divorcé(e)</option>
                        <option value="Veuf/Veuve">Veuf/Veuve</option>
                    </select>
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
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Rôle</label>
                    <select name="role" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="membre">Membre</option>
                        <option value="responsable">Responsable</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Prénom du Père</label>
                    <input type="text" name="nom_pere" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Prénom/Nom de la Mère</label>
                    <input type="text" name="nom_mere" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Catégorie d'Âge</label>
                    <select id="modal_type_membre" name="type_membre" required class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="adulte">Adulte</option>
                        <option value="adolescent">Adolescent</option>
                    </select>
                </div>

                <!-- SECTION : ADULTE -->
                <div id="modal-fields-adulte" class="sm:col-span-2 bg-gray-50 border border-gray-150 rounded-xl p-3 grid grid-cols-1 sm:grid-cols-2 gap-3" style="display: none;">
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Profession</label>
                        <input type="text" name="profession" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                </div>

                <!-- SECTION : ADOLESCENT -->
                <div id="modal-fields-adolescent" class="sm:col-span-2 bg-gray-50 border border-gray-150 rounded-xl p-3 grid grid-cols-1 sm:grid-cols-2 gap-3" style="display: none;">
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Formation / Études</label>
                        <input type="text" name="niveau_etudes" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-700 uppercase mb-1">Numéro du Parent / Tuteur</label>
                        <input type="text" name="parent_tuteur_telephone" placeholder="77 000 00 00" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-950 outline-none focus:ring-2 focus:ring-cedar-300">
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

<!-- Modal Invitation par lien -->
<div id="inviteModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md border border-cedar-100 overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-cedar-100 flex justify-between items-center bg-cedar-50/50">
            <div>
                <h3 class="text-lg font-black text-cedar-950">Lien d'inscription</h3>
                <p class="text-[11px] text-cedar-500 font-medium">Partager le lien d'auto-inscription</p>
            </div>
            <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white border border-cedar-200 text-cedar-400 hover:text-cedar-900 hover:bg-cedar-50 flex items-center justify-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4">
            @if(Auth::user()->role === 'admin')
                <div>
                    <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Sélectionner la section / cellule</label>
                    <select id="invite_cellule_select" onchange="updateInviteLink()" class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 cursor-pointer">
                        <option value="">Choisissez une section</option>
                        @foreach($cellules as $cell)
                            <option value="{{ $cell->id }}">{{ $cell->nomsection }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <!-- Responsable (a un seul cellule) -->
                <div class="hidden">
                    <select id="invite_cellule_select">
                        <option value="{{ $cellules->first()->id ?? '' }}" selected></option>
                    </select>
                </div>
                <div class="bg-cedar-50 border border-cedar-100 rounded-2xl p-4 text-xs font-semibold text-cedar-850">
                    Lien d'auto-inscription pour votre section : <span class="font-black text-cedar-950">{{ $cellules->first()->nomsection ?? 'Ma Section' }}</span>
                </div>
            @endif

            <div id="invite_link_container" class="{{ Auth::user()->role === 'admin' ? 'hidden' : '' }} space-y-2">
                <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1">Lien à copier</label>
                <div class="flex gap-2">
                    <input type="text" readonly id="invite_link_input" class="w-full bg-cedar-50 border border-cedar-200 rounded-lg px-3 py-2 text-xs font-bold text-cedar-800 outline-none font-mono select-all">
                    <button onclick="copyInviteLink()" class="bg-cedar-900 hover:bg-cedar-950 text-white rounded-lg px-4 py-2 text-xs font-black transition-all whitespace-nowrap">
                        Copier
                    </button>
                </div>
                <p class="text-[10px] text-cedar-400 font-medium">Les personnes qui utiliseront ce lien pourront s'inscrire d'elles-mêmes dans cette section.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Carte de Membre -->
<div id="cardModal" class="fixed inset-0 bg-cedar-950/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-[550px] border border-cedar-100 overflow-hidden transform transition-all flex flex-col items-center p-6">
        
        <div class="w-full flex justify-between items-center mb-4 border-b border-cedar-50 pb-2">
            <h3 class="text-sm font-black text-cedar-950 uppercase tracking-wider">Carte de membre</h3>
            <button onclick="document.getElementById('cardModal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-cedar-50 text-cedar-400 hover:text-cedar-900 hover:bg-cedar-100 flex items-center justify-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Scrollable wrapper for mobile responsive safety -->
        <div class="w-full overflow-x-auto flex justify-center py-2 scrollbar-none">
            <!-- Le badge à dessiner (500px * 320px, horizontal) -->
            <div id="member-card-render" class="w-[500px] h-[320px] rounded-[1.5rem] relative overflow-hidden shadow-2xl border-2 border-[#8c6b53]/20 flex flex-row p-6 bg-[#f7f3e8] text-[#3c1f19] select-none flex-shrink-0">
                <!-- Arrière-plan décoratif subtil -->
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(217,119,6,0.04),transparent_50%)] pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(98,55,44,0.04),transparent_50%)] pointer-events-none"></div>

                <!-- Partie Gauche : Avatar et code-barres -->
                <div class="w-[140px] flex flex-col items-center justify-between border-r border-[#3c1f19]/10 pr-6 flex-shrink-0">
                    <!-- Avatar -->
                    <div class="w-24 h-24 rounded-2xl border-2 border-[#3c1f19]/25 p-1 bg-white shadow-md overflow-hidden flex items-center justify-center">
                        <img id="card_avatar" src="" alt="Avatar" class="w-full h-full rounded-xl object-cover">
                    </div>

                    <!-- Statut / Rôle -->
                    <div class="text-center w-full mt-2">
                        <span id="card_role" class="inline-block px-2.5 py-1 bg-[#3c1f19] text-[#f7f3e8] text-[9px] font-black rounded-full uppercase tracking-wider"></span>
                    </div>

                    <!-- Code-barres simulé -->
                    <div class="flex items-center justify-center gap-[1.5px] h-5 bg-white border border-[#3c1f19]/15 px-2 py-0.5 rounded w-full mt-2">
                        <div class="w-[2px] h-full bg-black"></div>
                        <div class="w-[1px] h-full bg-black"></div>
                        <div class="w-[3px] h-full bg-black"></div>
                        <div class="w-[1px] h-full bg-black"></div>
                        <div class="w-[2px] h-full bg-black"></div>
                        <div class="w-[4px] h-full bg-black"></div>
                        <div class="w-[1px] h-full bg-black"></div>
                        <div class="w-[2px] h-full bg-black"></div>
                        <div class="w-[3px] h-full bg-black"></div>
                        <div class="w-[1.5px] h-full bg-black"></div>
                    </div>
                </div>

                <!-- Partie Droite : Infos détaillées -->
                <div class="flex-1 flex flex-col justify-between pl-6">
                    <!-- Header -->
                    <div class="border-b border-[#3c1f19]/10 pb-2">
                        <div class="flex items-center justify-between">
                            <h4 id="card_communaute" class="text-xs font-black tracking-wider text-[#3c1f19] uppercase truncate max-w-[180px]"></h4>
                            <span class="text-[8px] font-black uppercase text-[#955039] tracking-widest bg-[#955039]/10 px-2 py-0.5 rounded-md">SUNUDAARA</span>
                        </div>
                        <p class="text-[9px] text-[#794133] uppercase font-bold tracking-widest mt-0.5 font-mono">Carte de membre</p>
                    </div>

                    <!-- Informations -->
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 my-auto py-1">
                        <div class="col-span-2">
                            <span class="text-[#794133] text-[8px] uppercase tracking-wider font-extrabold block">Prénom & Nom</span>
                            <span id="card_fullname" class="font-black text-[#3c1f19] text-sm uppercase truncate block"></span>
                        </div>

                        <div>
                            <span class="text-[#794133] text-[8px] uppercase tracking-wider font-extrabold block">Matricule</span>
                            <span id="card_matricule" class="font-black text-[#62372c] text-xs font-mono block"></span>
                        </div>

                        <div>
                            <span class="text-[#794133] text-[8px] uppercase tracking-wider font-extrabold block">Né(e) le</span>
                            <span id="card_birthdate" class="font-black text-[#3c1f19] text-xs block"></span>
                        </div>

                        <div>
                            <span class="text-[#794133] text-[8px] uppercase tracking-wider font-extrabold block">Cellule / Section</span>
                            <span id="card_section" class="font-black text-[#3c1f19] text-xs truncate block"></span>
                        </div>

                        <div>
                            <span class="text-[#794133] text-[8px] uppercase tracking-wider font-extrabold block">Membre Depuis</span>
                            <span id="card_date" class="font-black text-[#3c1f19] text-xs block"></span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-[#3c1f19]/10 pt-1.5 flex items-center justify-between text-[7px] text-[#794133] font-bold">
                        <span>Document officiel de la communauté</span>
                        <span class="text-[7px] font-mono tracking-tighter opacity-60">ID: SD-CARD-H2</span>
                    </div>
                </div>
            </div>
        </div>

        <button onclick="downloadCardImage()" class="mt-6 w-full py-3 bg-[#62372c] hover:bg-[#3c1f19] text-white text-xs font-black rounded-2xl shadow-xl shadow-cedar-950/10 transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Télécharger la carte (PNG)
        </button>
    </div>
</div>

<script>
    // Mapping des liens de cellules/sections pour les invitations
    const cellTokens = {
        @foreach($cellules as $cell)
            "{{ $cell->id }}": "{{ $cell->registration_token ? route('section.register', ['cellule_token' => $cell->registration_token]) : '#' }}",
        @endforeach
    };

    function updateInviteLink() {
        const select = document.getElementById('invite_cellule_select');
        const container = document.getElementById('invite_link_container');
        const input = document.getElementById('invite_link_input');

        if (select.value && cellTokens[select.value]) {
            input.value = cellTokens[select.value];
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            input.value = '';
        }
    }

    function copyInviteLink() {
        const input = document.getElementById('invite_link_input');
        if (input.value) {
            navigator.clipboard.writeText(input.value);
            alert('Lien copié dans le presse-papiers !');
        }
    }

    // Gestion globale de la carte
    let activeCardUser = null;

    function openCardModal(user, sectionName, communauteName) {
        activeCardUser = user;
        
        const fullName = (user.prenom || user.Prenom || '') + ' ' + (user.nom || user.Nom || user.name || '');
        const role = user.role === 'admin' ? 'Administrateur' : (user.role === 'responsable' ? 'Responsable' : 'Membre');
        const matricule = user.matricule || 'Non assigné';
        
        // Date formatée (depuis_le ou created_at)
        let creationDate = 'Récemment';
        if (user.created_at) {
            const dateObj = new Date(user.created_at);
            creationDate = dateObj.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        // Date de naissance
        let birthdate = 'Non renseignée';
        if (user.date_naissance) {
            const dateObj = new Date(user.date_naissance);
            birthdate = dateObj.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        // Mettre à jour les éléments du DOM de la carte
        document.getElementById('card_fullname').innerText = fullName;
        document.getElementById('card_role').innerText = role;
        document.getElementById('card_matricule').innerText = matricule;
        document.getElementById('card_section').innerText = sectionName;
        document.getElementById('card_communaute').innerText = communauteName || 'Ma Communauté';
        document.getElementById('card_birthdate').innerText = birthdate;
        document.getElementById('card_date').innerText = creationDate;

        // Générer l'avatar des initiales via l'API UI-Avatars
        // Fond beige (#f5ebdf), écriture marron foncé (#3c1f19)
        const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(fullName)}&background=f5ebdf&color=3c1f19&bold=true&size=128`;
        document.getElementById('card_avatar').src = avatarUrl;

        // Ouvrir la modal
        document.getElementById('cardModal').classList.remove('hidden');
    }

    function downloadCardImage() {
        if (!activeCardUser) return;
        const cardElement = document.getElementById('member-card-render');
        const matricule = activeCardUser.matricule || 'membre';
        
        html2canvas(cardElement, {
            scale: 2, // Haute résolution
            useCORS: true, // Nécessaire pour charger l'image ui-avatars externe
            backgroundColor: null
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = `carte_membre_${matricule}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le lien pour responsable
        const select = document.getElementById('invite_cellule_select');
        if (select && select.value) {
            updateInviteLink();
        }

        // Bascule des formulaires Adulte / Adolescent dans la création
        const typeSelect = document.getElementById('modal_type_membre');
        const fieldsAdulte = document.getElementById('modal-fields-adulte');
        const fieldsAdolescent = document.getElementById('modal-fields-adolescent');
        const ninContainer = document.getElementById('modal-nin-container');
        const ninInput = document.getElementById('modal_nin');

        function toggleFields() {
            const val = typeSelect.value;
            fieldsAdulte.style.display = 'none';
            fieldsAdolescent.style.display = 'none';

            fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = true);
            fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = true);

            if (val === 'adulte') {
                fieldsAdulte.style.display = 'grid';
                fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = false);
                
                ninContainer.style.display = 'block';
                ninInput.disabled = false;
                ninInput.required = true;
            } else if (val === 'adolescent') {
                fieldsAdolescent.style.display = 'grid';
                fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = false);
                
                ninContainer.style.display = 'none';
                ninInput.disabled = true;
                ninInput.required = false;
            }
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', toggleFields);
            toggleFields();
        }
    });
</script>

@endsection
