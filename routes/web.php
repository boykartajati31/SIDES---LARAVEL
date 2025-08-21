<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::resource('resident', App\Http\Controllers\ResidentController::class);
Route::get('/resident', [App\Http\Controllers\ResidentController::class, 'index'])->name('resident.index');
Route::get('/resident/create', [App\Http\Controllers\ResidentController::class, 'create'])->name('resident.create');
Route::post('/resident', [App\Http\Controllers\ResidentController::class, 'store'])->name('resident.store');
Route::get('/resident/{id}/edit', [App\Http\Controllers\ResidentController::class, 'edit'])->name('resident.edit');
Route::put('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'update'])->name('resident.update');
Route::delete('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'delete'])->name('resident.delete');

