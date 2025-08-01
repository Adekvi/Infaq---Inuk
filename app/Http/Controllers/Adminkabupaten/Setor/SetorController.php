<?php

namespace App\Http\Controllers\AdminKabupaten\Setor;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $showAll = $request->input('show_all', false);
        $kecamatan = $request->input('kecamatan'); // Input filter kecamatan

        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Ambil daftar kecamatan untuk dropdown
        $kecamatans = Db_kecamatan::orderBy('nama_kecamatan', 'asc')->get();

        // Query dasar
        $query = Pengirimaninfaq::with('user')
            ->where('status', 'Terkirim')
            ->orderBy('id', 'asc');

        // Filter berdasarkan nama_kecamatan
        if ($kecamatan) {
            $query->where('nama_kecamatan', $kecamatan);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kecamatan', 'LIKE', "%{$search}%")
                    ->orWhere('namaPengirim', 'LIKE', "%{$search}%")
                    ->orWhere('namaPenerima', 'LIKE', "%{$search}%")
                    ->orWhere('no_hp', 'LIKE', "%{$search}%")
                    ->orWhere('tglKirim', 'LIKE', "%{$search}%")
                    ->orWhere('pesan', 'LIKE', "%{$search}%")
                    ->orWhere('file_kirim', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('username', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Grouping berdasarkan id_user dan indeks ulang koleksi
        $setor = $query->get()->groupBy('id_user')->map(function ($group) {
            return $group->first();
        })->values();

        // Paginate hasil grouping
        $setor = new LengthAwarePaginator(
            $setor->forPage($page, $entries),
            $setor->count(),
            $entries,
            $page,
            ['path' => route('admin_kabupaten.data-setor')]
        );

        // Tambahkan parameter ke pagination
        $setor->appends(['search' => $search, 'entries' => $entries, 'show_all' => $showAll, 'kecamatan' => $kecamatan]);

        // Ambil no_hp_admin dari session jika ada, fallback ke admin kecamatan
        $noHp = Session::get('no_hp_admin');
        if (!$noHp) {
            $adminKecamatan = User::where('role', 'admin_kecamatan')->first();
            $noHp = $adminKecamatan ? $adminKecamatan->no_hp : null;
        }

        // Hitung total donasi dari semua kecamatan (dari penerimaans)
        $total_donasi_kecamatan = Penerimaan::join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('penerimaans.status', 'Validasi')
            ->whereYear('penerimaans.tglSetor', $currentYear)
            ->whereMonth('penerimaans.tglSetor', $currentMonth)
            ->sum('penerimaans.nominal');

        return view('admin_kabupaten.setor.index', compact(
            'search',
            'entries',
            'setor',
            'showAll',
            'kecamatans',
            'kecamatan',
            'noHp',
            'total_donasi_kecamatan'
        ));
    }
}
