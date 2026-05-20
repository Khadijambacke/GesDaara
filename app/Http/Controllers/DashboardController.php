<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Si pas connecté
        if (!$user) {
            return redirect()->route('register');
        }
        // Vérification du rôle
        if ($user->role === 'admin') {
            return view('dashboard.dashboardadmin');
        } elseif ($user->role === 'responsble') {

            return view('responsable.dashboardresponsable');

        } else {
            return view('dashboard.dashboardmembre');
        }
    }
}