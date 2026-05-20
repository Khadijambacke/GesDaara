<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-cedar-950">Bon retour !</h2>
        <p class="text-sm font-medium text-cedar-500 mt-2">Connectez-vous à votre espace GesDaara.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Mot de passe</label>
            <input type="password" name="password" required autocomplete="current-password"
                   class="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-cedar-300 text-cedar-900 shadow-sm focus:ring-cedar-900" name="remember">
                <span class="ml-2 text-xs font-bold text-cedar-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-cedar-600 hover:text-cedar-950 transition-colors" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                Se connecter
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-xs font-bold text-cedar-600">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-cedar-900 hover:text-cedar-950 underline decoration-2 underline-offset-4">S'inscrire</a>
            </p>
        </div>
    </form>
</x-guest-layout>
