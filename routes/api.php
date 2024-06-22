<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\V1\VoteController;
use App\Http\Controllers\v1\WebsiteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// routes for unauthenticated users
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('v1')
    ->group(static function() {

        // websites
        Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');
    });

    
// routes for authenticated users
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(static function() {

        // websites
        Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');

        // votes
        Route::post('/vote', [VoteController::class, 'store'])->name('votes.store');
        Route::post('/unvote', [VoteController::class, 'delete'])->name('votes.delete');
    });

// route for admin users
Route::middleware(['auth:sanctum', 'admin'])
    ->prefix('v1')
    ->group(static function() {

        // websites
        Route::delete('/websites/{website}', [WebsiteController::class, 'delete'])->name('websites.delete');
    });