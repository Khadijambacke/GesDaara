<?php

namespace App\Http\Controllers;

use App\Models\Cellule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CelluleController extends Controller
{
    public function index()
    {
        // Récupère toutes les cellules de la communauté de l'utilisateur connecté avec le nombre de membres associés
        $cellules = Cellule::where('communaute_id', Auth::user()->communaute_id)
            ->withCount('users')
            ->get();

        return view('cellules.index', compact('cellules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numerosection' => 'required|integer',
            'nomsection' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
        ]);

        $data = $validated;
        $data['communaute_id'] = Auth::user()->communaute_id;

        Cellule::create($data);

        return redirect()->route('Toutcellule')
            ->with('success', 'Cellule créée avec succès');
    }

    public function edit($id)
    {
        $cellule = Cellule::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        return view('cellules.edit', compact('cellule'));
    }

    public function update(Request $request, $id)
    {
        $cellule = Cellule::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);

        $validated = $request->validate([
            'numerosection' => 'required|integer',
            'nomsection' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
        ]);

        $cellule->update($validated);

        return redirect()->route('Toutcellule')
            ->with('success', 'Cellule modifiée avec succès');
    }

    public function destroy($id)
    {
        $cellule = Cellule::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        
        // Détacher les membres de cette cellule avant de la supprimer
        $cellule->users()->update(['cellule_id' => null]);
        
        $cellule->delete();

        return redirect()->route('Toutcellule')
            ->with('success', 'Cellule supprimée avec succès');
    }
}
