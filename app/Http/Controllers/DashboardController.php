<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cellule;
use App\Models\User;
use App\Models\Evenement;
use App\Models\Cotisation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('register');
        }
       
        if ($user->role === 'admin' || $user->role === 'owner') {
            $totalMembres = User::where('communaute_id', $user->communaute_id)
                ->where('role', 'membre')
                ->count();

            $totalCotise = Cotisation::whereHas('users', function ($q) use ($user) {
                $q->where('communaute_id', $user->communaute_id);
            })->sum('montantcotise');

            $evenementsActifs = Evenement::where('communaute_id', $user->communaute_id)
                ->where('statut', '!=', 'termine')
                ->count();

            $totalCellules = Cellule::where('communaute_id', $user->communaute_id)->count();

            $dernieresCotisations = Cotisation::whereHas('users', function ($q) use ($user) {
                $q->where('communaute_id', $user->communaute_id);
            })
            ->with(['users.cellule', 'evenement'])
            ->latest()
            ->take(5)
            ->get();

            $prochainEvenement = Evenement::where('communaute_id', $user->communaute_id)
                ->where('statut', '!=', 'termine')
                ->orderBy('datedebut', 'asc')
                ->first();

            $responsables = User::where('communaute_id', $user->communaute_id)
                ->whereIn('role', ['responsable', 'responsble'])
                ->with('cellule')
                ->take(5)
                ->get();

            $repartitionSections = DB::table('cotisations')
                ->join('users', 'cotisations.membre_id', '=', 'users.id')
                ->join('cellules', 'users.cellule_id', '=', 'cellules.id')
                ->where('users.communaute_id', $user->communaute_id)
                ->select('cellules.nomsection', DB::raw('SUM(cotisations.montantcotise) as total'))
                ->groupBy('cellules.id', 'cellules.nomsection')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            $progressionMensuelle = DB::table('cotisations')
                ->join('users', 'cotisations.membre_id', '=', 'users.id')
                ->where('users.communaute_id', $user->communaute_id)
                ->select(DB::raw('SUBSTRING(cotisations.datecotisations, 1, 7) as mois'), DB::raw('SUM(cotisations.montantcotise) as total'))
                ->groupBy('mois')
                ->orderBy('mois', 'asc')
                ->take(5)
                ->get();

            return view('Dashboard.dashboardadmin', compact(
                'totalMembres',
                'totalCotise',
                'evenementsActifs',
                'totalCellules',
                'dernieresCotisations',
                'prochainEvenement',
                'responsables',
                'repartitionSections',
                'progressionMensuelle'
            ));
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