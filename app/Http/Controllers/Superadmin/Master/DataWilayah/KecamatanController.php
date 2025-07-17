<?php

namespace App\Http\Controllers\Superadmin\Master\DataWilayah;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kabupaten;
use App\Models\Master\Wilayah\Db_kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        $filterKabupaten = $request->input('filter_kabupaten');

        // Query semua kabupaten
        $query = Db_kecamatan::with('kabupaten')->orderBy('id', 'asc');
        // dd($query);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kecamatan', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhereHas('kabupaten', function ($q2) use ($search) {
                        $q2->where('nama_kabupaten', 'LIKE', "%{$search}%");
                    });
            });
        }
        // Filter berdasarkan kabupaten jika ada
        if ($filterKabupaten) {
            $query->where('id_kabupaten', $filterKabupaten);
        }

        $kecamatan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $kecamatan->appends(['search' => $search, 'entries' => $entries, 'filter_kabupaten' => $filterKabupaten]);

        // Ambil semua kabupaten untuk dropdown filter
        $kabupatenList = Db_kabupaten::orderBy('nama_kabupaten')->get();

        return view('superadmin.master.data_wilayah.kecamatan.index', compact(
            'entries',
            'page',
            'search',
            'filterKabupaten',
            'kecamatan',
            'kabupatenList'
        ));
    }

    public function tambahdata()
    {
        $kabupaten = Db_kabupaten::all();

        return view('superadmin.master.data_wilayah.kecamatan.tambah', compact('kabupaten'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'id_kabupaten' => 'required',
            'nama_kecamatan' => 'required'
        ]);

        $data = [
            'id_kabupaten' => $request->id_kabupaten,
            'nama_kecamatan' => $request->nama_kecamatan,
            'status' => $request->status,
        ];

        Db_kecamatan::create($data);

        return redirect()->route('superadmin.master.kecamatan')->with('toast_success', 'Data Berhasil ditambahkan');
    }

    public function editdata($id)
    {
        $kecamatan = Db_kecamatan::with('kabupaten')->findOrFail($id);
        $kabupaten = Db_kabupaten::all();

        $pilihKab = optional($kecamatan->kabupaten)->id ?? $kecamatan->id;

        return view('superadmin.master.data_wilayah.kecamatan.edit', compact('kecamatan', 'kabupaten', 'pilihKab'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'id_kabupaten' => 'required',
            'nama_kecamatan' => 'required'
        ]);

        $data = [
            'id_kabupaten' => $request->id_kabupaten,
            'nama_kecamatan' => $request->nama_kecamatan,
            'status' => $request->status,
        ];

        Db_kecamatan::findOrFail($id)->update($data);

        return redirect()->route('superadmin.master.kecamatan')->with('toast_success', 'Data Berhasil diubah');
    }

    public function hapus($id)
    {
        Db_kecamatan::destroy($id);

        return redirect()->route('superadmin.master.kecamatan')->with('toast_success', 'Data Berhasil dihapus');
    }
}
