<?php

namespace App\Http\Controllers\Kolektor\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Role\Transaksi\Penerimaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilKirimController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $rt = $request->input('rt');
        $rw = $request->input('rw');
        $showAll = $request->input('show_all', false); // Parameter untuk tampilkan semua data

        // Query dasar untuk Penerimaan
        $query = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Kirim')
            ->with(['user', 'plotting.kecamatan', 'plotting.kelurahan']);

        // Filter tanggal default (hanya hari ini) kecuali show_all=true
        if (!$showAll) {
            $query->whereDate('tglSetor', Carbon::today()->toDateString());
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('tglSetor', 'LIKE', "%{$search}%")
                    ->orWhere('nominal', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('Rt', 'LIKE', "%{$search}%")
                    ->orWhere('Rw', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('username', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kecamatan', function ($q3) use ($search) {
                        $q3->where('nama_kecamatan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kelurahan', function ($q3) use ($search) {
                        $q3->where('nama_kelurahan', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter kec burrr
        if ($kecamatan) {
            $query->whereHas('plotting.kecamatan', function ($q) use ($kecamatan) {
                $q->where('db_kecamatans.id', $kecamatan);
            });
        }

        // Filter kelurahan
        if ($kelurahan) {
            $query->whereHas('plotting.kelurahan', function ($q) use ($kelurahan) {
                $q->where('db_kelurahans.id', $kelurahan);
            });
        }

        // Filter Rt
        if ($rt) {
            $query->where('Rt', $rt);
        }

        // Filter Rw
        if ($rw) {
            $query->where('Rw', $rw);
        }

        // Ambil data dengan paginasi
        $hasil = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $hasil->appends([
            'search' => $search,
            'entries' => $entries,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'rt' => $rt,
            'rw' => $rw,
            'show_all' => $showAll
        ]);

        // Ambil data untuk dropdown
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();
        // Ambil nilai unik Rt dan Rw dari penerimaans
        $rts = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rt')
            ->filter()
            ->sort()
            ->values();
        $rws = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rw')
            ->filter()
            ->sort()
            ->values();

        return view('kolektor.transaksi.hasil.index', compact('hasil', 'search', 'entries', 'kecamatans', 'rts', 'rws', 'showAll'));
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }
}
