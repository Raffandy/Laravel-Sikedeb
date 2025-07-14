<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\ProfilStandarController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route admin (bisa dibilang superadmin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/kelola-admin', [DataController::class, 'kelolaAdmin'])->name('data.kelolaAdmin');
    Route::post('/data/store-admin', [DataController::class, 'storeAdmin'])->name('data.storeAdmin');
    Route::get('/profil-standar', [ProfilStandarController::class, 'index'])->name('profil-standar.index');
    Route::put('/profil-standar/update', [ProfilStandarController::class, 'update'])->name('profil-standar.update');
});

// Route user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/kelola', [DataController::class, 'kelola'])->name('keloladata');
    Route::post('/data/store', [DataController::class, 'store'])->name('data.store');
});

// Sharing route admin dan user
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard/data', [DataController::class, 'index'])->name('data.get');
    Route::get('/data/{id}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/data/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id}', [DataController::class, 'destroy'])->name('data.destroy');
    Route::post('/nasabah/hitung/{id}', [PerhitunganController::class, 'store'])->name('nasabah.hitung');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
