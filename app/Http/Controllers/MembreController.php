<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cellule;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function index()
    {
        $membres = User::where('communaute_id', Auth::user()->communaute_id)->get();
        $cellules = Cellule::where('communaute_id', Auth::user()->communaute_id)->get();
        return view('membres.index', compact('membres', 'cellules'));
    }
    public function create()
    {
        return view('membres.create');
    }   
    public function store(Request $request)
    {
      $validated = $request->validate([
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'adresse' => 'required|string|max:255',
        'indicatif' => 'required|string',
        'telephone' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'role' => 'required|string',
        'cellule_id' => 'required|exists:cellules,id',
      ]);
      $validerchamps = $validated;
      $validerchamps['telephone'] = $request->indicatif . ' ' . $request->telephone;
      $validerchamps['communaute_id'] = Auth::user()->communaute_id;
      
      User::create($validerchamps);
      return redirect()->route('Toutmembre')
        ->with('success', 'membre  créé avec succès');
    }
    public function edit($id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        $cellules = Cellule::where('communaute_id', Auth::user()->communaute_id)->get();
        return view('membres.edit', compact('membre', 'cellules'));
    }
    public function update(Request $request, $id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)
        ->findOrFail($id);
        
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:100',
            ////$id pour ingnorer que c doit ete unique si toute fois l'utilisateur decide de changer les infos de son compte
            'email' => 'required|email|unique:users,email,'.$id,
            'adresse' => 'required|string|max:255',
            'indicatif' => 'required|string',
            'telephone' => 'required|string|max:255',
            'role' => 'required|string',
            'cellule_id' => 'required|exists:cellules,id',
        ]);
        ////concatenantion de l'indicatif et le numero
      $validerinfos = $validated;
      $validerinfos['telephone'] = $request->indicatif . ' ' . $request->telephone;
      $validerinfos['communaute_id'] = Auth::user()->communaute_id;
      $membre->update($validerinfos);
      return redirect()->route('Toutmembre')->with('success', 'Membre modifié avec succès');
    }
    public function destroy($id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        $membre->delete();
        return redirect()->route('Toutmembre');
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
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'adresse' => 'required|string|max:255',
            'indicatif' => 'required|string',
            'telephone' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'cellule_id' => 'required|exists:cellules,id',
        ]);

        if ($validated['cellule_id'] != $user->cellule_id) {
            abort(403);
        }

        $validerchamps = $validated;
        $validerchamps['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerchamps['communaute_id'] = $user->communaute_id;
        
        User::create($validerchamps);

        return redirect()->route('responsable.membres')
            ->with('success', 'Membre créé avec succès dans votre section');
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
        
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'adresse' => 'required|string|max:255',
            'indicatif' => 'required|string',
            'telephone' => 'required|string|max:255',
            'role' => 'required|string',
            'cellule_id' => 'required|exists:cellules,id',
        ]);

        if ($validated['cellule_id'] != $user->cellule_id) {
            abort(403);
        }

        $validerinfos = $validated;
        $validerinfos['telephone'] = $request->indicatif . ' ' . $request->telephone;
        $validerinfos['communaute_id'] = $user->communaute_id;

        $membre->update($validerinfos);

        return redirect()->route('responsable.membres')->with('success', 'Membre de votre section modifié avec succès');
    }

    public function responsableDestroy($id)
    {
        $user = Auth::user();
        $membre = User::where('cellule_id', $user->cellule_id)->findOrFail($id);
        $membre->delete();

        return redirect()->route('responsable.membres')->with('success', 'Membre supprimé avec succès');
    }

}
