<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evenement;


class CompteController extends Controller
{
      ////recuperer les cotisations par membres
    public function index(){
        $user = Auth::user();
        $evenements = Evenement::where('communaute_id', $user->communaute_id)->get();
        return view('evenemnet.index', compact($user,$evenement));



    }
     ///creer une cotisations 
    public function create(){

        // if(!$user){
        //    return redirect('Auth.login')
        // }else{

        // }
        

    }
/////enregistrer une cotisations dans le compte
    public function store(){
        Cotisation::create([
            'numero' => $numerocontributions,
            'montantcotise' => $validated['montantcotise'],
            'montanttotal' => $validated['montanttotal'],
            'montantotalsas' =>$validated['montantotalsas'],
            'evenement_id' => $evenement->id,
            'membre_id' => $membre->id,
            'cotisations_id'=>$membre->id,
          d,
         ]);
         
        return redirect('montantcompte.store');
    }

}
