<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;

// Define the routes for authentication and resident management

// Route publik (login, register, dll)
Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('register', [AuthController::class, 'registerView']);
Route::post('register', [AuthController::class, 'register']);

// Route khusus admin
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware('role:admin,user');

    Route::get('/resident', [App\Http\Controllers\ResidentController::class, 'index'])->middleware('role:admin');
    Route::get('/resident/create', [App\Http\Controllers\ResidentController::class, 'create'])->middleware('role:admin');
    Route::post('/resident', [App\Http\Controllers\ResidentController::class, 'store'])->middleware('role:admin');
    Route::get('/resident/{id}/edit', [App\Http\Controllers\ResidentController::class, 'edit'])->middleware('role:admin');
    Route::put('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'update'])->middleware('role:admin');
    Route::delete('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'destroy'])->middleware('role:admin');
    Route::get('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'show'])->middleware('role:admin');

