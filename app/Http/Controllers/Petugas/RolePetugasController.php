<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\db_kelurahan_petugas;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Role\Db_hasilinfaq;
use App\Models\Role\Petugas\Db_setorinfaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePetugasController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['petugas' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['petugas' => false]);
        }

        // Ambil data petugas berdasarkan id_user dari pengguna yang sedang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->with(['kecamatan', 'kelurahan'])
            ->get();

        // Hitung total infaq berdasarkan id_petugas
        $total_infaq = Db_setorinfaq::where('id_petugas', $petugas->id)
            ->where('status', 'A')
            ->sum('total');

        $total_setor = Db_hasilinfaq::with('setor')
            ->where('id_petugas', $petugas->id)
            ->where('id_user', Auth::user()->id)
            ->where('status', 'K')
            ->get()
            ->sum(function ($hasil) {
                return $hasil->setor ? $hasil->setor->jumlah : 0;
            });

        // Jika Anda ingin data infaq lengkap dengan relasi (opsional)
        $infaqDetails = Db_setorinfaq::where('id_petugas', $petugas->id)
            ->where('status', 'A')
            ->with(['user', 'petugas.wilayahTugas.kecamatan', 'petugas.wilayahTugas.kelurahan', 'kecamatan', 'kelurahan'])
            ->first();

        // Kembalikan ke view atau gunakan data
        return view('petugas.dashboard.index', compact('petugas', 'wilayahTugas', 'total_infaq', 'infaqDetails', 'total_setor'));
    }
}
