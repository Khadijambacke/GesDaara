<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\User;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $evenements = Evenement::where('communaute_id', $user->communaute_id)->get();
        
        if ($user->role === 'admin' || $user->role === 'owner') {
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
        if (!in_array(Auth::user()->role, ['owner', 'admin', 'responsable', 'responsble'])) {
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
        if (in_array(Auth::user()->role, ['responsable', 'responsble'])) {
            $data['cellule_id'] = Auth::user()->cellule_id;
        }
        $data['montantotalparticipe'] = 0.00;
        Evenement::create($data);
        return redirect()->route('Toutevenement')
            ->with('success', 'Événement créé avec succès');
    }

    public function show($id)
    {
        $user = Auth::user();
        $evenement = Evenement::where('communaute_id', $user->communaute_id)->findOrFail($id);

        // ── ADMIN ────────────────────────────────────────────────────────────
        if ($user->role === 'admin' || $user->role === 'owner') {

            // Cotisations par section : Section Dakar → 20 000 FCFA, Section Touba → 450 FCFA
            $cotisationsParSection = Cotisation::where('evenement_id', $evenement->id)
                ->join('users', 'cotisations.membre_id', '=', 'users.id')
                ->leftJoin('cellules', 'users.cellule_id', '=', 'cellules.id')
                ->selectRaw('
                    COALESCE(cellules.nomsection, "Sans section") as nom_section,
                    COUNT(cotisations.id) as nombre_transactions,
                    SUM(cotisations.montantcotise) as total_cotise
                ')
                ->groupBy('cellules.id', 'cellules.nomsection')
                ->orderByDesc('total_cotise')
                ->get();

            return view('evenements.show', compact('evenement', 'cotisationsParSection'));
        }

        // ── RESPONSABLE ──────────────────────────────────────────────────────
        if (in_array($user->role, ['responsable', 'responsble'])) {

            $membresSection = User::where('cellule_id', $user->cellule_id)
                ->with(['compte', 'participations' => function ($q) use ($evenement) {
                    $q->where('evenement_id', $evenement->id);
                }])
                ->get()
                ->map(function ($membre) use ($evenement) {
                    $membre->total_cotise_event = Cotisation::where('membre_id', $membre->id)
                        ->where('evenement_id', $evenement->id)
                        ->sum('montantcotise');
                    return $membre;
                });

            return view('evenements.show', compact('evenement', 'membresSection'));
        }

        // ── MEMBRE ───────────────────────────────────────────────────────────
        $mesCotisations = Cotisation::where('membre_id', $user->id)
            ->where('evenement_id', $evenement->id)
            ->latest()
            ->get();

        $maParticipation = \App\Models\Participation::where('user_id', $user->id)
            ->where('evenement_id', $evenement->id)
            ->first();

        return view('evenements.show', compact('evenement', 'mesCotisations', 'maParticipation'));
    }

    public function edit($id)
    {
        if (!in_array(Auth::user()->role, ['owner', 'admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $evenement = Evenement::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['owner', 'admin', 'responsable', 'responsble'])) {
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
        if (!in_array(Auth::user()->role, ['owner', 'admin', 'responsable', 'responsble'])) {
            abort(403);
        }

        $evenement = Evenement::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        // Supprimer d'abord les cotisations associées
        //si cotisations supprimer donc l'argent devrait etre rendue a gerer apres 
        Cotisation::where('evenement_id', $evenement->id)->delete();
        
        $evenement->delete();

        return redirect()->route('Toutevenement')
            ->with('success', 'Événement supprimé avec succès');
    }
}
