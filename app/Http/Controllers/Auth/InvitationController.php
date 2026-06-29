<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cellule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Communaute;
    protected function getDefaultCharter()
    {
      return "Règlement Intérieur et Charte Générale du Collectif :\n\n"
             . "1. Respect mutuel : Tous les membres s'engagent à entretenir des relations basées sur le respect, la fraternité et l'entraide.\n"
             . "2. Solidarité active : Participer activement, selon les capacités de chacun, aux projets, événements et cotisations collectives.\n"
             . "3. Transparence et intégrité : Veiller à la bonne gestion des ressources et à l'exactitude des informations transmises.\n"
             . "4. Confidentialité : Protéger les données personnelles des autres membres et ne pas les divulguer à des tiers sans autorisation.\n"
             . "5. Respect des décisions collectives : Se conformer aux orientations prises par les instances de gouvernance de la communauté.";
    }

    
    public function accept($token)
    {
        $membre = User::where('invitation_token', $token)->first();

        if (!$membre) {
            return redirect()->route('login')->withErrors(['email' => "Ce lien d'activation n'est plus valide ou est expiré."]);
        }

        // récupération de la communauté du membre
        $communaute = $membre->cellule ? $membre->cellule->communaute : null;
        if (!$communaute && $membre->communaute_id) {
            $communaute = Communaute::find($membre->communaute_id);
        }
        $charte = ($communaute && !empty($communaute->charte)) ? $communaute->charte : $this->getDefaultCharter();

        return view('auth.accept-invitation', compact('membre', 'charte', 'token'));
    }

   
    public function storeAccept(Request $request, $token)
    {
        $membre = User::where('invitation_token', $token)->first();
        if (!$membre) {
            return redirect()->route('login')->withErrors(['email' => "Ce lien d'activation n'est plus valide ou est expiré."]);
        }
        $request->validate([
            'cgu_accepted' => 'required|accepted',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
       
        $membre->update([
            'password' => Hash::make($request->password),
            'cgu_accepted' => true,
            'cgu_accepted_at' => now(),
            'invitation_token' => null, 
        ]);

        Auth::login($membre);

        return redirect()->route('dashboard')->with('success', 'Votre compte a été activé avec succès. Bienvenue !');
    }

  
    public function registerSection($cellule_token)
    {
        $cellule = Cellule::where('registration_token', $cellule_token)->with('communaute')->first();

        if (!$cellule) {
            abort(404, "Cette section/cellule n'existe pas ou le lien est expiré.");
        }

        $charte = !empty($cellule->communaute->charte) ? $cellule->communaute->charte : $this->getDefaultCharter();

        return view('auth.register-section', compact('cellule', 'charte'));
    }

    
    public function storeRegisterSection(Request $request, $cellule_token)
    {
        $cellule = Cellule::where('registration_token', $cellule_token)->first();

        if (!$cellule) {
            abort(404, "Cette section/cellule n'existe pas.");
        }

=======
        // Base validation rules
>>>>>>> origin/master
        $rules = [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'adresse' => 'required|string|max:255',
<<<<<<< HEAD
            'indicatif' => 'required|string',
            'telephone' => 'required|string|max:255',
            'type_membre' => 'required|in:adulte,adolescent',
            'genre' => 'required|in:homme,femme',
            'nom_pere' => 'required|string|max:255',
            'nom_mere' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'cgu_accepted' => 'required|accepted',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Conditional validation rules based on member type
        if ($request->input('type_membre') === 'adulte') {
            $rules['nin'] = 'required|string|max:255';
            $rules['profession'] = 'required|string|max:255';
        } elseif ($request->input('type_membre') === 'adolescent') {
            $rules['etablissement_scolaire'] = 'required|string|max:255';
            $rules['niveau_etudes'] = 'required|string|max:255';
            $rules['parent_tuteur_nom'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $validerchamps = $validated;
        $validerchamps['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerchamps['communaute_id'] = $cellule->communaute_id;
        $validerchamps['cellule_id'] = $cellule->id;
        $validerchamps['role'] = 'membre'; 
        $validerchamps['password'] = Hash::make($request->password);
        $validerchamps['cgu_accepted'] = true;
        $validerchamps['cgu_accepted_at'] = now();
        $validerchamps['invitation_token'] = null; 

        $user = User::create($validerchamps);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Votre inscription a été validée avec succès. Bienvenue !');
    }
}
