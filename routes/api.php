<?php 
use Illuminate\Support\Facades\Route; 
Route::prefix('v1')->group(function () { 
    Route::get('/ping', function () { 
return response()->json([ 
'success' => true, 
'message' => 'API V1 OK' 
        ]); 
    }); 
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

}); 