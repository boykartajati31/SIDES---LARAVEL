<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;

// Define the routes for authentication and resident management
Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('register', [AuthController::class, 'registerView']);
Route::post('register', [AuthController::class, 'register']);

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});


Route::get('/resident', [App\Http\Controllers\ResidentController::class, 'index'])->name('resident.index');
Route::get('/resident/create', [App\Http\Controllers\ResidentController::class, 'create'])->name('resident.create');
Route::post('/resident', [App\Http\Controllers\ResidentController::class, 'store'])->name('resident.store');
Route::get('/resident/{id}/edit', [App\Http\Controllers\ResidentController::class, 'edit'])->name('resident.edit');
Route::put('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'update'])->name('resident.update');
Route::delete('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'destroy'])->name('resident.destroy');
Route::get('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'show'])->name('resident.show');


