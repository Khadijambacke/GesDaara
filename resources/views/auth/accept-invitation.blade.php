<x-guest-layout>
    <div class="mb-4">
        <h2 class="text-xl font-bold text-cedar-950">Activation de votre compte</h2>
        <p class="text-sm text-gray-600">Bonjour <strong>{{ $membre->name }}</strong>, bienvenue dans la communauté ! Veuillez lire et accepter la charte avant d'activer votre compte.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('invitation.store', ['token' => $token]) }}">
        @csrf

        <!-- Charte Collective -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-cedar-900 mb-1">Charte Générale du Collectif</label>
            <div class="max-h-40 overflow-y-auto bg-gray-50 border border-cedar-100 p-3 rounded-xl text-xs text-gray-700 whitespace-pre-line leading-relaxed">
                {{ $charte }}
            </div>
        </div>

        <!-- Acceptation Case -->
        <div class="block mb-4">
            <label for="cgu_accepted" class="inline-flex items-start">
                <input id="cgu_accepted" type="checkbox" name="cgu_accepted" value="1" required class="rounded border-cedar-300 text-cedar-650 focus:ring-cedar-500 mt-1" {{ old('cgu_accepted') ? 'checked' : '' }}>
                <span class="ms-2 text-sm text-gray-600">Je stipule que j'accepte les conditions générales du collectif et m'engage à les respecter.</span>
            </label>
        </div>

        <!-- Mot de passe -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-cedar-900 mb-1">Définir votre mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
        </div>

        <!-- Confirmation Mot de passe -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-semibold text-cedar-900 mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-2 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full py-2.5 px-4 bg-cedar-900 hover:bg-cedar-850 text-white font-semibold rounded-xl shadow-lg shadow-cedar-950/20 transition duration-150 ease-in-out text-center text-sm">
                Accepter & Activer mon compte
            </button>
        </div>
    </form>
</x-guest-layout>
