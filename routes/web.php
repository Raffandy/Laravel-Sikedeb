<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PerhitunganController;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:user'])->name('dashboard');

Route::get('/dashboardadmin', function () {
    return Inertia::render('Admin/LandingAdminView', [
        'role' => auth()->user()->role, // Meneruskan role user ke Vue component
    ]);
})->middleware(['auth', 'verified',])->name('dashboard_admin');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    // Multi Auth Masuk Dashboard
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function(){
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});


// CRUD BARU
Route::get('/kelola', function () {
    return Inertia::render('KelolaData');
})->middleware(['auth', 'verified'])->name('keloladata');

Route::middleware(['auth'])->group(function () {
    Route::post('/data/store', [DataController::class, 'store'])->name('data.store');
    Route::get('/dashboard/data', [DataController::class, 'index'])->name('data.get');
    Route::get('/data/{id}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/data/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id}', [DataController::class, 'destroy'])->name('data.destroy');

    Route::post('/nasabah/hitung/{id}', [PerhitunganController::class, 'store'])->name('nasabah.hitung');

});


Route::get('/penilaian', function () {
    return Inertia::render('PenilaianView');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
