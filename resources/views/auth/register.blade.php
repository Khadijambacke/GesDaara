<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-cedar-950">Créer un compte</h2>
        <p class="text-sm font-medium text-cedar-500 mt-2">Rejoignez la plateforme GesDaara.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Nom Complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Mot de passe</label>
            <input type="password" name="password" required autocomplete="new-password"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                S'inscrire
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-xs font-bold text-cedar-600">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" class="text-cedar-900 hover:text-cedar-950 underline decoration-2 underline-offset-4">Se connecter</a>
            </p>
        </div>
    </form>
</x-guest-layout>
