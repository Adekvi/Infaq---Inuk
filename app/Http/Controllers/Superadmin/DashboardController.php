<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            session(['superadmin' => true]);
        } else {
            session(['superadmin' => false]);
        }

        // Mendapatkan tahun dan bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Total donasi untuk tahun saat ini dengan status 'Kirim'
        $total_donasi_tahun = Penerimaan::whereYear('tglSetor', $currentYear)
            ->sum('nominal');

        // Total donasi per bulan untuk tahun saat ini
        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->whereYear('tglSetor', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ubah angka bulan menjadi nama bulan Indonesia
        $total_donasi_per_bulan = [];
        foreach ($donasi_bulanan as $data) {
            $namaBulan = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $total_donasi_per_bulan[$namaBulan] = $data->total;
        }

        // Ambil semua data penerimaan
        $penerimaan = Penerimaan::all();

        // Total donasi
        $totalDonasi = $penerimaan->sum('nominal');

        // Jumlah donatur (jumlah baris)
        $jumlahDonatur = $penerimaan->count();

        $donatur_diterima = Penerimaan::where('status', 'Pending')
            ->sum('nominal');

        $donatur_dikirim = Penerimaan::where('status', 'Kirim')
            ->sum('nominal');

        // Total kolektor (dari tabel users dengan role 'kolektor')
        $total_kolektor = User::where('role', 'kolektor')->count();

        return view('superadmin.index', compact(
            'total_donasi_tahun',
            'total_donasi_per_bulan',
            'jumlahDonatur',
            'total_kolektor',
            'donatur_diterima',
            'donatur_dikirim',
        ));
    }
}
