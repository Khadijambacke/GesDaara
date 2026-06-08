<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CotisationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'montantcotise' => 'required|numeric|min:0',
            'methodepayement' => 'required|in:cash,wave,orange_money,free_money,bank',
            'evenement_id' => 'required|exists:evenements,id',
            'membre_id' => 'required|exists:users,id',
        ]);

        // Vérification de sécurité de la communauté et de la cellule
        $evenement = Evenement::where('communaute_id', $user->communaute_id)->findOrFail($validated['evenement_id']);
        
        if ($user->role === 'responsable') {
            // Un responsable ne peut cotiser que pour les membres de sa cellule
            $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($validated['membre_id']);
        } else {
            // Un administrateur peut cotiser pour n'importe quel membre de la communauté
            $membre = User::where('communaute_id', $user->communaute_id)->findOrFail($validated['membre_id']);
        }

        // Création de la cotisation et mise à jour du total de l'événement dans une transaction
        DB::transaction(function () use ($validated, $evenement, $membre) {
            $numerocontributions = 'COT-' . time() . '-' . rand(100, 999);

            Cotisation::create([
                'numerocontributions' => $numerocontributions,
                'montantcotise' => $validated['montantcotise'],
                'methodepayement' => $validated['methodepayement'],
                'datecotisations' => now()->toDateString(),
                'evenement_id' => $evenement->id,
                'membre_id' => $membre->id,
            ]);

            // Mettre à jour le montant total participé à l'événement
            $evenement->increment('montantotalparticipe', $validated['montantcotise']);
        });

        return redirect()->back()->with('success', 'Cotisation enregistrée avec succès');
    }
}
