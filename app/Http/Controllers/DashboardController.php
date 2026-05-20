<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('register');
        }
       
        if ($user->role === 'admin') {
            return view('Dashboard.dashboardadmin');
        } elseif ($user->role === 'responsble' || $user->role === 'responsable') {
            $cellule = \App\Models\Cellule::find($user->cellule_id);
            $totalMembres = \App\Models\User::where('cellule_id', $user->cellule_id)->count();
            
            $evenementsActifs = \App\Models\Evenement::where('communaute_id', $user->communaute_id)->count();
                
            $membreIds = \App\Models\User::where('cellule_id', $user->cellule_id)->pluck('id');
            $dernieresCotisations = \App\Models\Cotisation::whereIn('membre_id', $membreIds)
                ->with('users')
                ->latest()
                ->take(5)
                ->get();
                
            $totalCotise = \App\Models\Cotisation::whereIn('membre_id', $membreIds)->sum('montantcotise');

            return view('Dashboard.dashboardresponsable', compact(
                'cellule',
                'totalMembres',
                'evenementsActifs',
                'dernieresCotisations',
                'totalCotise'
            ));
        } else {
            return view('Dashboard.dashboardmembre');
        }
    }
}