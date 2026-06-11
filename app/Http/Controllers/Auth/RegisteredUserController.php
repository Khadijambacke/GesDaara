<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Communaute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'telephone' => 'required|string|max:255|unique:'.User::class.',telephone',
            'adresse' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'communaute_nom' => 'required|string|max:255',
            'communaute_description' => 'required|string|max:500',
        ]);

        $user = DB::transaction(function () use ($request) {
            // 1. Générer un numéro de communauté unique à 6 chiffres
            do {
                $numerocommu = mt_rand(100000, 999999);
            } while (Communaute::where('numerocommu', $numerocommu)->exists());

            // 2. Créer la communauté
            $communaute = Communaute::create([
                'numerocommu' => $numerocommu,
                'nom' => $request->communaute_nom,
                'description' => $request->communaute_description,
            ]);

            // 3. Créer l'utilisateur lié
            return User::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'role' => 'owner', // Le premier inscrit devient le propriétaire (owner)
                'communaute_id' => $communaute->id,
                'cellule_id' => null, // Pas encore de cellule
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Validé par défaut
            ]);
        });

        event(new Registered($user));

        // Auth::login($user);

        return redirect(route('login'));
    }
}
