<?php

use App\Http\Controllers\Adminkecamatan\DashboardController as AdminkecamatanDashboardController;
use App\Http\Controllers\Adminkecamatan\Info\KirimInformasiController;
use App\Http\Controllers\Adminkecamatan\Pengiriman\SendController;
use App\Http\Controllers\Adminkecamatan\Pengiriman\TampilController;
use App\Http\Controllers\Adminkecamatan\Rekap\FileController;
use App\Http\Controllers\Adminkecamatan\Setoran\HasilSetoranController;
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
use App\Http\Controllers\Superadmin\Master\DataAdmin\AdminUserController;
use App\Http\Controllers\Superadmin\Master\DataPlotting\PlottingController;
use App\Http\Controllers\Superadmin\Master\DataSetting\DataSettingController;
use App\Http\Controllers\Superadmin\Master\DataTemplate\PesanController;
use App\Http\Controllers\Superadmin\Master\DataUser\UserController;
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

    // DATA PETUGAS
    // Route::get('superadmin/master-data/petugas-dataPetugas', [PetugasController::class, 'index'])->name('superadmin.master.dataPetugas');
    // Route::get('superadmin/master-data/petugas-dataPetugas/tambah-data', [PetugasController::class, 'tambahdata']);
    // Route::post('superadmin/master-data/petugas-dataPetugas/tambah', [PetugasController::class, 'tambah']);
    // Route::get('superadmin/master-data/petugas-dataPetugas/edit-data/{id}', [PetugasController::class, 'editdata']);
    // Route::put('superadmin/master-data/petugas-dataPetugas/edit/{id}', [PetugasController::class, 'edit']);
    // Route::delete('superadmin/master-data/petugas-dataPetugas/hapus/{id}', [PetugasController::class, 'hapus']);

    // DATA ADMIN
    Route::get('superadmin/master-data/admin-dataAdmin', [AdminUserController::class, 'index'])->name('superadmin.master.dataAdmin');
    Route::post('superadmin/master-data/update-status', [AdminUserController::class, 'updateStatus'])->name('admin-master.data.status');
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
    Route::get('kolektor/get-kelurahan', [DatadiriController::class, 'getKelurahan'])->name('kolektor.getKelurahan');

    // KOLEKTOR PENERIMAAN
    Route::get('kolektor/penerimaan/input-infaq', [PenerimaanController::class, 'index'])->name('kolektor.input.infaq');
    Route::get('kolektor/penerimaan/input-infaq/tambah-data', [PenerimaanController::class, 'tampiltambah'])->name('kolektor.input.infaq.tampil');
    Route::post('kolektor/penerimaan/input-infaq/tambah', [PenerimaanController::class, 'tambah'])->name('kolektor.input.infaq.tambah');
    Route::get('kolektor/penerimaan/input-infaq/edit-data/{id}', [PenerimaanController::class, 'editdata'])->name('kolektor.input.infaq.edit-tampil');
    Route::put('kolektor/penerimaan/input-infaq/edit/{id}', [PenerimaanController::class, 'edit'])->name('kolektor.input.infaq.edit');
    Route::delete('kolektor/penerimaan/input-infaq/hapus/{id}', [PenerimaanController::class, 'hapus'])->name('kolektor.input.infaq.hapus');
    Route::get('kolektor/penerimaan/get-kelurahan', [PenerimaanController::class, 'getKelurahan'])->name('kolektor.penerimaan.getKelurahan');

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
    Route::get('admin_kecamatan/dashboard', [AdminkecamatanDashboardController::class, 'index'])->name('admin_kecamatan.index');

    // DATA SETORAN
    Route::get('admin_kecamatan/hasil-setoran/index', [HasilSetoranController::class, 'index'])->name('adminkecamatan.hasil-setoran');
    Route::get('admib_kecamatan/getKelurahan', [HasilSetoranController::class, 'getKelurahan'])->name('admin.getKelurahan');

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
