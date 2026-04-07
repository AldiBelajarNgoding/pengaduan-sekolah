<?php

use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('landing'); // Menampilkan resources/views/landing.blade.php
});

// Layout Dashboard umum (Jika ada)
Route::get('/dashboard', function () {
    return view('dashboard'); 
});

// Dashboard Admin
Route::get('/admin', function () {
    return view('admin.dashboard-admin'); // Menampilkan resources/views/admin/dashboard-admin.blade.php
});

// Dashboard Siswa
Route::get('/siswa', function () {
    return view('siswa.dashboard-siswa'); // Menampilkan resources/views/siswa/dashboard-siswa.blade.php
});

// (Kamu bisa tambahkan route halamannya secara manual kalau ada halaman lain misal form login/register)
// Route::get('/login', function () { return view('auth.login'); });
