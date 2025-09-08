<?php

use App\Http\Controllers\AdminKabupaten\DashboardController as AdminKabupatenDashboardController;
use App\Http\Controllers\AdminKabupaten\Rekap\RekapController;
use App\Http\Controllers\AdminKabupaten\Setor\SetorController;
use App\Http\Controllers\AdminKecamatan\DashboardController as AdminKecamatanDashboardController;
use App\Http\Controllers\AdminKecamatan\Identitas\DataDiriController as IdentitasDataDiriController;
use App\Http\Controllers\AdminKecamatan\Pengiriman\SendController;
use App\Http\Controllers\AdminKecamatan\Pengiriman\TampilController;
use App\Http\Controllers\AdminKecamatan\Rekap\FileController;
use App\Http\Controllers\AdminKecamatan\Setoran\HasilSetoranController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kolektor\DashboardController as KolektorDashboardController;
use App\Http\Controllers\Kolektor\Identitas\DatadiriController;
use App\Http\Controllers\Kolektor\Plotting\TempatController;
use App\Http\Controllers\Kolektor\Report\ReportDataController;
use App\Http\Controllers\Kolektor\Transaksi\HasilKirimController;
use App\Http\Controllers\Kolektor\Transaksi\PenerimaanController;
use App\Http\Controllers\Kolektor\Transaksi\PengirimanController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\Landing\BeritaController;
use App\Http\Controllers\Superadmin\Landing\Halaman1Controller;
use App\Http\Controllers\Superadmin\Landing\KeunggulanController;
use App\Http\Controllers\Superadmin\Landing\LayananController;
use App\Http\Controllers\Superadmin\Landing\PertanyaanController;
use App\Http\Controllers\Superadmin\Landing\ProgramController;
use App\Http\Controllers\Superadmin\Landing\StrukturController;
use App\Http\Controllers\Superadmin\Landing\TentangkamiController;
use App\Http\Controllers\Superadmin\Landing\TestiController;
use App\Http\Controllers\Superadmin\Master\DataAdmin\AdminUserController;
use App\Http\Controllers\Superadmin\Master\DataPenerimaan\DataPenerimaanController;
use App\Http\Controllers\Superadmin\Master\DataPlotting\PlottingController;
use App\Http\Controllers\Superadmin\Master\DataSetting\DataSettingController;
use App\Http\Controllers\Superadmin\Master\DataTemplate\PesanController;
use App\Http\Controllers\Superadmin\Master\DataUser\UserController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KabupatenController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KecamatanController;
use App\Http\Controllers\Superadmin\Master\DataWilayah\KelurahanController;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Route;

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
    // MASTER DATA SETTING
    Route::get('superadmin/master-data/setting', [DataSettingController::class, 'index'])->name('superadmin.master.setting');
    Route::get('superadmin/master-data/setting/tambah-data', [DataSettingController::class, 'tambahdata']);
    Route::post('superadmin/master-data/setting/tambah', [DataSettingController::class, 'tambah']);
    Route::get('superadmin/master-data/setting/edit-data/{id}', [DataSettingController::class, 'editdata']);
    Route::put('superadmin/master-data/setting/edit/{id}', [DataSettingController::class, 'edit']);
    Route::delete('superadmin/master-data/setting/hapus/{id}', [DataSettingController::class, 'hapus']);

    // MASTER DATA USER
    Route::get('superadmin/master-data/user', [UserController::class, 'index'])->name('superadmin.master.user');
    Route::get('superadmin/master-data/user/tambah-data', [UserController::class, 'tambahdata']);
    Route::post('superadmin/master-data/user/tambah', [UserController::class, 'tambah']);
    Route::get('superadmin/master-data/user/edit-data/{id}', [UserController::class, 'editdata']);
    Route::put('superadmin/master-data/user/edit/{id}', [UserController::class, 'edit']);
    Route::delete('superadmin/master-data/user/hapus/{id}', [UserController::class, 'hapus']);
    Route::post('superadmin/master-data/upadmin_kecamatan/info-kirim/index-tampildate-status', [UserController::class, 'updateStatus'])->name('superadmin.data.status');
    Route::post('superadmin/plotting/get-kelurahan', [UserController::class, 'getKelurahan'])->name('superadmin.master.user.getKelurahan');

    // MASTER DATA PENERIMAAN
    Route::get('superadmin/master-data/penerimaan', [DataPenerimaanController::class, 'index'])->name('superadmin.master.penerimaan');
    Route::get('superadmin/master-data/penerimaan/tambah-data', [DataPenerimaanController::class, 'tambahdata']);
    Route::post('superadmin/master-data/penerimaan/tambah', [DataPenerimaanController::class, 'tambah']);
    Route::get('superadmin/master-data/penerimaan/edit-data/{id}', [DataPenerimaanController::class, 'editdata']);
    Route::put('superadmin/master-data/penerimaan/edit/{id}', [DataPenerimaanController::class, 'edit']);
    Route::delete('superadmin/master-data/penerimaan/hapus/{id}', [DataPenerimaanController::class, 'hapus']);
    Route::post('superadmin/master-data/update-status', [DataPenerimaanController::class, 'updateStatus'])->name('superadmin.data.status');

    // MASTER PLOTTING
    Route::get('superadmin/master-data/plotting', [PlottingController::class, 'index'])->name('superadmin.master.plotting');
    Route::get('superadmin/master-data/plotting/tambah-data', [PlottingController::class, 'tambahdata']);
    Route::post('superadmin/master-data/plotting/tambah', [PlottingController::class, 'tambah']);
    Route::get('superadmin/master-data/plotting/edit-data/{id}', [PlottingController::class, 'editdata']);
    Route::put('superadmin/master-data/plotting/edit/{id}', [PlottingController::class, 'edit']);
    Route::delete('superadmin/master-data/plotting/hapus/{id}', [PlottingController::class, 'hapus']);
    Route::get('/superadmin/master/get-kelurahan', [PlottingController::class, 'getKelurahan'])->name('superadmin.master.getKelurahan');

    // MASTER TEMPLATE PESAN
    Route::get('superadmin/master-data/pesan', [PesanController::class, 'index'])->name('superadmin.master.pesan');
    Route::get('superadmin/master-data/pesan/tambah-data', [PesanController::class, 'tambahdata']);
    Route::post('superadmin/master-data/pesan/tambah', [PesanController::class, 'tambah']);
    Route::get('superadmin/master-data/pesan/edit-data/{id}', [PesanController::class, 'editdata']);
    Route::put('superadmin/master-data/pesan/edit/{id}', [PesanController::class, 'edit']);
    Route::delete('superadmin/master-data/pesan/hapus/{id}', [PesanController::class, 'hapus']);

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

    // DATA ADMIN
    Route::get('superadmin/master-data/admin-dataAdmin', [AdminUserController::class, 'index'])->name('superadmin.master.dataAdmin');
    Route::post('superadmin/master-data/update-status', [AdminUserController::class, 'updateStatus'])->name('admin-master.data.status');

    // LANDING PAGE
    // NAVBAR
    Route::get('superadmin/landing/halaman-navbar', [Halaman1Controller::class, 'index'])->name('superadmin.landing.halaman1');
    Route::get('superadmin/landing/halaman-navbar/tambah-data', [Halaman1Controller::class, 'tambahdata']);
    Route::post('superadmin/landing/halaman-navbar/tambah', [Halaman1Controller::class, 'tambah']);
    Route::get('superadmin/landing/halaman-navbar/edit-data/{id}', [Halaman1Controller::class, 'editdata']);
    Route::put('superadmin/landing/halaman-navbar/edit/{id}', [Halaman1Controller::class, 'edit']);
    Route::delete('superadmin/landing/halaman-navbar/hapus/{id}', [Halaman1Controller::class, 'hapus']);
    Route::post('superadmin/landing/halaman1-status', [Halaman1Controller::class, 'updateStatus'])->name('admin-landing.data.halaman1');

    // TENTANG KAMI
    Route::get('superadmin/landing/tentang-kami', [TentangkamiController::class, 'index'])->name('superadmin.landing.tentang');
    Route::get('superadmin/landing/tentang-kami/tambah-data', [TentangkamiController::class, 'tambahdata']);
    Route::post('superadmin/landing/tentang-kami/tambah', [TentangkamiController::class, 'tambah']);
    Route::get('superadmin/landing/tentang-kami/edit-data/{id}', [TentangkamiController::class, 'editdata']);
    Route::put('superadmin/landing/tentang-kami/edit/{id}', [TentangkamiController::class, 'edit']);
    Route::delete('superadmin/landing/tentang-kami/hapus/{id}', [TentangkamiController::class, 'hapus']);
    Route::post('superadmin/landing/tentang-status', [TentangkamiController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // PROGRAM KAMI
    Route::get('superadmin/landing/program-kami', [ProgramController::class, 'index'])->name('superadmin.landing.program');
    Route::get('superadmin/landing/program-kami/tambah-data', [ProgramController::class, 'tambahdata']);
    Route::post('superadmin/landing/program-kami/tambah', [ProgramController::class, 'tambah']);
    Route::get('superadmin/landing/program-kami/edit-data/{id}', [ProgramController::class, 'editdata']);
    Route::put('superadmin/landing/program-kami/edit/{id}', [ProgramController::class, 'edit']);
    Route::delete('superadmin/landing/program-kami/hapus/{id}', [ProgramController::class, 'hapus']);
    Route::post('superadmin/landing/program-status', [ProgramController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // lAYANAN KAMI
    Route::get('superadmin/landing/layanan-kami', [LayananController::class, 'index'])->name('superadmin.landing.layanan');
    Route::get('superadmin/landing/layanan-kami/tambah-data', [LayananController::class, 'tambahdata']);
    Route::post('superadmin/landing/layanan-kami/tambah', [LayananController::class, 'tambah']);
    Route::get('superadmin/landing/layanan-kami/edit-data/{id}', [LayananController::class, 'editdata']);
    Route::put('superadmin/landing/layanan-kami/edit/{id}', [LayananController::class, 'edit']);
    Route::delete('superadmin/landing/layanan-kami/hapus/{id}', [LayananController::class, 'hapus']);
    Route::post('superadmin/landing/layanan-status', [LayananController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // KEUNGGULAN KAMI
    Route::get('superadmin/landing/keunggulan-kami', [KeunggulanController::class, 'index'])->name('superadmin.landing.keunggulan');
    Route::get('superadmin/landing/keunggulan-kami/tambah-data', [KeunggulanController::class, 'tambahdata']);
    Route::post('superadmin/landing/keunggulan-kami/tambah', [KeunggulanController::class, 'tambah']);
    Route::get('superadmin/landing/keunggulan-kami/edit-data/{id}', [KeunggulanController::class, 'editdata']);
    Route::put('superadmin/landing/keunggulan-kami/edit/{id}', [KeunggulanController::class, 'edit']);
    Route::delete('superadmin/landing/keunggulan-kami/hapus/{id}', [KeunggulanController::class, 'hapus']);
    Route::post('superadmin/landing/keunggulan-status', [KeunggulanController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // BERITA 
    Route::get('superadmin/landing/berita', [BeritaController::class, 'index'])->name('superadmin.landing.berita');
    Route::get('superadmin/landing/berita/tambah-data', [BeritaController::class, 'tambahdata']);
    Route::post('superadmin/landing/berita/tambah', [BeritaController::class, 'tambah']);
    Route::get('superadmin/landing/berita/edit-data/{id}', [BeritaController::class, 'editdata']);
    Route::put('superadmin/landing/berita/edit/{id}', [BeritaController::class, 'edit']);
    Route::delete('superadmin/landing/berita/hapus/{id}', [BeritaController::class, 'hapus']);
    Route::post('superadmin/landing/berita-status', [BeritaController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // PERTANYAAN 
    Route::get('superadmin/landing/tanya', [PertanyaanController::class, 'index'])->name('superadmin.landing.tanya');
    Route::get('superadmin/landing/tanya/tambah-data', [PertanyaanController::class, 'tambahdata']);
    Route::post('superadmin/landing/tanya/tambah', [PertanyaanController::class, 'tambah']);
    Route::get('superadmin/landing/tanya/edit-data/{id}', [PertanyaanController::class, 'editdata']);
    Route::put('superadmin/landing/tanya/edit/{id}', [PertanyaanController::class, 'edit']);
    Route::delete('superadmin/landing/tanya/hapus/{id}', [PertanyaanController::class, 'hapus']);
    Route::post('superadmin/landing/tanya-status', [PertanyaanController::class, 'updateStatus'])->name('admin-landing.data.tentang');

    // STRUKTUR PERNGURUS
    Route::get('superadmin/landing/struktur-pengurus', [StrukturController::class, 'index'])->name('superadmin.landing.struktur');
    Route::get('superadmin/landing/struktur-pengurus/tambah-data', [StrukturController::class, 'tambahdata']);
    Route::post('superadmin/landing/struktur-pengurus/tambah', [StrukturController::class, 'tambah']);
    Route::get('superadmin/landing/struktur-pengurus/edit-data/{id}', [StrukturController::class, 'editdata']);
    Route::put('superadmin/landing/struktur-pengurus/edit/{id}', [StrukturController::class, 'edit']);
    Route::delete('superadmin/landing/struktur-pengurus/hapus/{id}', [StrukturController::class, 'hapus']);
    Route::post('superadmin/landing/struktur-status', [StrukturController::class, 'updateStatus'])->name('admin-landing.data.struktur');

    // TESTIMONI
    Route::get('superadmin/landing/testi', [TestiController::class, 'index'])->name('superadmin.landing.testi');
    Route::get('superadmin/landing/testi/tambah-data', [TestiController::class, 'tambahdata']);
    Route::post('superadmin/landing/testi/tambah', [TestiController::class, 'tambah']);
    Route::get('superadmin/landing/testi/edit-data/{id}', [TestiController::class, 'editdata']);
    Route::put('superadmin/landing/testi/edit/{id}', [TestiController::class, 'edit']);
    Route::delete('superadmin/landing/testi/hapus/{id}', [TestiController::class, 'hapus']);
    Route::post('superadmin/landing/testi-status', [TestiController::class, 'updateStatus'])->name('admin-landing.data.struktur');
});

Route::middleware(['auth', 'role:kolektor'])->group(function () {
    Route::get('kolektor/dashboard', [KolektorDashboardController::class, 'index'])->name('kolektor.dashboard');

    // PLOTTING 
    Route::get('kolektor/plotting-index', [TempatController::class, 'index'])->name('plotting.kolektor.index');

    // UPDATE PLOTTING TEMPAT
    Route::get('kolektor/plotting-tempat', [TempatController::class, 'create'])->name('kolektor.plotting.tempat');
    Route::post('kolektor/plotting-tempat/create', [TempatController::class, 'store'])->name('kolektor.plotting.tambah');
    Route::get('kolektor/plotting-tempat/edit/{id}', [TempatController::class, 'editdata']);
    Route::put('kolektor/plotting-tempat/edit-data/{id}', [TempatController::class, 'edit']);
    Route::post('kolektor/plotting/get-kelurahan', [TempatController::class, 'getKelurahan'])->name('kolektor.master.getKelurahan');

    // IDENTITAS
    Route::get('kolektor/identitas/index', [DatadiriController::class, 'index'])->name('kolektor.identitas.index');

    // UPDATE IDENTITAS
    Route::get('kolektor/identitas/create', [DatadiriController::class, 'create'])->name('kolektor.identitas.create');
    Route::post('kolektor/identitas/store', [DatadiriController::class, 'store'])->name('kolektor.identitas.store');
    Route::get('kolektor/identitas/edit/{id}', [DatadiriController::class, 'tampilEdit'])->name('kolektor.identitas.edit');
    Route::put('kolektor/identitas/edit-data/{id}', [DatadiriController::class, 'edit'])->name('kolektor.identitas.edit-data');
    Route::post('kolektor/get-kelurahan', [DatadiriController::class, 'getKelurahan'])->name('kolektor.getKelurahan');

    // KOLEKTOR PENERIMAAN
    Route::get('kolektor/penerimaan/input-infaq', [PenerimaanController::class, 'index'])->name('kolektor.input.infaq');
    Route::get('kolektor/penerimaan/input-infaq/tambah-data', [PenerimaanController::class, 'tampiltambah'])->name('kolektor.input.infaq.tampil');
    Route::post('kolektor/penerimaan/input-infaq/tambah', [PenerimaanController::class, 'tambah'])->name('kolektor.input.infaq.tambah');
    Route::get('kolektor/penerimaan/input-infaq/edit-data/{id}', [PenerimaanController::class, 'editdata'])->name('kolektor.input.infaq.edit-tampil');
    Route::put('kolektor/penerimaan/input-infaq/edit/{id}', [PenerimaanController::class, 'edit'])->name('kolektor.input.infaq.edit');
    Route::delete('kolektor/penerimaan/input-infaq/hapus/{id}', [PenerimaanController::class, 'hapus'])->name('kolektor.input.infaq.hapus');
    Route::post('/get-kelurahan', [PenerimaanController::class, 'getKelurahanByKecamatan'])->name('ajax.getKelurahan');
    Route::get('kolektor/penerimaan/get-kelurahan', [PenerimaanController::class, 'getKelurahan'])->name('kolektor.penerimaan.getKelurahan');
    Route::get('/search-noalat', [PenerimaanController::class, 'searchNoAlat'])->name('search.noalat');
    Route::get('/search-namadonatur', [PenerimaanController::class, 'searchNamaDonatur'])->name('search.namadonatur');

    // KOLEKTOR PENGIRIMAN
    Route::get('kolektor/pengiriman/index', [PengirimanController::class, 'index'])->name('kolektor.pengiriman.index');
    Route::post('kolektor/pengiriman/index-infaq', [PengirimanController::class, 'kirim']);
    Route::get('kolektor/pengiriman/getKelurahan', [PenerimaanController::class, 'getKelurahan'])->name('kolektor.pengiriman.getKelurahan');

    // KOLEKTOR SETORAN
    Route::get('kolektor/setoran', [HasilKirimController::class, 'index'])->name('kolektor.hasil-setoran');
    Route::get('kolektor/setoran/getKelurahan', [HasilKirimController::class, 'getKelurahan'])->name('kolektor.setoran.getKelurahan');

    // REPORT DATA
    Route::get('kolektor/setor-infaq/index', [ReportDataController::class, 'index'])->name('kolektor.setor-infaq');
    // EXCEL
    // Route for initiating Excel export
    Route::get('/download-excel/{filename}', [ReportDataController::class, 'downloadExcel'])->name('kolektor.report.excel.download');
    Route::post('/kolektor/report/excel', [ReportDataController::class, 'exportExcel'])->name('kolektor.report.excel');
    // PDF
    Route::get('/download-pdf/{filename}', [ReportDataController::class, 'downloadPdf'])->name('download.pdf');
    Route::post('/kolektor/report/pdf', [ReportDataController::class, 'exportPdf'])->name('kolektor.report.pdf');
    Route::get('kolektor/setor-infaq/getKelurahan', [ReportDataController::class, 'getKelurahan'])->name('kolektor.export.getKelurahan');
});

Route::middleware(['auth', 'role:admin_kecamatan'])->group(function () {
    Route::get('admin_kecamatan/dashboard', [AdminKecamatanDashboardController::class, 'index'])->name('admin_kecamatan.index');

    // IDENTITAS
    Route::get('admin_kecamatan/identitas/index', [IdentitasDataDiriController::class, 'index'])->name('admin_kecamatan.identitas.index');

    // UPDATE IDENTITAS
    Route::get('admin_kecamatan/identitas/create', [IdentitasDataDiriController::class, 'create'])->name('admin_kecamatan.identitas.create');
    Route::post('admin_kecamatan/identitas/store', [IdentitasDataDiriController::class, 'store'])->name('admin_kecamatan.identitas.store');
    Route::get('admin_kecamatan/identitas/edit/{id}', [IdentitasDataDiriController::class, 'tampilEdit'])->name('admin_kecamatan.identitas.edit');
    Route::put('admin_kecamatan/identitas/edit-data/{id}', [IdentitasDataDiriController::class, 'edit'])->name('admin_kecamatan.identitas.edit-data');
    Route::post('admin_kecamatan-identitas/get-kelurahan', [IdentitasDataDiriController::class, 'getKelurahan'])->name('admin_kecamatan.getKelurahan');

    // DATA SETORAN
    Route::get('admin_kecamatan/hasil-setoran/index', [HasilSetoranController::class, 'index'])->name('adminkecamatan.hasil-setoran');
    Route::get('admin_kecamatan/getKelurahan', [HasilSetoranController::class, 'getKelurahan'])->name('admin.getKelurahan');
    Route::post('/admin_kecamatan/update-status', [HasilSetoranController::class, 'updateStatus'])
        ->name('admin_kecamatan.updateStatus');

    // EXPORT DATA EXCEL
    Route::get('/download-excel/{filename}', [HasilSetoranController::class, 'downloadExcel'])->name('admin_kecamatan.report.excel.download');
    Route::post('/admin_kecamatan/report/excel', [HasilSetoranController::class, 'exportExcel'])->name('admin_kecamatan.report.excel');
    // PDF
    Route::get('/download-pdf/{filename}', [HasilSetoranController::class, 'downloadPdf'])->name('download.pdf');
    Route::post('/admin_kecamatan/report/pdf', [HasilSetoranController::class, 'exportPdf'])->name('admin_kecamatan.report.pdf');

    Route::get('/storage/{path}', function ($path) {
        $filePath = storage_path('app/public/' . $path);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Cache-Control' => 'public, max-age=3600'
        ]);
    })->where('path', '.*');

    // KIRIM PESAN
    Route::get('admin_kecamatan/info-index', [TampilController::class, 'index'])->name('admin_kecamatan.info-kirim');
    Route::get('admin_kecamatan/info-kirim/index-tampil', [TampilController::class, 'tampil'])->name('admin_kecamatan.info-kirim.tampil');
    Route::post('/admin-kecamatan/send-whatsapp', [SendController::class, 'sendWhatsApp'])->name('adminkecamatan.send-whatsapp');
    Route::delete('admin-kecamatan/laporan/{filename}', [TampilController::class, 'deleteLaporan'])->name('adminkecamatan.laporan.delete');

    // REKAP KIRIM FILE
    Route::get('admin_kecamatan/rekap-info/file', [FileController::class, 'index'])->name('admin_kecamatan.rekap-info');
});

Route::middleware(['auth', 'role:admin_kabupaten'])->group(function () {
    Route::get('admin_kabupaten/dashboard', [AdminKabupatenDashboardController::class, 'index'])->name('admin_kabupaten.index');

    // SETOR
    Route::get('admin_kabupaten/data-setor', [SetorController::class, 'index'])->name('admin_kabupaten.data-setor');
    Route::post('/admin_kabupaten/update-status', [SetorController::class, 'updateStatus'])
        ->name('admin_kabupaten.updateStatus');

    // REKAP
    Route::get('admin_kabupaten/rekap-index', [RekapController::class, 'index'])->name('admin_kabupaten.rekap');
});

// Route::get('/test-wa', function (FonnteService $fonnteService) {
//     $fonnteService->sendWhatsAppMessage('085866090206', 'Coba kirim pesan dari Laravel via Fonnte');
//     return 'Pesan dikirim!';
// });
