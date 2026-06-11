<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
USE App\Models\Participation;

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
        
        if (in_array($user->role, ['responsable', 'responsble'])) {
         
            $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($validated['membre_id']);
        } else {
            
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

    public function membreStore(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'montantcotise' => 'required|numeric|min:1',
            'methodepayement' => 'required|in:cash,wave,orange_money,free_money,bank',
            'evenement_id' => 'required|exists:evenements,id',
        ]);

        $evenement = Evenement::where('communaute_id', $user->communaute_id)
            ->where(function($query) use ($user) {
                $query->whereNull('cellule_id')
                      ->orWhere('cellule_id', $user->cellule_id);
            })
            ->findOrFail($validated['evenement_id']);

        
        if ($evenement->statut === 'termine') {
            return redirect()->back()->with('error', 'Cet événement est clôturé, vous ne pouvez plus cotiser.');
        }

        DB::transaction(function () use ($validated, $evenement, $user) {
            $numerocontributions = 'COT-' . time() . '-' . rand(100, 999);

            Cotisation::create([
                'numerocontributions' => $numerocontributions,
                'montantcotise' => $validated['montantcotise'],
                'methodepayement' => $validated['methodepayement'],
                'datecotisations' => now()->toDateString(),
                'evenement_id' => $evenement->id,
                'membre_id' => $user->id,
            ]);
            
            $evenement->increment('montantotalparticipe', $validated['montantcotise']);
        });

        return redirect()->back()->with('success', 'Votre cotisation est de  ' . number_format($validated['montantcotise'], 0, ',', ' ') . ' FCFA a été enregistrée avec succès.');
    }

    public function storeParticipation(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'evenement_id' => 'required|exists:evenements,id',
            'montant_total_prevu' => 'required|numeric|min:1',
        ]);

        $evenement = Evenement::where('communaute_id', $user->communaute_id)
            ->where(function($query) use ($user) {
                $query->whereNull('cellule_id')
                      ->orWhere('cellule_id', $user->cellule_id);
            })
            ->findOrFail($validated['evenement_id']);

        if ($evenement->statut === 'termine') {
            return redirect()->back()->with('error', 'Cet événement est terminé. Vous ne pouvez plus vous y engager.');
        }

        $totalPaid = Cotisation::where('membre_id', $user->id)
            ->where('evenement_id', $evenement->id)
            ->sum('montantcotise');

        Participation::updateOrCreate(
            [
                'user_id' => $user->id,
                'evenement_id' => $evenement->id,
            ],
            [
                'montant_total_prevu' => $validated['montant_total_prevu'],
                'montant_paye' => $totalPaid,
            ]
        );

        return redirect()->back()->with('success', 'Votre engagement de participation de ' . number_format($validated['montant_total_prevu'], 0, ',', ' ') . ' FCFA a été enregistré.');
    }
}
