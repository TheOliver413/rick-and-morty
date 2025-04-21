<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('characters.index');
});

// Rutas para personajes de la API
Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');
Route::get('/characters/{id}', [CharacterController::class, 'show'])->name('characters.detail');

// Rutas para personajes guardados en la base de datos
Route::get('/saved', [CharacterController::class, 'saved'])->name('characters.saved');
Route::get('/characters/{id}/edit', [CharacterController::class, 'edit'])->name('characters.edit');
Route::put('/characters/{id}', [CharacterController::class, 'update'])->name('characters.update');
Route::delete('/characters/{id}', [CharacterController::class, 'destroy'])->name('characters.destroy');
