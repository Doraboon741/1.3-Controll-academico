<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    // Ambos roles entran a index; el controlador filtra qué ve cada uno
    Route::get('/academico', [AcademicController::class, 'index'])->name('academic.index');

    // Solo el Profesor puede crear, editar y eliminar
    Route::middleware('role:profesor')->group(function () {
        Route::get('/academico/crear', [AcademicController::class, 'create'])->name('academic.create');
        Route::post('/academico', [AcademicController::class, 'store'])->name('academic.store');
        Route::get('/academico/{record}/editar', [AcademicController::class, 'edit'])->name('academic.edit');
        Route::put('/academico/{record}', [AcademicController::class, 'update'])->name('academic.update');
        Route::delete('/academico/{record}', [AcademicController::class, 'destroy'])->name('academic.destroy');
    });
});