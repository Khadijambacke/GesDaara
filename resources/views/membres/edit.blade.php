@extends('layouts.app')

@section('content')
<!-- Top Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
    <div>
        <h1 class="text-3xl font-black text-cedar-950 tracking-tight">
            Modifier le Membre
        </h1>
        <p class="text-sm text-cedar-500 font-medium mt-2">
            Mise à jour des informations de l'utilisateur.
        </p>
    </div>
    
    <a href="{{ Auth::user()->role === 'admin' ? route('Toutmembre') : route('responsable.membres') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-white text-cedar-900 border border-cedar-200 hover:bg-cedar-50 rounded-2xl text-sm font-black shadow-sm transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-[2.5rem] border border-cedar-100 shadow-xl shadow-cedar-950/5 overflow-hidden max-w-3xl">
    
    <div class="p-8 border-b border-cedar-100">
        <h2 class="text-xl font-black text-cedar-950">Informations Personnelles</h2>
        <p class="text-sm text-cedar-500 mt-1">Modifiez les champs ci-dessous pour mettre à jour le profil.</p>
    </div>

    <form action="{{ Auth::user()->role === 'admin' ? route('updatememebre', $membre->id) : route('responsable.updatemembre', $membre->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Prénom -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $membre->prenom ?? $membre->Prenom) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $membre->nom ?? $membre->Nom ?? $membre->name) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email', $membre->email) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Adresse -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse', $membre->adresse ?? $membre->adress) }}" required
                       class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                @error('adresse') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Téléphone -->
            @php
                $telephone = old('telephone', $membre->telephone);
                $indicatif = '+221';
                $numero = $telephone;
                
                if (str_starts_with((string)$telephone, '+')) {
                    $parts = explode(' ', $telephone, 2);
                    if (count($parts) > 1) {
                        $indicatif = $parts[0];
                        $numero = $parts[1];
                    }
                }
            @endphp
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Téléphone</label>
                <div class="flex">
                    <select name="indicatif" class="bg-cedar-50 border border-cedar-200 border-r-0 rounded-l-xl pl-3 pr-7 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 z-10 cursor-pointer">
                        <option value="+221" {{ $indicatif == '+221' ? 'selected' : '' }}>+221</option>
                        <option value="+222" {{ $indicatif == '+222' ? 'selected' : '' }}>+222</option>
                        <option value="+223" {{ $indicatif == '+223' ? 'selected' : '' }}>+223</option>
                        <option value="+224" {{ $indicatif == '+224' ? 'selected' : '' }}>+224</option>
                        <option value="+225" {{ $indicatif == '+225' ? 'selected' : '' }}>+225</option>
                        <option value="+241" {{ $indicatif == '+241' ? 'selected' : '' }}>+241</option>
                        <option value="+33" {{ $indicatif == '+33' ? 'selected' : '' }}>+33</option>
                        <option value="+1" {{ $indicatif == '+1' ? 'selected' : '' }}>+1</option>
                    </select>
                    <input type="text" name="telephone" value="{{ $numero }}" required placeholder="77 000 00 00"
                           class="w-full bg-cedar-50 border border-cedar-200 rounded-r-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
                </div>
                @error('telephone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Cellule -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Cellule</label>
                <select name="cellule_id" required class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all cursor-pointer">
                    <option value="">Sélectionnez une cellule</option>
                    @foreach($cellules as $cellule)
                        <option value="{{ $cellule->id }}" {{ old('cellule_id', $membre->cellule_id) == $cellule->id ? 'selected' : '' }}>
                            {{ $cellule->nomsection }}
                        </option>
                    @endforeach
                </select>
                @error('cellule_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="block text-xs font-black text-cedar-950 uppercase tracking-widest mb-2">Rôle d'accès</label>
                <select name="role" required class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all cursor-pointer">
                    <option value="membre" {{ old('role', $membre->role) == 'membre' ? 'selected' : '' }}>Membre</option>
                    <option value="admin" {{ old('role', $membre->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    <option value="responsable" {{ old('role', $membre->role) == 'responsable' ? 'selected' : '' }}>Responsable</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
