<?php

namespace App\Http\Controllers\AdminKabupaten;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
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
            session(['admin_kabupaten' => true]);
        } else {
            session(['admin_kabupaten' => false]);
        }

        // Mendapatkan tahun dan bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Total donasi untuk tahun saat ini dengan status 'Kirim'
        $total_donasi_tahun = Penerimaan::where('status', 'Validasi')
            ->whereYear('tglSetor', $currentYear)
            ->sum('nominal');

        // Total donasi per bulan untuk tahun saat ini
        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->where('status', 'Validasi')
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

        // Total kolektor (dari tabel users dengan role 'kolektor')
        $total_kolektor = User::where('role', 'kolektor')->count();

        // Jumlah kolektor yang sudah mengirim infaq untuk bulan saat ini
        $kolektor_mengirim_bulan_ini = Penerimaan::where('status', 'Validasi')
            ->whereYear('tglSetor', $currentYear)
            ->whereMonth('tglSetor', $currentMonth)
            ->distinct('id_user')
            ->count('id_user');

        // Hitung persentase kolektor yang mengirim
        $persentase_mengirim = $total_kolektor > 0 ? ($kolektor_mengirim_bulan_ini / $total_kolektor) : 0;

        // Hitung persentase kolektor yang belum mengirim
        $persentase_belum_mengirim = $total_kolektor > 0 ? (($total_kolektor - $kolektor_mengirim_bulan_ini) / $total_kolektor) : 0;

        // Rekap donasi per kecamatan untuk bulan saat ini
        $rekap_per_kecamatan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->selectRaw('plottings.id_kecamatan, COUNT(DISTINCT penerimaans.id_user) as jumlah_donatur_mengirim, SUM(penerimaans.nominal) as total_donasi')
            ->where('penerimaans.status', 'Validasi')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->groupBy('plottings.id_kecamatan')
            ->orderBy('plottings.id_kecamatan')
            ->get();

        // Total donatur per kecamatan dari tabel plottings
        $total_donatur_per_kecamatan = Plotting::join('users', 'plottings.id_user', '=', 'users.id')
            ->selectRaw('plottings.id_kecamatan, COUNT(DISTINCT plottings.id_user) as total_donatur')
            ->where('users.role', 'kolektor')
            ->groupBy('plottings.id_kecamatan')
            ->orderBy('plottings.id_kecamatan')
            ->get();

        // Ambil nama kecamatan
        $kecamatans = Db_kecamatan::pluck('nama_kecamatan', 'id')->toArray();

        // Gabungkan data dan hitung persentase
        $rekap_per_kecamatan = $rekap_per_kecamatan->map(function ($item) use ($total_donatur_per_kecamatan, $kecamatans) {
            $total_donatur = $total_donatur_per_kecamatan->where('id_kecamatan', $item->id_kecamatan)->first()->total_donatur ?? 0;
            $item->total_donatur = max($total_donatur, $item->jumlah_donatur_mengirim);
            $item->persentase = $item->total_donatur > 0 ? ($item->jumlah_donatur_mengirim / $item->total_donatur) : 0;
            $item->nama_kecamatan = $kecamatans[$item->id_kecamatan] ?? $item->id_kecamatan;
            return $item;
        });

        // Hitung total donasi dari semua kecamatan (dari penerimaans)
        $total_donasi_kecamatan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('penerimaans.status', 'Validasi')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->sum('penerimaans.nominal');

        // Hitung jumlah kecamatan yang telah setor (dari pengirimaninfaqs)
        $kecamatan_sudah_setor = Pengirimaninfaq::join('plottings', 'pengirimaninfaqs.id_user', '=', 'plottings.id_user')
            ->where('pengirimaninfaqs.status', 'Terkirim')
            ->whereYear('pengirimaninfaqs.tglKirim', $currentYear)
            ->whereMonth('pengirimaninfaqs.tglKirim', $currentMonth)
            ->distinct('plottings.id_kecamatan')
            ->count('plottings.id_kecamatan');

        // Total kecamatan dari db_kecamatans
        $total_kecamatan = Db_kecamatan::count();

        // Gabungkan data dan hitung persentase
        $rekap_per_kecamatan = $rekap_per_kecamatan->map(function ($item) use ($total_donatur_per_kecamatan, $kecamatans) {
            $total_donatur = $total_donatur_per_kecamatan->where('id_kecamatan', $item->id_kecamatan)->first()->total_donatur ?? 0;
            $item->total_donatur = max($total_donatur, $item->jumlah_donatur_mengirim);
            $item->persentase = $item->total_donatur > 0 ? ($item->jumlah_donatur_mengirim / $item->total_donatur) : 0;
            $item->nama_kecamatan = $kecamatans[$item->id_kecamatan] ?? $item->id_kecamatan;
            return $item;
        });

        // Hitung jumlah kecamatan yang telah mengirim infaq (dari pengirimaninfaqs)
        $kecamatan_mengirim = PengirimanInfaq::where('status', 'Terkirim')
            ->whereYear('tglKirim', $currentYear)
            ->whereMonth('tglKirim', $currentMonth)
            ->distinct('nama_kecamatan')
            ->count('nama_kecamatan');

        // Total kecamatan dari db_kecamatans
        $total_kecamatan = Db_kecamatan::count();

        // Hitung persentase kecamatan yang mengirim
        $persentase_kecamatan_mengirim = $total_kecamatan > 0
            ? ($kecamatan_mengirim / $total_kecamatan) * 100
            : 0;

        return view('admin_kabupaten.index', compact(
            'total_donasi_tahun',
            'total_donasi_per_bulan',
            'total_kolektor',
            'kolektor_mengirim_bulan_ini',
            'persentase_mengirim',
            'persentase_belum_mengirim',
            'rekap_per_kecamatan',
            'total_donasi_kecamatan',
            'kecamatan_sudah_setor',
            'total_kecamatan',
            'kecamatan_mengirim',
            'persentase_kecamatan_mengirim'
        ));
    }
}
