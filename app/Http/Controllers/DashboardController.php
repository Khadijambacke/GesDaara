<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cellule;
use App\Models\User;
use App\Models\Evenement;
use App\Models\Cotisation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('register');
        }
       
        if ($user->role === 'admin' || $user->role === 'owner') {
            return view('Dashboard.dashboardadmin');
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
            // Member dashboard – provide recent events and member's cotisations
            $evenementsActifs = Evenement::where('communaute_id', $user->communaute_id)
                ->where('datedebut', '>=', now())
                ->orderBy('datedebut', 'asc')
                ->get();
            $cotisations = Cotisation::where('membre_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            // Alias for view consistency
            $dernieresCotisations = $cotisations;
            return view('Dashboard.dashboardmembre', compact('evenementsActifs', 'cotisations', 'dernieresCotisations'));
        }
    }
}