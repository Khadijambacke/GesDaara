<?php

namespace App\Http\Controllers;

use App\Models\Cellule;

class CotisationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'montantcotise' => 'required|numeric|min:0',
            'methodepayement' => 'required|in:cash,wave,orange_money,free_money,bank',
            'evenement_id' => 'required|exists:evenements,id',
            'membre_id' => 'nullable|exists:users,id',
            'matricule' => 'nullable|string',
        ]);

        if (!$request->filled('membre_id') && !$request->filled('matricule')) {
            return redirect()->back()->withErrors(['error' => 'Vous devez sélectionner un membre ou indiquer un matricule.']);
        }

        // Vérification de sécurité de la communauté et de la cellule
        $evenement = Evenement::where('communaute_id', $user->communaute_id)->findOrFail($validated['evenement_id']);
        
        if ($request->filled('matricule')) {
            $membre = User::where('matricule', trim($request->input('matricule')))
                ->where('communaute_id', $user->communaute_id)
                ->first();
            if (!$membre) {
                return redirect()->back()->withErrors(['matricule' => 'Aucun membre trouvé avec ce matricule dans votre communauté.']);
            }
            // Si c'est un responsable de section, on vérifie que le membre appartient bien à sa cellule
            if (in_array($user->role, ['responsable', 'responsble']) && $membre->cellule_id !== $user->cellule_id) {
                return redirect()->back()->withErrors(['matricule' => 'Ce membre n\'appartient pas à votre section.']);
            }
        } else {
            if (in_array($user->role, ['responsable', 'responsble'])) {
                $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($validated['membre_id']);
            } else {
                $membre = User::where('communaute_id', $user->communaute_id)->findOrFail($validated['membre_id']);
            }
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

    // -------------------------------------------------------
    // ADMIN — Liste des cotisations de toute la communauté
    // -------------------------------------------------------
    public function adminIndex(Request $request)
    {
        $user = Auth::user();

        $celluleId   = $request->input('cellule_id');
        $evenementId = $request->input('evenement_id');
        $search      = $request->input('search');

        $evenements = Evenement::where('communaute_id', $user->communaute_id)
            ->orderByDesc('datedebut')
            ->get();

        $cellules = Cellule::where('communaute_id', $user->communaute_id)
            ->orderBy('nomsection')
            ->get();

        $query = User::where('communaute_id', $user->communaute_id)
            ->where('role', 'membre')
            ->with(['compte', 'cellule']);

        if ($celluleId) {
            $query->where('cellule_id', $celluleId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('Prenom', 'like', "%{$search}%")
                  ->orWhere('Nom', 'like', "%{$search}%");
            });
        }

        $tousMembres = $query->get()->map(function ($membre) use ($evenementId) {
            // Solde réel = somme de TOUTES les cotisations du membre (tous événements)
            $membre->solde_reel = Cotisation::where('membre_id', $membre->id)->sum('montantcotise');

            // Montant cotisé selon le filtre événement
            $q = Cotisation::where('membre_id', $membre->id);
            if ($evenementId) $q->where('evenement_id', $evenementId);

            $membre->montant_cotise_filtre = $q->sum('montantcotise');
            $membre->nb_cotisations_filtre = $q->count();
            $membre->derniere_cotisation   = Cotisation::where('membre_id', $membre->id)
                ->when($evenementId, fn($q2) => $q2->where('evenement_id', $evenementId))
                ->orderByDesc('datecotisations')->first();
            return $membre;
        });

        // N'afficher dans le tableau que ceux qui ont cotisé
        $membres = $tousMembres->filter(
            fn($m) => $evenementId ? $m->montant_cotise_filtre > 0 : $m->solde_reel > 0
        )->values();

        $totalCotise          = $membres->sum('montant_cotise_filtre') ?: $membres->sum('solde_reel');
        $totalMembres         = $tousMembres->count();   // KPI : total réel
        $membresActifs        = $membres->count();        // KPI : ont cotisé
        $evenementSelectionne = $evenementId ? Evenement::find($evenementId) : null;

        return view('cotisations.admin', compact(
            'membres', 'evenements', 'cellules',
            'celluleId', 'evenementId', 'search',
            'totalCotise', 'totalMembres', 'membresActifs',
            'evenementSelectionne'
        ));
    }

    // -------------------------------------------------------
    // RESPONSABLE — Liste des cotisations de sa section
    // -------------------------------------------------------
    public function responsableIndex(Request $request)
    {
        $user = Auth::user();

        $evenementId = $request->input('evenement_id');
        $search      = $request->input('search');
        $dateDebut   = $request->input('date_debut');
        $dateFin     = $request->input('date_fin');

        $evenements = Evenement::where('communaute_id', $user->communaute_id)
            ->where(function ($q) use ($user) {
                $q->whereNull('cellule_id')->orWhere('cellule_id', $user->cellule_id);
            })
            ->orderByDesc('datedebut')
            ->get();

        $query = User::where('cellule_id', $user->cellule_id)
            ->where('role', 'membre')
            ->with(['compte', 'cellule']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('Prenom', 'like', "%{$search}%")
                  ->orWhere('Nom', 'like', "%{$search}%");
            });
        }

        $membres = $query->get()->map(function ($membre) use ($evenementId, $dateDebut, $dateFin) {
            $q = Cotisation::where('membre_id', $membre->id);
            if ($evenementId) $q->where('evenement_id', $evenementId);
            if ($dateDebut)   $q->where('datecotisations', '>=', $dateDebut);
            if ($dateFin)     $q->where('datecotisations', '<=', $dateFin);

            $membre->montant_cotise_filtre  = $q->sum('montantcotise');
            $membre->nb_cotisations_filtre  = $q->count();
            $membre->detail_cotisations     = $q->clone()->with('evenement')->orderByDesc('datecotisations')->get();
            return $membre;
        });

        $totalCotise          = $membres->sum('montant_cotise_filtre');
        $totalMembres         = $membres->count();
        $membresActifs        = $membres->filter(fn($m) => $m->nb_cotisations_filtre > 0)->count();
        $evenementSelectionne = $evenementId ? Evenement::find($evenementId) : null;

        return view('cotisations.responsable', compact(
            'membres', 'evenements',
            'evenementId', 'search', 'dateDebut', 'dateFin',
            'totalCotise', 'totalMembres', 'membresActifs',
            'evenementSelectionne'
        ));
    }

    public function exportCsv(Request $request)
    {
        $user = Auth::user();

        $celluleId   = $request->input('cellule_id');
        $evenementId = $request->input('evenement_id');
        $search      = $request->input('search');

        $query = Cotisation::query()
            ->join('users', 'cotisations.membre_id', '=', 'users.id')
            ->join('evenements', 'cotisations.evenement_id', '=', 'evenements.id')
            ->leftJoin('cellules', 'users.cellule_id', '=', 'cellules.id')
            ->where('users.communaute_id', $user->communaute_id)
            ->select([
                'cotisations.numerocontributions',
                'cotisations.montantcotise',
                'cotisations.methodepayement',
                'cotisations.datecotisations',
                'users.prenom as membre_prenom',
                'users.nom as membre_nom',
                'users.matricule as membre_matricule',
                'cellules.nomsection as section_nom',
                'evenements.numeroevent as evenement_nom'
            ]);

        // Security check for responsable role
        if (in_array($user->role, ['responsable', 'responsble'])) {
            $query->where('users.cellule_id', $user->cellule_id);
        } elseif ($celluleId) {
            $query->where('users.cellule_id', $celluleId);
        }

        if ($evenementId) {
            $query->where('cotisations.evenement_id', $evenementId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.prenom', 'like', "%{$search}%")
                  ->orWhere('users.nom', 'like', "%{$search}%")
                  ->orWhere('users.matricule', 'like', "%{$search}%");
            });
        }

        $cotisations = $query->orderByDesc('cotisations.datecotisations')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="cotisations_' . date('Y-m-d_H-i-s') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($cotisations) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($file, [
                'Référence',
                'Membre',
                'Matricule',
                'Section/Cellule',
                'Événement',
                'Montant (FCFA)',
                'Méthode de paiement',
                'Date'
            ], ';');

            foreach ($cotisations as $cotisation) {
                fputcsv($file, [
                    $cotisation->numerocontributions,
                    $cotisation->membre_prenom . ' ' . $cotisation->membre_nom,
                    $cotisation->membre_matricule,
                    $cotisation->section_nom ?? 'Sans section',
                    $cotisation->evenement_nom,
                    round($cotisation->montantcotise),
                    strtoupper(str_replace('_', ' ', $cotisation->methodepayement)),
                    $cotisation->datecotisations
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

