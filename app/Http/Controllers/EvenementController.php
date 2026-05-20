<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $evenements = Evenement::where('communaute_id', $user->communaute_id)->get();
        
        if ($user->role === 'admin') {
            $membres = User::where('communaute_id', $user->communaute_id)
                ->where('id', '!=', $user->id)
                ->get();
        } else {
            $membres = User::where('cellule_id', $user->cellule_id)
                ->where('id', '!=', $user->id)
                ->get();
        }
        
        return view('evenements.index', compact('evenements', 'membres'));
    }

    public function store(Request $request)
    {
        // Seul l'administrateur ou le responsable peut créer des événements
        if (!in_array(Auth::user()->role, ['admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $validated = $request->validate([
            'numeroevent' => 'required|string|max:255',
            'objectifmontant' => 'required|numeric|min:0',
            'cotisations' => 'required|numeric|min:0',
            'datedebut' => 'required|date',
            'datecloture' => 'required|date|after_or_equal:datedebut',
            'statut' => 'required|in:planifie,En_cours,termine',
        ]);

        $data = $validated;
        $data['communaute_id'] = Auth::user()->communaute_id;
        $data['montantotalparticipe'] = 0.00;

        Evenement::create($data);

        return redirect()->route('Toutevenement')
            ->with('success', 'Événement créé avec succès');
    }

    public function show($id)
    {
        $user = Auth::user();
        $evenement = Evenement::where('communaute_id', $user->communaute_id)->findOrFail($id);
        
        // Charger les cotisations pour cet événement
        if ($user->role === 'admin') {
            // L'admin voit toutes les cotisations de sa communauté
            $cotisations = \App\Models\Cotisation::where('evenement_id', $evenement->id)
                ->with('users')
                ->latest()
                ->get();
        } else {
            // Le responsable voit uniquement les cotisations des membres de sa section
            $membreIds = User::where('cellule_id', $user->cellule_id)->pluck('id');
            $cotisations = \App\Models\Cotisation::where('evenement_id', $evenement->id)
                ->whereIn('membre_id', $membreIds)
                ->with('users')
                ->latest()
                ->get();
        }

        return view('evenements.show', compact('evenement', 'cotisations'));
    }

    public function edit($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $evenement = Evenement::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $evenement = Evenement::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);

        $validated = $request->validate([
            'numeroevent' => 'required|string|max:255',
            'objectifmontant' => 'required|numeric|min:0',
            'cotisations' => 'required|numeric|min:0',
            'datedebut' => 'required|date',
            'datecloture' => 'required|date|after_or_equal:datedebut',
            'statut' => 'required|in:En_cours ,planifie,termine',
        ]);

        $evenement->update($validated);

        return redirect()->route('Toutevenement')
            ->with('success', 'Événement mis à jour avec succès');
    }

    public function destroy($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $evenement = Evenement::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        
        // Supprimer d'abord les cotisations associées
        \App\Models\Cotisation::where('evenement_id', $evenement->id)->delete();
        
        $evenement->delete();

        return redirect()->route('Toutevenement')
            ->with('success', 'Événement supprimé avec succès');
    }
}
