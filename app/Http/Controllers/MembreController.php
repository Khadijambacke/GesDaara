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
            $membre = User::where('communaute_id', Auth::user()->communaute_id)
                          ->where('id', '!=', Auth::user()->id)
                          ->get();
            $cellules = Cellule::where('communaute_id', Auth::user()->communaute_id)->get();
            return view('membres.index', compact('membre', 'cellules'));
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
     
      $data = $validated;
      $data['telephone'] = $request->indicatif . ' ' . $request->telephone;
      $data['communaute_id'] = Auth::user()->communaute_id;
      
      User::create($data);
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
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        
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
        
      $data = $validated;
      $data['telephone'] = $request->indicatif . ' ' . $request->telephone;
      
      $membre->update($data);
      return redirect()->route('Toutmembre')->with('success', 'Membre modifié avec succès');
    }
    public function destroy($id)
    {
        $membre = User::where('communaute_id', Auth::user()->communaute_id)->findOrFail($id);
        $membre->delete();
        return redirect()->route('Toutmembre');
    }

}
