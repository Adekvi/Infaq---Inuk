<?php

namespace App\Http\Controllers\AdminKecamatan;

use App\Http\Controllers\Controller;
use App\Models\Master\Penerimaan\Dataterima;
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
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Get the kecamatan assigned to the logged-in admin_kecamatan from plottings
        $kecamatan = Plotting::where('plottings.id_user', $user->id)
            ->join('users', 'plottings.id_user', '=', 'users.id')
            ->where('users.role', 'admin_kecamatan')
            ->select('plottings.id_kecamatan')
            ->first();

        if (!$kecamatan) {
            return view('admin_kecamatan.index', [
                'error' => 'No kecamatan assigned to this user.',
                'total_donasi_tahun' => 0,
                'total_donasi_per_bulan' => [],
                'total_kolektor' => 0,
                'kolektor_mengirim_bulan_ini' => 0,
                'persentase_mengirim' => 0,
                'persentase_belum_mengirim' => 0,
                'rekap_per_rw' => collect([]),
                'rekap_per_kelurahan' => collect([]),
            ]);
        }

        $id_kecamatan = $kecamatan->id_kecamatan;

        // Total donations for the current year with status 'Kirim' in the user's kecamatan
        $total_donasi_tahun = Penerimaan::where('status', 'Kirim')
            ->whereYear('tglSetor', $currentYear)
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->sum('penerimaans.nominal');

        // Monthly donations for the current year in the user's kecamatan
        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->where('status', 'Kirim')
            ->whereYear('tglSetor', $currentYear)
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Convert month numbers to Indonesian month names
        $total_donasi_per_bulan = [];
        foreach ($donasi_bulanan as $data) {
            $namaBulan = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $total_donasi_per_bulan[$namaBulan] = $data->total;
        }

        // Total donatur: Distinct user yang pernah kirim di tahun ini (dari Penerimaan, sesuai logika baru)
        $total_kolektor = Penerimaan::where('status', 'Kirim')
            ->whereYear('tglSetor', $currentYear)
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->distinct('penerimaans.id_user')
            ->count('penerimaans.id_user');

        // dd($total_kolektor);

        // Donatur mengirim bulan ini (sudah benar, distinct user di bulan ini)
        $kolektor_mengirim_bulan_ini = Penerimaan::where('status', 'Kirim')
            ->whereYear('tglSetor', $currentYear)
            ->whereMonth('tglSetor', $currentMonth)
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->distinct('penerimaans.id_user')
            ->count('penerimaans.id_user');

        // Calculate percentages (fix: gunakan *100 untuk persen)
        $persentase_mengirim = $total_kolektor > 0 ? round(($kolektor_mengirim_bulan_ini / $total_kolektor)) : 0;
        $persentase_belum_mengirim = $total_kolektor > 0 ? round((($total_kolektor - $kolektor_mengirim_bulan_ini) / $total_kolektor)) : 0;

        // Rekap donasi per RW: Gunakan JSON_UNQUOTE untuk ambil elemen pertama sebagai string (misal "4")
        // Jika array multiple, ganti dengan JSON_EXTRACT dan GROUP_CONCAT jika perlu
        $rekap_per_rw = Penerimaan::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(plottings.Rw, "$[0]")) as Rw, 
            COUNT(DISTINCT penerimaans.id_user) as jumlah_kolektor_mengirim, 
            SUM(penerimaans.nominal) as total_donasi')
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->groupBy('Rw')  // Sekarang group by string biasa
            ->orderBy('Rw')
            ->get();

        // dd($rekap_per_rw);

        // Total donatur per RW: Serupa, dari Penerimaan tahun ini (logika baru)
        $total_donatur_per_rw = Penerimaan::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(plottings.Rw, "$[0]")) as Rw, 
            COUNT(DISTINCT penerimaans.id_user) as total_donatur')
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->groupBy('Rw')
            ->orderBy('Rw')
            ->get();

        // Combine dan hitung persentase
        $rekap_per_rw = $rekap_per_rw->map(function ($item) use ($total_donatur_per_rw) {
            $total_donatur = $total_donatur_per_rw->where('Rw', $item->Rw)->first()->total_donatur ?? $item->jumlah_kolektor_mengirim;
            $item->total_donatur = $total_donatur;
            $item->persentase = $item->total_donatur > 0 ? round(($item->jumlah_kolektor_mengirim / $item->total_donatur)) : 0;
            return $item;
        });

        // Kelurahan tetap sama (asumsi id_kelurahan bukan JSON)
        $kelurahans = Db_kelurahan::where('id_kecamatan', $id_kecamatan)
            ->pluck('nama_kelurahan', 'id')
            ->toArray();

        $rekap_per_kelurahan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->selectRaw('plottings.id_kelurahan, COUNT(DISTINCT penerimaans.id_user) as jumlah_kolektor_mengirim, SUM(penerimaans.nominal) as total_donasi')
            ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->groupBy('plottings.id_kelurahan')
            ->orderBy('plottings.id_kelurahan')
            ->get();

        // Total donatur per kelurahan: Dari Penerimaan tahun ini
        $total_donatur_per_kelurahan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->selectRaw('plottings.id_kelurahan, COUNT(DISTINCT penerimaans.id_user) as total_donatur')
            ->where('penerimaans.status', 'Kirim')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->where('plottings.id_kecamatan', $id_kecamatan)
            ->groupBy('plottings.id_kelurahan')
            ->orderBy('plottings.id_kelurahan')
            ->get();

        // Combine kelurahan
        $rekap_per_kelurahan = $rekap_per_kelurahan->map(function ($item) use ($total_donatur_per_kelurahan, $kelurahans) {
            $total_donatur = $total_donatur_per_kelurahan->where('id_kelurahan', $item->id_kelurahan)->first()->total_donatur ?? $item->jumlah_kolektor_mengirim;
            $item->total_donatur = $total_donatur;
            $item->persentase = $item->total_donatur > 0 ? round(($item->jumlah_kolektor_mengirim / $item->total_donatur)) : 0;
            $item->nama_kelurahan = $kelurahans[$item->id_kelurahan] ?? $item->id_kelurahan;
            return $item;
        });

        // $kecamatan = Plotting::with('kecamatan')
        //     ->where('id_user', $user)
        //     ->first();

        return view('admin_kecamatan.index', compact(
            'total_donasi_tahun',
            'total_donasi_per_bulan',
            'total_kolektor',
            'kolektor_mengirim_bulan_ini',
            'persentase_mengirim',
            'persentase_belum_mengirim',
            'rekap_per_rw',
            'rekap_per_kelurahan',
            'kecamatan'
        ));
    }
}
