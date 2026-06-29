<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cellule;
use App\Models\User;
use App\Models\Evenement;
use App\Models\Cotisation;
use Illuminate\Support\Facades\DB;
        } elseif ($user->role === 'responsble' || $user->role === 'responsable') {
            $cellule = Cellule::find($user->cellule_id);
            $totalMembres = User::where('cellule_id', $user->cellule_id)->count();
            
            $evenementsActifs = Evenement::where('communaute_id', $user->communaute_id)->count();
                
            $membreIds = User::where('cellule_id', $user->cellule_id)->pluck('id');
            $dernieresCotisations = Cotisation::whereIn('membre_id', $membreIds)
                ->with('users')
                ->latest()
                ->take(5)
                ->get();
                
            $totalCotise = Cotisation::whereIn('membre_id', $membreIds)->sum('montantcotise');

            return view('Dashboard.dashboardresponsable', compact(
                'cellule',
                'totalMembres',
                'evenementsActifs',
                'dernieresCotisations',
                'totalCotise'
            ));
        } else {
   
            $evenementsCommunaute = Evenement::with('participationsRelation')
                ->where('communaute_id', $user->communaute_id)
                ->whereNull('cellule_id')
                ->orderBy('datedebut', 'asc')
                ->get();

            $evenementsSection = Evenement::with('participationsRelation')
                ->where('cellule_id', $user->cellule_id)
                ->orderBy('datedebut', 'asc')
                ->get();

            $evenementsActifs = Evenement::with('participationsRelation')
                ->where('communaute_id', $user->communaute_id)
                ->where(function($query) use ($user) {
                    $query->whereNull('cellule_id')
                          ->orWhere('cellule_id', $user->cellule_id);
                })
                ->where('statut', '!=', 'termine')
                ->orderBy('datedebut', 'asc')
                ->get();
            $cotisations = Cotisation::where('membre_id', $user->id)
                ->with('evenement')
                ->orderBy('created_at', 'desc')
                ->get();
            $dernieresCotisations = $cotisations->take(5);
            return view('Dashboard.dashboardmembre', compact(
                'evenementsCommunaute', 
                'evenementsSection', 
                'evenementsActifs', 
                'cotisations', 
                'dernieresCotisations'
            ));
        }
    }
}