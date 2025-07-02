<?php

namespace App\Http\Controllers\Superadmin\Master\DataWilayah;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        $filterKecamatan = $request->input('filter_kecamatan');

        // Query semua kabupaten
        $query = Db_kelurahan::with('kecamatan')->orderBy('id', 'asc');
        // dd($query);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kelurahan', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('kecamatan', function ($q2) use ($search) {
                        $q2->where('nama_kecamatan', 'LIKE', "%{$search}%");
                    });
            });
        }
        // Filter berdasarkan kabupaten jika ada
        if ($filterKecamatan) {
            $query->where('id_kecamatan', $filterKecamatan);
        }

        $kelurahan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $kelurahan->appends(['search' => $search, 'entries' => $entries, 'filter_kecamatan' => $filterKecamatan]);

        // Ambil semua kecamatan untuk dropdown filter
        $kecamatanList = Db_kecamatan::orderBy('nama_kecamatan')->get();

        return view('superadmin.master.data_wilayah.desa.index', compact(
            'entries',
            'page',
            'search',
            'filterKecamatan',
            'kelurahan',
            'kecamatanList'
        ));
    }

    public function tambahdata()
    {
        $kecamatan = Db_kecamatan::all();

        return view('superadmin.master.data_wilayah.desa.tambah', compact('kecamatan'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'id_kecamatan' => 'required',
            'nama_kelurahan' => 'required'
        ]);

        $data = [
            'id_kecamatan' => $request->id_kecamatan,
            'nama_kelurahan' => $request->nama_kelurahan,
            'RW' => $request->RW,
            'RT' => $request->RT,
        ];

        Db_kelurahan::create($data);

        return redirect()->route('superadmin.master.kelurahan')->with('toast_success', 'Data Berhasil ditambahkan');
    }

    public function editdata($id)
    {
        $kelurahan = Db_kelurahan::with('kecamatan')->findOrFail($id);
        $kecamatan = Db_kecamatan::all();

        $pilihKec = optional($kelurahan->kecamatan)->id ?? $kelurahan->id;

        return view('superadmin.master.data_wilayah.desa.edit', compact('kelurahan', 'kecamatan', 'pilihKec'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'id_kecamatan' => 'required',
            'nama_kelurahan' => 'required'
        ]);

        $data = [
            'id_kecamatan' => $request->id_kecamatan,
            'nama_kelurahan' => $request->nama_kelurahan,
            'RW' => $request->RW,
            'RT' => $request->RT,
        ];

        Db_kelurahan::findOrFail($id)->update($data);

        return redirect()->route('superadmin.master.kelurahan')->with('toast_success', 'Data Berhasil diubah');
    }

    public function hapus($id)
    {
        Db_kelurahan::destroy($id);

        return redirect()->route('superadmin.master.kelurahan')->with('toast_success', 'Data Berhasil dihapus');
    }
}
