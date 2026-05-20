<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\CelluleController;
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

        // Routes Cellules
        Route::get('/dashboard/cellules', [CelluleController::class, 'index'])->name('Toutcellule');
        Route::post('/dashboard/cellules/store', [CelluleController::class, 'store'])->name('storecellule');  
        Route::get('/dashboard/cellules/edit/{id}', [CelluleController::class, 'edit'])->name('editcellule');
        Route::put('/dashboard/cellules/update/{id}', [CelluleController::class, 'update'])->name('updatecellule');
        Route::delete('/dashboard/cellules/delete/{id}', [CelluleController::class, 'destroy'])->name('deletecellule');  
    });

// Route::get('/', function () {
//     return view('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';
