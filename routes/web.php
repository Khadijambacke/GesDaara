<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\CelluleController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\CotisationController;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

    ////////////adminpanel///
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard/membres', [MembreController::class, 'index'])->name('Toutmembre');
        Route::get('/dashboard/membres/create', [MembreController::class, 'create'])->name('creatememebre');
        Route::post('/dashboard/membres/store', [MembreController::class, 'store'])->name('storememebre');  
        Route::get('/dashboard/membres/edit/{id}', [MembreController::class, 'edit'])->name('editmemebre');
        Route::put('/dashboard/membres/update/{id}', [MembreController::class, 'update'])->name('updatememebre');
        Route::delete('/dashboard/membres/delete/{id}', [MembreController::class, 'destroy'])->name('deletememebre');  

        Route::get('/dashboard/cellules', [CelluleController::class, 'index'])->name('Toutcellule');
        Route::post('/dashboard/cellules/store', [CelluleController::class, 'store'])->name('storecellule');  
        Route::get('/dashboard/cellules/edit/{id}', [CelluleController::class, 'edit'])->name('editcellule');
        Route::put('/dashboard/cellules/update/{id}', [CelluleController::class, 'update'])->name('updatecellule');
        Route::delete('/dashboard/cellules/delete/{id}', [CelluleController::class, 'destroy'])->name('deletecellule');  
    });

    // Routes partagées pour admin et responsable
    Route::middleware(['auth', 'role:admin,responsable,responsble'])->group(function () {
        Route::get('/dashboard/evenements', [EvenementController::class, 'index'])->name('Toutevenement');
        Route::get('/dashboard/evenements/{id}', [EvenementController::class, 'show'])->name('showevent');
        Route::post('/dashboard/cotisations/store', [CotisationController::class, 'store'])->name('storecotisation');
        
        // Création, modification et suppression d'événements
        Route::post('/dashboard/evenements/store', [EvenementController::class, 'store'])->name('storeevent');  
        Route::get('/dashboard/evenements/edit/{id}', [EvenementController::class, 'edit'])->name('editevent');
        Route::put('/dashboard/evenements/update/{id}', [EvenementController::class, 'update'])->name('updateevent');
        Route::delete('/dashboard/evenements/delete/{id}', [EvenementController::class, 'destroy'])->name('deleteevent');
    });

    // Routes spécifiques pour le responsable de section (cellule)
    Route::middleware(['auth', 'role:responsable,responsble'])->group(function () {
        Route::get('/dashboard/responsable/membres', [MembreController::class, 'responsableMembres'])->name('responsable.membres');
        Route::post('/dashboard/responsable/membres/store', [MembreController::class, 'responsableStore'])->name('responsable.storemembre');
        Route::get('/dashboard/responsable/membres/edit/{id}', [MembreController::class, 'responsableEdit'])->name('responsable.editmembre');
        Route::put('/dashboard/responsable/membres/update/{id}', [MembreController::class, 'responsableUpdate'])->name('responsable.updatemembre');
        Route::delete('/dashboard/responsable/membres/delete/{id}', [MembreController::class, 'responsableDestroy'])->name('responsable.deletemembre');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
