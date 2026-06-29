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
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\CommissionController;

use App\Http\Controllers\Auth\InvitationController;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
    // Routes d'événements accessibles par tout le monde
    Route::middleware(['auth', 'role:admin,owner,responsable,responsble,membre'])->group(function () {
        Route::get('/dashboard/evenements', [EvenementController::class, 'index'])->name('Toutevenement');
        Route::get('/dashboard/evenements/{id}', [EvenementController::class, 'show'])->name('showevent');
    });

    ////////////adminpanel///
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard/membres', [MembreController::class, 'index'])->name('Toutmembre');
        Route::get('/dashboard/cotisations', [CotisationController::class, 'adminIndex'])->name('admin.cotisations');
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
    Route::middleware(['auth', 'role:admin,owner,responsable,responsble'])->group(function () {
        Route::post('/dashboard/cotisations/store', [CotisationController::class, 'store'])->name('storecotisation');
        Route::get('/dashboard/cotisations/export', [CotisationController::class, 'exportCsv'])->name('cotisations.export');
        Route::get('/dashboard/membres/export', [MembreController::class, 'exportCsv'])->name('membres.export');


        // Création, modification et suppression d'événements
        Route::post('/dashboard/evenements/store', [EvenementController::class, 'store'])->name('storeevent');  
        Route::get('/dashboard/evenements/edit/{id}', [EvenementController::class, 'edit'])->name('editevent');
        Route::put('/dashboard/evenements/update/{id}', [EvenementController::class, 'update'])->name('updateevent');
        Route::delete('/dashboard/evenements/delete/{id}', [EvenementController::class, 'destroy'])->name('deleteevent');
    });

    // Routes spécifiques pour le responsable de section (cellule)
    Route::middleware(['auth', 'role:responsable,responsble'])->group(function () {
        Route::get('/dashboard/responsable/membres', [MembreController::class, 'responsableMembres'])->name('responsable.membres');
        Route::get('/dashboard/responsable/cotisations', [CotisationController::class, 'responsableIndex'])->name('responsable.cotisations');
        Route::post('/dashboard/responsable/membres/store', [MembreController::class, 'responsableStore'])->name('responsable.storemembre');
        Route::get('/dashboard/responsable/membres/edit/{id}', [MembreController::class, 'responsableEdit'])->name('responsable.editmembre');
        Route::put('/dashboard/responsable/membres/update/{id}', [MembreController::class, 'responsableUpdate'])->name('responsable.updatemembre');
        Route::delete('/dashboard/responsable/membres/delete/{id}', [MembreController::class, 'responsableDestroy'])->name('responsable.deletemembre');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/dashboard/membre/cotisations/store', [CotisationController::class, 'membreStore'])->name('membre.cotisations.store');
    Route::post('/dashboard/participations/store', [CotisationController::class, 'storeParticipation'])->name('membre.participations.store');

    // Routes pour les Dépenses
    Route::get('/dashboard/depenses', [DepenseController::class, 'index'])->name('admin.depenses.index');
    Route::post('/dashboard/depenses/store', [DepenseController::class, 'store'])->name('admin.depenses.store');
    Route::delete('/dashboard/depenses/delete/{id}', [DepenseController::class, 'destroy'])->name('admin.depenses.destroy');

    // Routes pour les Commissions
    Route::get('/dashboard/commissions', [CommissionController::class, 'index'])->name('admin.commissions.index');
    Route::post('/dashboard/commissions/store', [CommissionController::class, 'store'])->name('admin.commissions.store');
    Route::post('/dashboard/commissions/{id}/join', [CommissionController::class, 'join'])->name('admin.commissions.join');
    Route::post('/dashboard/commissions/{commissionId}/approve/{userId}', [CommissionController::class, 'approve'])->name('admin.commissions.approve');
    Route::post('/dashboard/commissions/{commissionId}/reject/{userId}', [CommissionController::class, 'reject'])->name('admin.commissions.reject');
    Route::delete('/dashboard/commissions/{id}/leave', [CommissionController::class, 'leave'])->name('admin.commissions.leave');
});

// Routes publiques pour l'activation d'invitation et acceptation de la charte (individuelle)
Route::get('/invitation/accepter/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');
Route::post('/invitation/accepter/{token}', [InvitationController::class, 'storeAccept'])->name('invitation.store');
Route::post('/compteUsers',[CompteController::class,'CompteBnacaire'])->name('compte.store');

// Routes publiques pour l'auto-inscription globale par section/cellule
Route::get('/rejoindre/section/{cellule_token}', [InvitationController::class, 'registerSection'])->name('section.register');
Route::post('/rejoindre/section/{cellule_token}', [InvitationController::class, 'storeRegisterSection'])->name('section.store');

require __DIR__.'/auth.php';
