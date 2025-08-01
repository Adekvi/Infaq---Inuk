<?php

namespace App\Http\Controllers\AdminKecamatan;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kelurahan;
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
            session(['admin_kecamatan' => true]);
        } else {
            session(['admin_kecamatan' => false]);
        }

        // Mendapatkan tahun dan bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Total donasi untuk tahun saat ini dengan status 'kirim'
        $total_donasi_tahun = Penerimaan::where('status', 'kirim')
            ->whereYear('tglSetor', $currentYear)
            ->sum('nominal');

        // Total donasi per bulan untuk tahun saat ini
        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->where('status', 'Kirim')
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
        $kolektor_mengirim_bulan_ini = Penerimaan::where('status', 'Kirim')
            ->whereYear('tglSetor', $currentYear)
            ->whereMonth('tglSetor', $currentMonth)
            ->distinct('id_user')
            ->count('id_user');

        // Hitung persentase kolektor yang mengirim
        $persentase_mengirim = $total_kolektor > 0 ? $kolektor_mengirim_bulan_ini : 0;

        // Hitung persentase kolektor yang belum mengirim
        $persentase_belum_mengirim = $total_kolektor > 0 ? ($total_kolektor - $kolektor_mengirim_bulan_ini) : 0;

        // Rekap donasi per RW untuk bulan saat ini
        $rekap_per_rw = Penerimaan::selectRaw('penerimaans.Rw, COUNT(DISTINCT penerimaans.id_user) as jumlah_donatur_mengirim, SUM(penerimaans.nominal) as total_donasi')
            // ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->groupBy('penerimaans.Rw')
            ->orderBy('penerimaans.Rw')
            ->get();

        // Total donatur per RW dari tabel plottings
        $total_donatur_per_rw = Plotting::join('users', 'plottings.id_user', '=', 'users.id')
            ->selectRaw('plottings.Rw, COUNT(DISTINCT plottings.id_user) as total_donatur')
            ->where('users.role', 'kolektor')
            ->groupBy('plottings.Rw')
            ->orderBy('plottings.Rw')
            ->get();

        // Gabungkan data dan hitung persentase
        $rekap_per_rw = $rekap_per_rw->map(function ($item) use ($total_donatur_per_rw) {
            $total_donatur = $total_donatur_per_rw->where('Rw', $item->Rw)->first()->total_donatur ?? 0;
            // Jika ada donatur mengirim, minimal total_donatur adalah jumlah_donatur_mengirim
            $item->total_donatur = max($total_donatur, $item->jumlah_donatur_mengirim);
            // Persentase dihitung langsung dari jumlah_donatur_mengirim
            $item->persentase = $item->total_donatur > 0 ? $item->jumlah_donatur_mengirim : 0;
            return $item;
        });

        $kelurahans = Db_kelurahan::pluck('nama_kelurahan', 'id')->toArray();

        // Rekap donasi per kecamatan untuk bulan saat ini
        $rekap_per_kelurahan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->selectRaw('plottings.id_kelurahan, COUNT(DISTINCT penerimaans.id_user) as jumlah_donatur_mengirim, SUM(penerimaans.nominal) as total_donasi')
            // ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->groupBy('plottings.id_kelurahan')
            ->orderBy('plottings.id_kelurahan')
            ->get();

        // Total donatur per kecamatan dari tabel plottings
        $total_donatur_per_kelurahan = Plotting::join('users', 'plottings.id_user', '=', 'users.id')
            ->selectRaw('plottings.id_kelurahan, COUNT(DISTINCT plottings.id_user) as total_donatur')
            ->where('users.role', 'kolektor')
            ->groupBy('plottings.id_kelurahan')
            ->orderBy('plottings.id_kelurahan')
            ->get();

        // dd($rekap_per_kelurahan, $total_donatur_per_kelurahan);

        // Gabungkan data dan hitung persentase
        $rekap_per_kelurahan = $rekap_per_kelurahan->map(function ($item) use ($total_donatur_per_kelurahan, $kelurahans) {
            $total_donatur = $total_donatur_per_kelurahan->where('id_kelurahan', $item->id_kelurahan)->first()->total_donatur ?? 0;
            // Jika ada donatur mengirim, minimal total_donatur adalah jumlah_donatur_mengirim
            $item->total_donatur = max($total_donatur, $item->jumlah_donatur_mengirim);
            // Persentase dihitung langsung dari jumlah_donatur_mengirim
            $item->persentase = $item->total_donatur > 0 ? ($item->jumlah_donatur_mengirim / $item->total_donatur * 100) : 0;
            $item->nama_kelurahan = $kelurahans[$item->id_kelurahan] ?? $item->id_kelurahan;
            return $item;
        });

        return view('admin_kecamatan.index', compact(
            'total_donasi_tahun',
            'total_donasi_per_bulan',
            'total_kolektor',
            'kolektor_mengirim_bulan_ini',
            'persentase_mengirim',
            'persentase_belum_mengirim',
            'rekap_per_rw',
            'rekap_per_kelurahan'
        ));
    }
}
