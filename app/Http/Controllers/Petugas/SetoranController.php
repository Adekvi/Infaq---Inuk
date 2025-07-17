<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\db_kelurahan_petugas;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Role\Petugas\Db_setorinfaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $id_kecamatan = $request->input('id_kecamatan');
        $id_kelurahan = $request->input('id_kelurahan');

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->with(['kecamatan', 'kelurahan'])
            ->get();

        // Ambil daftar kecamatan dan kelurahan yang terkait dengan wilayah tugas
        $kecamatans = $wilayahTugas->pluck('kecamatan')->unique('id');
        $kelurahans = $wilayahTugas->pluck('kelurahan')->unique('id');

        // Daftar bulan untuk tampilan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // Query dasar untuk Db_setorinfaq, hanya untuk petugas yang login dan status 'S'
        $query = Db_setorinfaq::where('id_user', Auth::user()->id)
            ->where('status', 'S')
            ->with(['user', 'petugas.wilayahTugas.kecamatan', 'petugas.wilayahTugas.kelurahan', 'kecamatan', 'kelurahan']);

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('jenis_infaq', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('total', 'LIKE', "%{$search}%")
                    ->orWhere('keterangan', 'LIKE', "%{$search}%")
                    ->orWhereHas('petugas', function ($q2) use ($search) {
                        $q2->where('nama_petugas', 'LIKE', "%{$search}%")
                            ->orWhereHas('user', function ($q3) use ($search) {
                                $q3->where('username', 'LIKE', "%{$search}%");
                            });
                    });
            });
        }

        // Filter berdasarkan kecamatan dan kelurahan
        if ($id_kecamatan || $id_kelurahan) {
            $query->whereHas('petugas.wilayahTugas', function ($q2) use ($id_kecamatan, $id_kelurahan, $petugas) {
                $q2->where('id_petugas', $petugas->id);
                if ($id_kecamatan) {
                    $q2->where('id_kecamatan', $id_kecamatan);
                }
                if ($id_kelurahan) {
                    $q2->where('id_kelurahan', $id_kelurahan);
                }
            });
        }

        // Ambil data dengan paginasi
        $infaq = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $infaq->appends(['search' => $search, 'entries' => $entries, 'id_kecamatan' => $id_kecamatan, 'id_kelurahan' => $id_kelurahan]);

        // dd($infaq);

        return view('petugas.setoran.infaq', compact('infaq', 'search', 'entries', 'kecamatans', 'kelurahans', 'id_kecamatan', 'id_kelurahan', 'petugas', 'months'));
    }

    public function getKelurahanByWilayahTugas(Request $request)
    {
        $request->validate([
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_petugas' => 'required|exists:db_petugas,id',
        ]);

        $kelurahans = db_kelurahan_petugas::where('id_petugas', $request->id_petugas)
            ->where('id_kecamatan', $request->id_kecamatan)
            ->with('kelurahan')
            ->get()
            ->pluck('kelurahan')
            ->unique('id');

        return response()->json($kelurahans);
    }

    public function tampiltambah()
    {
        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->with(['kecamatan', 'kelurahan'])
            ->get();

        // Ambil daftar kecamatan dan kelurahan yang terkait dengan wilayah tugas
        $kecamatans = $wilayahTugas->pluck('kecamatan')->unique('id');
        $kelurahans = $wilayahTugas->pluck('kelurahan')->unique('id');

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('petugas.setoran.tambah', compact('petugas', 'kecamatans', 'kelurahans', 'wilayahTugas', 'months'));
    }

    public function tambah(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_kelurahan' => 'required|exists:db_kelurahans,id',
            'tgl_infaq' => 'nullable|date',
            'bulan' => 'required|integer|between:1,12',
            'minggu1' => 'nullable|integer|min:0',
            'minggu2' => 'nullable|integer|min:0',
            'minggu3' => 'nullable|integer|min:0',
            'minggu4' => 'nullable|integer|min:0',
            'jumlah' => 'required|integer|min:0',
            'jenis_infaq' => 'required|string|in:Infaq Individu,Infaq Lembaga,Kotak Infaq',
            'keterangan' => 'nullable|string|max:500',
            // 'status' => 'nullable|string|in:S,P',
        ]);

        // Verifikasi bahwa jumlah sesuai dengan total minggu1 sampai minggu4
        $totalMinggu = ($request->minggu1 ?? 0) + ($request->minggu2 ?? 0) + ($request->minggu3 ?? 0) + ($request->minggu4 ?? 0);
        if ($request->jumlah != $totalMinggu) {
            return redirect()->back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total minggu.']);
        }

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Verifikasi bahwa id_kecamatan dan id_kelurahan ada di wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->where('id_kecamatan', $request->id_kecamatan)
            ->where('id_kelurahan', $request->id_kelurahan)
            ->exists();

        if (!$wilayahTugas) {
            return redirect()->back()->withErrors(['id_kelurahan' => 'Kecamatan atau kelurahan tidak termasuk dalam wilayah tugas Anda.']);
        }

        // Simpan data setoran
        Db_setorinfaq::create([
            'id_user' => Auth::user()->id,
            'id_petugas' => $petugas->id,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'tgl_infaq' => \Carbon\Carbon::now(),
            // 'tgl_infaq' => $request->tgl_infaq,
            'bulan' => $request->bulan,
            'minggu1' => $request->minggu1,
            'minggu2' => $request->minggu2,
            'minggu3' => $request->minggu3,
            'minggu4' => $request->minggu4,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah, // Total sama dengan jumlah
            'jenis_infaq' => $request->jenis_infaq,
            'keterangan' => $request->keterangan,
            'status' => 'S', // Default ke 'P' jika tidak diisi
        ]);

        return redirect()->route('petugas.input.infaq')->with('success', 'Data infaq berhasil disimpan.');
    }

    public function tampiledit($id)
    {
        // Ambil data setoran berdasarkan ID dan user yang login
        $infaq = Db_setorinfaq::where('id', $id)
            ->where('id_user', Auth::user()->id)
            ->with(['kecamatan', 'kelurahan'])
            ->firstOrFail();

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->with(['kecamatan', 'kelurahan'])
            ->get();

        // Ambil daftar kecamatan dan kelurahan yang terkait dengan wilayah tugas
        $kecamatans = $wilayahTugas->pluck('kecamatan')->unique('id');
        $kelurahans = $wilayahTugas->pluck('kelurahan')->unique('id');

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('petugas.setoran.edit', compact('infaq', 'petugas', 'kecamatans', 'kelurahans', 'wilayahTugas', 'months'));
    }

    public function edit(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_kelurahan' => 'required|exists:db_kelurahans,id',
            'tgl_infaq' => 'nullable|date',
            'bulan' => 'required|integer|between:1,12',
            'minggu1' => 'nullable|integer|min:0',
            'minggu2' => 'nullable|integer|min:0',
            'minggu3' => 'nullable|integer|min:0',
            'minggu4' => 'nullable|integer|min:0',
            'jumlah' => 'required|integer|min:0',
            'jenis_infaq' => 'required|string|in:Infaq Individu,Infaq Lembaga,Kotak Infaq',
            'keterangan' => 'nullable|string|max:500',
            // 'status' => 'nullable|string|in:S,P',
        ]);

        // Verifikasi bahwa jumlah sesuai dengan total minggu1 sampai minggu4
        $totalMinggu = ($request->minggu1 ?? 0) + ($request->minggu2 ?? 0) + ($request->minggu3 ?? 0) + ($request->minggu4 ?? 0);
        if ($request->jumlah != $totalMinggu) {
            return redirect()->back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total minggu.']);
        }

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Verifikasi bahwa id_kecamatan dan id_kelurahan ada di wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->where('id_kecamatan', $request->id_kecamatan)
            ->where('id_kelurahan', $request->id_kelurahan)
            ->exists();

        if (!$wilayahTugas) {
            return redirect()->back()->withErrors(['id_kelurahan' => 'Kecamatan atau kelurahan tidak termasuk dalam wilayah tugas Anda.']);
        }

        // Ambil data setoran
        $infaq = Db_setorinfaq::where('id', $id)
            ->where('id_petugas', $petugas->id)
            ->firstOrFail();

        // Update data setoran
        $infaq->update([
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'tgl_infaq' => \Carbon\Carbon::now(),
            'bulan' => $request->bulan,
            'minggu1' => $request->minggu1,
            'minggu2' => $request->minggu2,
            'minggu3' => $request->minggu3,
            'minggu4' => $request->minggu4,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah,
            'jenis_infaq' => $request->jenis_infaq,
            'keterangan' => $request->keterangan,
            'status' => 'S',
        ]);

        return redirect()->route('petugas.input.infaq')->with('success', 'Data infaq berhasil diperbarui.');
    }

    public function hapus($id)
    {
        Db_setorinfaq::destroy($id);

        return redirect()->route('petugas.input.infaq')->with('success', 'Data Berhasil dihapus');
    }
}
