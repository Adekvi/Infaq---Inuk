<?php

namespace App\Http\Controllers\Kolektor;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Role\Transaksi\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek autentikasi
        if (Auth::check()) {
            session(['kolektor' => true]);
        } else {
            session(['kolektor' => false]);
            return redirect()->route('login'); // Redirect jika belum login
        }

        $userId = Auth::id();
        // Mendapatkan tahun dan bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Ambil id_plot yang terkait dengan user yang login
        $plotIds = Plotting::where('id_user', $userId)->pluck('id')->toArray();

        // Ambil data penerimaan berdasarkan id_user dan id_plot
        $penerimaan = Penerimaan::where('id_user', $userId)
            ->whereIn('id_plot', $plotIds)
            ->get();

        // Total donasi
        $totalDonasi = $penerimaan->sum('nominal');

        // Jumlah donatur (total entri data yang dimasukkan oleh kolektor)
        $jumlahDonatur = $penerimaan->count(); // Menghitung jumlah baris di penerimaan

        // Total target donatur (jumlah id_plot dari plotting untuk user ini)
        $totalTarget = Plotting::where('id_user', $userId)->count();

        // Persentase capaian donatur
        $persentase = $totalTarget > 0 ? ($jumlahDonatur / $totalTarget) : 0;

        // Donasi disetor (donasi dengan status 'Kirim')
        $donasiDisetor = Penerimaan::where('id_user', $userId)
            ->whereIn('id_plot', $plotIds)
            ->where('status', 'Kirim')
            ->sum('nominal');

        // Query untuk rekap per RW berdasarkan id_user yang login dan id_plot
        $rekap_per_rw = Penerimaan::selectRaw('JSON_UNQUOTE(plottings.Rw) as Rw, COUNT(penerimaans.id) as jumlah_donatur_mengirim, SUM(penerimaans.nominal) as total_donasi')
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            // ->where('penerimaans.status', 'Kirim')
            ->where('penerimaans.id_user', $userId)
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->groupBy('plottings.Rw')
            ->orderBy('plottings.Rw')
            ->get();

        // Total donatur per RW dari tabel plottings untuk id_user yang login
        $total_donatur_per_rw = Plotting::selectRaw('plottings.Rw, COUNT(plottings.id) as total_donatur')
            ->where('plottings.id_user', $userId) // Filter berdasarkan id_user yang login
            ->groupBy('plottings.Rw')
            ->orderBy('plottings.Rw')
            ->get();

        // Gabungkan data dan hitung persentase
        $rekap_per_rw = $rekap_per_rw->map(function ($item) use ($total_donatur_per_rw) {
            $total_donatur = $total_donatur_per_rw->where('Rw', $item->Rw)->first()->total_donatur ?? 0;
            // Pastikan total_donatur minimal sama dengan jumlah_donatur_mengirim
            $item->total_donatur = max($total_donatur, $item->jumlah_donatur_mengirim);
            // Hitung persentase dengan benar
            $item->persentase = $item->total_donatur > 0 ? ($item->jumlah_donatur_mengirim / $item->total_donatur) : 0;
            return $item;
        });

        return view('kolektor.dashboard.index', compact('totalDonasi', 'jumlahDonatur', 'totalTarget', 'persentase', 'donasiDisetor', 'rekap_per_rw'));
    }
}
