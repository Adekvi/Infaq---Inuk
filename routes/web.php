<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Petugas\DatadiriController;
use App\Http\Controllers\Petugas\RolePetugasController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\Master\DataPetugas\PetugasController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KabupatenController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KecamatanController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KelurahanController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/store', [LoginController::class, 'store'])->name('login.store');
Route::get('login/admin', [LoginController::class, 'admin'])->name('login.admin');

// REGISTER
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register/store', [RegisterController::class, 'store'])->name('register.store');

Route::get('lupa-password', [LoginController::class, 'lupa'])->name('lupa.password');

// VERIFIKASI OTP
Route::get('/verify-otp/{user_id}', [RegisterController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp.submit');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('resend.otp');

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');

    // SUPERADMIN
    // MASTER
    // MASTER DATA KABUPATEN
    Route::get('superadmin/master-data/wilayah-kabupaten', [KabupatenController::class, 'index'])->name('superadmin.master.kabupaten');
    Route::get('superadmin/master-data/wilayah-kabupaten/tambah-data', [KabupatenController::class, 'tambahdata']);
    Route::post('superadmin/master-data/wilayah-kabupaten/tambah', [KabupatenController::class, 'tambah']);
    Route::get('superadmin/master-data/wilayah-kabupaten/edit-data/{id}', [KabupatenController::class, 'editdata']);
    Route::put('superadmin/master-data/wilayah-kabupaten/edit/{id}', [KabupatenController::class, 'edit']);
    Route::delete('superadmin/master-data/wilayah-kabupaten/hapus/{id}', [KabupatenController::class, 'hapus']);

    // MASTER DATA KECAMATAN
    Route::get('superadmin/master-data/wilayah-kecamatan', [KecamatanController::class, 'index'])->name('superadmin.master.kecamatan');
    Route::get('superadmin/master-data/wilayah-kecamatan/tambah-data', [KecamatanController::class, 'tambahdata']);
    Route::post('superadmin/master-data/wilayah-kecamatan/tambah', [KecamatanController::class, 'tambah']);
    Route::get('superadmin/master-data/wilayah-kecamatan/edit-data/{id}', [KecamatanController::class, 'editdata']);
    Route::put('superadmin/master-data/wilayah-kecamatan/edit/{id}', [KecamatanController::class, 'edit']);
    Route::delete('superadmin/master-data/wilayah-kecamatan/hapus/{id}', [KecamatanController::class, 'hapus']);

    // MASTER DATA KELUARAHAN
    Route::get('superadmin/master-data/wilayah-kelurahan', [KelurahanController::class, 'index'])->name('superadmin.master.kelurahan');
    Route::get('superadmin/master-data/wilayah-kelurahan/tambah-data', [KelurahanController::class, 'tambahdata']);
    Route::post('superadmin/master-data/wilayah-kelurahan/tambah', [KelurahanController::class, 'tambah']);
    Route::get('superadmin/master-data/wilayah-kelurahan/edit-data/{id}', [KelurahanController::class, 'editdata']);
    Route::put('superadmin/master-data/wilayah-kelurahan/edit/{id}', [KelurahanController::class, 'edit']);
    Route::delete('superadmin/master-data/wilayah-kelurahan/hapus/{id}', [KelurahanController::class, 'hapus']);

    // DATA PETUGAS
    Route::get('superadmin/master-data/petugas-dataPetugas', [PetugasController::class, 'index'])->name('superadmin.master.dataPetugas');
    Route::get('superadmin/master-data/petugas-dataPetugas/tambah-data', [PetugasController::class, 'tambahdata']);
    Route::post('superadmin/master-data/petugas-dataPetugas/tambah', [PetugasController::class, 'tambah']);
    Route::get('superadmin/master-data/petugas-dataPetugas/edit-data/{id}', [PetugasController::class, 'editdata']);
    Route::put('superadmin/master-data/petugas-dataPetugas/edit/{id}', [PetugasController::class, 'edit']);
    Route::delete('superadmin/master-data/petugas-dataPetugas/hapus/{id}', [PetugasController::class, 'hapus']);
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('petugas/dashboard', [RolePetugasController::class, 'index'])->name('petugas.dashboard');

    // IDENTITAS
    Route::get('petugas/identitas/create', [DatadiriController::class, 'create'])->name('petugas.identitas.create');
    Route::post('petugas/identitas/store', [DatadiriController::class, 'store'])->name('petugas.identitas.store');
    Route::post('petugas/get-kelurahan', [DatadiriController::class, 'getKelurahan'])->name('petugas.getKelurahan');
});
