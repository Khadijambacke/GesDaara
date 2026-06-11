<x-guest-layout>
    <div class="mb-4">
        <h2 class="text-xl font-bold text-cedar-950">Rejoindre la section : {{ $cellule->nomsection }}</h2>
        <p class="text-xs text-gray-600">Communauté : <strong>{{ $cellule->communaute->nom }}</strong></p>
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

    <div class="max-h-[65vh] overflow-y-auto pr-1">
        <form method="POST" action="{{ route('section.store', ['cellule_token' => $cellule->registration_token]) }}">
            @csrf

            <!-- Prénom -->
            <div class="mb-3">
                <label for="prenom" class="block text-xs font-semibold text-cedar-900 mb-1">Prénom</label>
                <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="block text-xs font-semibold text-cedar-900 mb-1">Nom</label>
                <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="block text-xs font-semibold text-cedar-900 mb-1">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Téléphone -->
            <div class="mb-3">
                <label for="telephone" class="block text-xs font-semibold text-cedar-900 mb-1">Numéro de Téléphone</label>
                <div class="flex gap-2">
                    <select name="indicatif" required class="px-2 py-1.5 border border-cedar-200 rounded-xl text-sm bg-white focus:border-cedar-500">
                        <option value="+221" {{ old('indicatif') == '+221' ? 'selected' : '' }}>+221 (SN)</option>
                        <option value="+33" {{ old('indicatif') == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                        <option value="+1" {{ old('indicatif') == '+1' ? 'selected' : '' }}>+1 (US)</option>
                        <option value="+225" {{ old('indicatif') == '+225' ? 'selected' : '' }}>+225 (CI)</option>
                    </select>
                    <input id="telephone" type="text" name="telephone" value="{{ old('telephone') }}" required class="flex-1 px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
                </div>
            </div>

            <!-- Adresse -->
            <div class="mb-3">
                <label for="adresse" class="block text-xs font-semibold text-cedar-900 mb-1">Adresse (Domicile)</label>
                <input id="adresse" type="text" name="adresse" value="{{ old('adresse') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- NIN (Identité) - Placé en haut, affiché/activé si Adulte -->
            <div id="nin-container" class="mb-3">
                <label for="nin" class="block text-xs font-semibold text-cedar-900 mb-1">Numéro d'Identité National (NIN)</label>
                <input id="nin" type="text" name="nin" value="{{ old('nin') }}" class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Date de naissance - Requis, placé en haut -->
            <div class="mb-3">
                <label for="date_naissance" class="block text-xs font-semibold text-cedar-900 mb-1">Date de Naissance</label>
                <input id="date_naissance" type="date" name="date_naissance" value="{{ old('date_naissance') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Genre -->
            <div class="mb-3">
                <label for="genre" class="block text-xs font-semibold text-cedar-900 mb-1">Genre</label>
                <select id="genre" name="genre" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm bg-white focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
                    <option value="homme" {{ old('genre') == 'homme' ? 'selected' : '' }}>Homme</option>
                    <option value="femme" {{ old('genre') == 'femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            <!-- Statut Matrimonial -->
            <div class="mb-3">
                <label for="situation_matrimoniale" class="block text-xs font-semibold text-cedar-900 mb-1">Statut Matrimonial</label>
                <select id="situation_matrimoniale" name="situation_matrimoniale" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm bg-white focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
                    <option value="Célibataire" {{ old('situation_matrimoniale') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié(e)" {{ old('situation_matrimoniale') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="Divorcé(e)" {{ old('situation_matrimoniale') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                    <option value="Veuf/Veuve" {{ old('situation_matrimoniale') == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>
                </select>
            </div>

            <!-- Filiation -->
            <div class="grid grid-cols-2 gap-2 mb-3">
                <div>
                    <label for="nom_pere" class="block text-xs font-semibold text-cedar-900 mb-1">Prénom du Père</label>
                    <input id="nom_pere" type="text" name="nom_pere" value="{{ old('nom_pere') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500">
                </div>
                <div>
                    <label for="nom_mere" class="block text-xs font-semibold text-cedar-900 mb-1">Prénom/Nom de la Mère</label>
                    <input id="nom_mere" type="text" name="nom_mere" value="{{ old('nom_mere') }}" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500">
                </div>
            </div>

            <!-- Catégorie de membre -->
            <div class="mb-4 p-3 bg-cedar-50/50 rounded-2xl border border-cedar-100">
                <label for="type_membre" class="block text-xs font-bold text-cedar-950 mb-1">Catégorie d'Âge</label>
                <select id="type_membre" name="type_membre" required class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm bg-white focus:border-cedar-500">
                    <option value="adulte" {{ old('type_membre') == 'adulte' ? 'selected' : '' }}>Adulte</option>
                    <option value="adolescent" {{ old('type_membre') == 'adolescent' ? 'selected' : '' }}>Adolescent</option>
                </select>
            </div>

            <!-- SECTION : ADULTE -->
            <div id="fields-adulte" class="mb-4 p-3 bg-gray-50 rounded-2xl border border-gray-200" style="display: none;">
                <h4 class="text-xs font-bold text-gray-700 mb-2">Informations Adulte</h4>
                <div>
                    <label for="profession" class="block text-xs font-semibold text-gray-750 mb-1">Profession</label>
                    <input id="profession" type="text" name="profession" value="{{ old('profession') }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-xl text-sm focus:border-cedar-500">
                </div>
            </div>

            <!-- SECTION : ADOLESCENT -->
            <div id="fields-adolescent" class="mb-4 p-3 bg-gray-50 rounded-2xl border border-gray-200" style="display: none;">
                <h4 class="text-xs font-bold text-gray-700 mb-2">Informations Adolescent</h4>
                <div class="mb-3">
                    <label for="niveau_etudes" class="block text-xs font-semibold text-gray-750 mb-1">Formation / Études</label>
                    <input id="niveau_etudes" type="text" name="niveau_etudes" value="{{ old('niveau_etudes') }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-xl text-sm focus:border-cedar-500">
                </div>
                <div>
                    <label for="parent_tuteur_telephone" class="block text-xs font-semibold text-gray-750 mb-1">Numéro du Parent / Tuteur</label>
                    <input id="parent_tuteur_telephone" type="text" name="parent_tuteur_telephone" value="{{ old('parent_tuteur_telephone') }}" placeholder="77 000 00 00" class="w-full px-3 py-1.5 border border-gray-300 rounded-xl text-sm focus:border-cedar-500">
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="mb-3">
                <label for="password" class="block text-xs font-semibold text-cedar-900 mb-1">Définir votre mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Confirmation Mot de passe -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-xs font-semibold text-cedar-900 mb-1">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-3 py-1.5 border border-cedar-200 rounded-xl text-sm focus:border-cedar-500 focus:ring focus:ring-cedar-200 focus:ring-opacity-50">
            </div>

            <!-- Charte Collective -->
            <div class="mb-4">
                <label class="block text-xs font-semibold text-cedar-900 mb-1">Charte Générale du Collectif</label>
                <div class="max-h-32 overflow-y-auto bg-gray-50 border border-cedar-100 p-3 rounded-xl text-xs text-gray-700 whitespace-pre-line leading-relaxed">
                    {{ $charte }}
                </div>
            </div>

            <!-- Acceptation Case -->
            <div class="block mb-4">
                <label for="cgu_accepted" class="inline-flex items-start">
                    <input id="cgu_accepted" type="checkbox" name="cgu_accepted" value="1" required class="rounded border-cedar-300 text-cedar-650 focus:ring-cedar-500 mt-1" {{ old('cgu_accepted') ? 'checked' : '' }}>
                    <span class="ms-2 text-xs text-gray-600">Je stipule que j'accepte les conditions générales du collectif et m'engage à les respecter.</span>
                </label>
            </div>

            <div class="mt-6 mb-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-cedar-900 hover:bg-cedar-850 text-white font-semibold rounded-xl shadow-lg shadow-cedar-950/20 transition duration-150 ease-in-out text-center text-sm">
                    S'inscrire & Rejoindre
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type_membre');
            const fieldsAdulte = document.getElementById('fields-adulte');
            const fieldsAdolescent = document.getElementById('fields-adolescent');
            const ninContainer = document.getElementById('nin-container');
            const ninInput = document.getElementById('nin');

            function toggleFields() {
                const val = typeSelect.value;
                // Hide all
                fieldsAdulte.style.display = 'none';
                fieldsAdolescent.style.display = 'none';

                // Disable all inputs inside hidden blocks to prevent validation errors on submission
                fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = true);
                fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = true);

                if (val === 'adulte') {
                    fieldsAdulte.style.display = 'block';
                    fieldsAdulte.querySelectorAll('input, select').forEach(el => el.disabled = false);
                    
                    // Show & enable NIN
                    ninContainer.style.display = 'block';
                    ninInput.disabled = false;
                    ninInput.required = true;
                } else if (val === 'adolescent') {
                    fieldsAdolescent.style.display = 'block';
                    fieldsAdolescent.querySelectorAll('input, select').forEach(el => el.disabled = false);
                    
                    // Hide & disable NIN
                    ninContainer.style.display = 'none';
                    ninInput.disabled = true;
                    ninInput.required = false;
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            toggleFields(); // Run on load
        });
    </script>
</x-guest-layout>
