<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Get expenses for the user's community
        $depenses = Depense::where('communaute_id', $user->communaute_id)
            ->with('evenement')
            ->orderBy('date_depense', 'desc')
            ->get();

        // Get active events to populate the dropdown
        $evenements = Evenement::where('communaute_id', $user->communaute_id)
            ->orderBy('datedebut', 'desc')
            ->get();

        return view('depenses.index', compact('depenses', 'evenements'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'owner', 'responsable', 'responsble'])) {
            abort(403);
        }

        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'evenement_id' => 'nullable|exists:evenements,id',
            'justificatif' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120', // Max 5MB
        ]);

        $data = $validated;
        $data['communaute_id'] = $user->communaute_id;

        if ($request->hasFile('justificatif')) {
            $path = $request->file('justificatif')->store('justificatifs', 'public');
            $data['justificatif'] = $path;
        }

        Depense::create($data);

        return redirect()->route('admin.depenses.index')
            ->with('success', 'Dépense enregistrée avec succès.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'owner'])) {
            abort(403);
        }

        $depense = Depense::where('communaute_id', $user->communaute_id)->findOrFail($id);
        $depense->delete();

        return redirect()->route('admin.depenses.index')
            ->with('success', 'Dépense supprimée avec succès.');
    }
}
