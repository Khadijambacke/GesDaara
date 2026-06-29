<?php

namespace App\Http\Controllers;

use App\Models\Cellule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MembreController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'owner') {
            $membres = User::where('communaute_id', $user->communaute_id)->get();
            $cellules = Cellule::where('communaute_id', $user->communaute_id)->get();
        } else {
            $membres = User::where('cellule_id', $user->cellule_id)->get();
            $cellules = Cellule::where('id', $user->cellule_id)->get();
        }
        return view('membres.index', compact('membres', 'cellules'));
    }

    public function create()
    {
        return view('membres.create');
    }

    protected function getValidationRules(Request $request, $id = null)
    {
        $rules = [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email' . ($id ? ",{$id}" : ''),
            'adresse' => 'required|string|max:255',
            'indicatif' => 'required|string',
            'telephone' => 'required|string|max:255',
            'role' => 'required|string',
            'cellule_id' => 'required|exists:cellules,id',
            'type_membre' => 'required|in:adulte,adolescent',
            'genre' => 'required|in:homme,femme',
            'nom_pere' => 'required|string|max:255',
            'nom_mere' => 'required|string|max:255',
            'date_naissance' => 'required|date',
        ];

        if ($request->input('type_membre') === 'adulte') {
            $rules['nin'] = 'required|string|max:255';
            $rules['profession'] = 'required|string|max:255';
        } elseif ($request->input('type_membre') === 'adolescent') {
            $rules['etablissement_scolaire'] = 'required|string|max:255';
            $rules['niveau_etudes'] = 'required|string|max:255';
            $rules['parent_tuteur_nom'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function store(Request $request)
    {
        $rules = $this->getValidationRules($request);
        $validated = $request->validate($rules);

        $validerchamps = $validated;
        $validerchamps['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerchamps['communaute_id'] = Auth::user()->communaute_id;
        
        // Generate secure temporary password and invitation token
        $validerchamps['password'] = Hash::make(Str::random(16));
        $validerchamps['invitation_token'] = Str::random(60);
        $validerchamps['cgu_accepted'] = false;

        $membre = User::create($validerchamps);

        $invitationLink = route('invitation.accept', ['token' => $membre->invitation_token]);

        return redirect()->route('Toutmembre')
            ->with('success', 'Membre créé avec succès.')
            ->with('invitation_link', $invitationLink);
    }

    public function edit($id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        $cellules = Cellule::where('communaute_id', Auth::user()->communaute_id)->get();
        return view('membres.edit', compact('membre', 'cellules'));
    }
    public function update(Request $request, $id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        
        $rules = $this->getValidationRules($request, $id);
        $validated = $request->validate($rules);

        $validerinfos = $validated;
        $validerinfos['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerinfos['communaute_id'] = Auth::user()->communaute_id;

        // Reset specific conditional fields to null depending on selected member type to keep data clean
        if ($request->input('type_membre') === 'adulte') {
            $validerinfos['etablissement_scolaire'] = null;
            $validerinfos['niveau_etudes'] = null;
            $validerinfos['parent_tuteur_nom'] = null;
            $validerinfos['parent_tuteur_telephone'] = null;
        } elseif ($request->input('type_membre') === 'adolescent') {
            $validerinfos['nin'] = null;
            $validerinfos['profession'] = null;
            $validerinfos['parent_tuteur_telephone'] = null;
        }

        $membre->update($validerinfos);

        return redirect()->route('Toutmembre')->with('success', 'Membre modifié avec succès.');
    }

    public function destroy($id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        $membre->delete();
        return redirect()->route('Toutmembre')->with('success', 'Membre supprimé avec succès.');
    }

    public function responsableMembres()
    {
        $user = Auth::user();
        $membres = User::where('cellule_id', $user->cellule_id)->get();
        $cellules = Cellule::where('id', $user->cellule_id)->get();
        return view('membres.index', compact('membres', 'cellules'));
    }

    public function responsableStore(Request $request)
    {
        $user = Auth::user();
        $rules = $this->getValidationRules($request);
        $validated = $request->validate($rules);

        if ($validated['cellule_id'] != $user->cellule_id) {
            abort(403);
        }


        $validerchamps = $validated;
        $validerchamps['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerchamps['communaute_id'] = $user->communaute_id;
        // Generate secure temporary password and invitation token
        $validerchamps['password'] = Hash::make(Str::random(16));
        $validerchamps['invitation_token'] = Str::random(60);
        $validerchamps['cgu_accepted'] = false;

        $membre = User::create($validerchamps);

        $invitationLink = route('invitation.accept', ['token' => $membre->invitation_token]);

        return redirect()->route('responsable.membres')
            ->with('success', 'Membre créé avec succès dans votre section.')
            ->with('invitation_link', $invitationLink);
    }

    public function responsableEdit($id)
    {
        $user = Auth::user();
        $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($id);
        $cellules = Cellule::where('id', $user->cellule_id)->get();
        return view('membres.edit', compact('membre', 'cellules'));
    }

    public function responsableUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($id);
        
        $rules = $this->getValidationRules($request, $id);
        $validated = $request->validate($rules);

        if ($validated['cellule_id'] != $user->cellule_id) {
            abort(403);
        }

        $validerinfos = $validated;
        $validerinfos['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerinfos['communaute_id'] = $user->communaute_id;

        // Reset specific conditional fields to null depending on selected member type to keep data clean
        if ($request->input('type_membre') === 'adulte') {
            $validerinfos['etablissement_scolaire'] = null;
            $validerinfos['niveau_etudes'] = null;
            $validerinfos['parent_tuteur_nom'] = null;
            $validerinfos['parent_tuteur_telephone'] = null;
        } elseif ($request->input('type_membre') === 'adolescent') {
            $validerinfos['nin'] = null;
            $validerinfos['profession'] = null;
            $validerinfos['parent_tuteur_telephone'] = null;
        }

        $membre->update($validerinfos);

        return redirect()->route('responsable.membres')->with('success', 'Membre de votre section modifié avec succès.');
    }

    public function responsableDestroy($id)
    {   
        $user = Auth::user();
        $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($id);
        $membre->delete();

        return redirect()->route('responsable.membres')->with('success', 'Membre supprimé avec succès.');
    }

    public function exportCsv()
    {
        $user = Auth::user();
        if (in_array($user->role, ['admin', 'owner'])) {
            $membres = User::with('cellule')->where('communaute_id', $user->communaute_id)->get();
        } else {
            $membres = User::with('cellule')->where('cellule_id', $user->cellule_id)->get();
        }

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="membres_' . date('Y-m-d_H-i-s') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($membres) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            // CSV Headers
            fputcsv($file, [
                'Matricule',
                'Prénom',
                'Nom',
                'Email',
                'Téléphone',
                'Adresse',
                'Genre',
                'Rôle',
                'Section/Cellule',
                'Date d\'inscription'
            ], ';');

            foreach ($membres as $mbr) {
                fputcsv($file, [
                    $mbr->matricule,
                    $mbr->prenom ?? $mbr->Prenom,
                    $mbr->nom ?? $mbr->Nom,
                    $mbr->email,
                    $mbr->telephone,
                    $mbr->adresse,
                    ucfirst($mbr->genre ?? ''),
                    ucfirst($mbr->role ?? 'Membre'),
                    $mbr->cellule->nomsection ?? 'Sans section',
                    $mbr->created_at ? $mbr->created_at->format('d/m/Y') : ''
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}


