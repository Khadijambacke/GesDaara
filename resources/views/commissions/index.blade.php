@extends('layouts.app')

@section('title', 'Commissions & Comités - SunuDaara')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Commissions & Comités de Travail
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Organisez la vie de votre Daara par commissions thématiques (Culture, Finance, Communication, etc.).
        </p>
    </div>

    @if(in_array(Auth::user()->role, ['admin', 'owner']))
    <!-- Create Commission Button -->
    <button onclick="document.getElementById('createCommissionModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all w-full md:w-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        Créer une commission
    </button>
    @endif
</div>

<!-- Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-bold flex items-center gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-sm font-bold flex items-center gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
    {{ session('error') }}
</div>
@endif

<!-- Manager Section: Pending Requests -->
@if($isManager && count($pendingRequests) > 0)
<div class="mb-10 bg-white rounded-[2rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 p-6 md:p-8">
    <h2 class="text-xl font-black text-cedar-950 tracking-tight mb-4 flex items-center gap-3">
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
        Demandes d'adhésion en attente
    </h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-cedar-100 text-[10px] font-black uppercase tracking-wider text-cedar-500">
                    <th class="py-3">Membre</th>
                    <th class="py-3">Commission demandée</th>
                    <th class="py-3">Date de demande</th>
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cedar-50 text-sm font-semibold text-cedar-950">
                @foreach($pendingRequests as $req)
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-cedar-100 flex items-center justify-center text-cedar-900 font-bold text-xs">
                                {{ strtoupper(substr($req['user']->prenom, 0, 1) . substr($req['user']->Nom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold">{{ $req['user']->prenom }} {{ $req['user']->Nom }}</p>
                                <p class="text-xs text-cedar-400">{{ $req['user']->cellule ? $req['user']->cellule->nomsection : 'Sans section' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1 bg-cedar-50 text-cedar-900 border border-cedar-200 text-xs font-black rounded-lg">
                            {{ $req['commission']->nom }}
                        </span>
                    </td>
                    <td class="py-4 text-cedar-500">
                        {{ \Carbon\Carbon::parse($req['user']->pivot->created_at)->format('d/m/Y') }}
                    </td>
                    <td class="py-4 text-right">
                        <div class="inline-flex gap-2">
                            <form action="{{ route('admin.commissions.approve', [$req['commission']->id, $req['user']->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-xs font-black shadow-lg shadow-green-600/10 transition-all">
                                    Approuver
                                </button>
                            </form>
                            <form action="{{ route('admin.commissions.reject', [$req['commission']->id, $req['user']->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-black transition-all">
                                    Rejeter
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
@endif

<!-- Commissions Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($commissions as $commission)
        @php
            $myMembership = $commission->users->firstWhere('id', Auth::user()->id);
            $approvedMembers = $commission->users->filter(function($u) {
                return $u->pivot->statut === 'approuve';
            });
        @endphp

        <div class="bg-white rounded-[2rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 p-6 md:p-8 flex flex-col justify-between hover:scale-[1.02] hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
            <div>
                <!-- Badge Status / Icon -->
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-cedar-50 rounded-2xl flex items-center justify-center text-cedar-900 group-hover:bg-cedar-900 group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    @if($myMembership)
                        @if($myMembership->pivot->statut === 'approuve')
                            <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                Membre officiel
                            </span>
                        @elseif($myMembership->pivot->statut === 'en_attente')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                Demande en attente
                            </span>
                        @elseif($myMembership->pivot->statut === 'rejete')
                            <span class="px-3 py-1 bg-red-50 text-red-700 border border-red-200 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                Demande rejetée
                            </span>
                        @endif
                    @endif
                </div>

                <!-- Commission Name -->
                <h3 class="text-xl font-black text-cedar-950 tracking-tight group-hover:text-cedar-900 transition-all">
                    {{ $commission->nom }}
                </h3>
                
                <!-- Description -->
                <p class="text-sm text-cedar-500 font-medium mt-3 line-clamp-3">
                    {{ $commission->description ?? 'Aucune description disponible pour ce comité.' }}
                </p>

                <!-- Members Count & Circle List -->
                <div class="mt-8 pt-6 border-t border-cedar-50">
                    <span class="text-[10px] font-black text-cedar-400 uppercase tracking-wider">Membres Actifs ({{ $approvedMembers->count() }})</span>
                    <div class="flex items-center gap-2 mt-3 overflow-hidden">
                        @forelse($approvedMembers->take(5) as $m)
                            <div class="w-8 h-8 rounded-full bg-cedar-100 border-2 border-white flex items-center justify-center text-[10px] font-black text-cedar-950 uppercase tracking-tighter" title="{{ $m->prenom }} {{ $m->Nom }}">
                                {{ substr($m->prenom, 0, 1) }}{{ substr($m->Nom, 0, 1) }}
                            </div>
                        @empty
                            <span class="text-xs text-cedar-400 font-medium">Aucun membre officiel pour le moment.</span>
                        @endforelse

                        @if($approvedMembers->count() > 5)
                            <div class="w-8 h-8 rounded-full bg-cedar-50 border-2 border-white flex items-center justify-center text-[10px] font-black text-cedar-500 uppercase tracking-tighter">
                                +{{ $approvedMembers->count() - 5 }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Join / Leave Action Button -->
            <div class="mt-8">
                @if($myMembership)
                    @if($myMembership->pivot->statut === 'approuve')
                        <form action="{{ route('admin.commissions.leave', $commission->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir quitter cette commission ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-black transition-all">
                                Quitter la commission
                            </button>
                        </form>
                    @elseif($myMembership->pivot->statut === 'rejete')
                        <form action="{{ route('admin.commissions.join', $commission->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3.5 bg-cedar-50 hover:bg-cedar-100 text-cedar-900 rounded-xl text-xs font-black transition-all">
                                Renvoyer une demande
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full py-3.5 bg-gray-50 border border-gray-200 text-gray-400 rounded-xl text-xs font-black cursor-not-allowed">
                            Demande en cours d'examen...
                        </button>
                    @endif
                @else
                    <form action="{{ route('admin.commissions.join', $commission->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-xs font-black shadow-lg shadow-cedar-950/10 transition-all">
                            Rejoindre la commission
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-[2rem] border border-cedar-100 shadow-xl p-12 text-center text-cedar-400 font-medium">
            Aucune commission créée pour le moment.
        </div>
    @endforelse
</div>

<!-- Modal: Create Commission -->
@if(in_array(Auth::user()->role, ['admin', 'owner']))
<div id="createCommissionModal" class="fixed inset-0 bg-cedar-950/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-[2rem] w-full max-w-lg border border-cedar-100 shadow-2xl p-8 relative">
        <button onclick="document.getElementById('createCommissionModal').classList.add('hidden')" class="absolute top-6 right-6 p-2 text-cedar-400 hover:text-cedar-950 rounded-xl hover:bg-cedar-50 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-2xl font-black text-cedar-950 tracking-tight mb-2">Créer une commission</h3>
        <p class="text-sm text-cedar-500 font-medium mb-6">Définissez un nouveau comité de travail pour la gestion des activités du Daara.</p>

        <form action="{{ route('admin.commissions.store') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Nom -->
            <div class="space-y-2">
                <label for="nom" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Nom de la Commission</label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Commission Culturelle, Commission Sociale..." required
                       class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all">
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-xs font-black uppercase text-cedar-950 tracking-wider">Description / Mission</label>
                <textarea name="description" id="description" rows="4" placeholder="Objectifs et responsabilités du comité..."
                          class="w-full px-5 py-4 bg-cedar-50/50 border border-cedar-100 rounded-2xl text-sm font-semibold text-cedar-950 focus:outline-none focus:border-cedar-300 focus:bg-white transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="document.getElementById('createCommissionModal').classList.add('hidden')"
                        class="w-full py-4 border border-cedar-200 text-cedar-600 hover:bg-cedar-50 rounded-2xl text-sm font-black transition-all">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-2xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                    Créer la commission
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
