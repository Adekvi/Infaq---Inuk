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
        if (Auth::check()) {
            session(['kolektor' => true]);
        } else {
            session(['kolektor' => false]);
        }

        $userId = Auth::id();

        // Ambil data penerimaan milik user yang sedang login
        $penerimaan = Penerimaan::where('id_user', $userId)->get();

        // Total donasi
        $totalDonasi = $penerimaan->sum('nominal');

        // Jumlah donatur unik (bisa berdasarkan nomor rekening atau nama pengirim, tergantung datanya)
        $jumlahDonatur = $penerimaan->groupBy('Rekening')->count();

        // Total target donatur: misalnya diasumsikan dari plotting wilayah?
        // Kamu bisa sesuaikan bagian ini berdasarkan relasi atau data target
        // Untuk contoh ini saya asumsikan total target = jumlah plotting yang terkait user
        $totalTarget = Plotting::where('id_user', $userId)->count(); // sesuaikan jika salah

        // Persentase
        $persentase = $totalTarget > 0 ? ($jumlahDonatur / $totalTarget) * 100 : 0;

        return view('kolektor.dashboard.index', compact('totalDonasi', 'jumlahDonatur', 'totalTarget', 'persentase'));
    }
}
