<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Siswa\AspirasiSiswaController;

Route::get('/', function () {
    return view('landing');
});

// Breeze
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') return redirect()->route('admin.dashboard');
        return redirect()->route('siswa.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Aspirasi
    Route::get('/aspirasi',         [AspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}',    [AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{id}',    [AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy'])->name('aspirasi.destroy');

    // Kategori
    Route::get('/kategori',                  [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori',                 [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit',  [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}',       [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}',    [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Siswa
    Route::get('/siswa',                 [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa',                [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit',    [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}',         [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}',      [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

// SISWA
Route::middleware(['auth','role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',        [DashboardController::class, 'siswa'])->name('dashboard');
    Route::get('/aspirasi',         [AspirasiSiswaController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/buat',    [AspirasiSiswaController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi',        [AspirasiSiswaController::class, 'store'])->name('aspirasi.store');
});

require __DIR__.'/auth.php';
