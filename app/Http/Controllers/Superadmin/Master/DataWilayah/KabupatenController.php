<?php

namespace App\Http\Controllers\Superadmin\Master\DataWilayah;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kabupaten;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        // $filterProvinsi = $request->input('filter_provinsi');

        // Query semua kabupaten
        $query = Db_kabupaten::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kabupaten', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $kabupaten = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $kabupaten->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.master.data_wilayah.kabupaten.index', compact(
            'entries',
            'page',
            'search',
            'kabupaten',
        ));
    }

    public function tambahdata()
    {
        return view('superadmin.master.data_wilayah.kabupaten.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required'
        ]);

        $data = [
            'nama_kabupaten' => $request->nama_kabupaten
        ];

        Db_kabupaten::create($data);

        return redirect()->route('superadmin.master.kabupaten')->with('toast_success', 'Data Berhasil ditambahkan');
    }

    public function editdata($id)
    {
        $kabupaten = Db_kabupaten::findOrFail($id);

        return view('superadmin.master.data_wilayah.kabupaten.edit', compact('kabupaten'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_kabupaten' => 'required'
        ]);

        $data = [
            'nama_kabupaten' => $request->nama_kabupaten
        ];

        Db_kabupaten::findOrFail($id)->update($data);

        return redirect()->route('superadmin.master.kabupaten')->with('toast_success', 'Data Berhasil diubah');
    }

    public function hapus($id)
    {
        Db_kabupaten::destroy($id);

        return redirect()->route('superadmin.master.kabupaten')->with('toast_success', 'Data Berhasil dihapus');
    }
}
