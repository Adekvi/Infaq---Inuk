<?php

namespace App\Http\Controllers\Superadmin\Master\DataPenerimaan;

use App\Http\Controllers\Controller;
use App\Models\Master\Penerimaan\Dataterima;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataPenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        // $filterProvinsi = $request->input('filter_provinsi');

        // Query semua kabupaten
        $query = Dataterima::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_alat', 'LIKE', "%{$search}%")
                    ->orWhere('nama_donatur', 'LIKE', "%{$search}%")
                    ->orWhere('jenis', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%")
                    ->orWhere('nominal', 'LIKE', "%{$search}%")
                    ->orWhere('tgl', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $dataterima = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $dataterima->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.master.data_penerimaan.index', compact(
            'entries',
            'page',
            'search',
            'dataterima',
        ));
    }

    public function tambahdata()
    {
        return view('superadmin.master.data_penerimaan.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'no_alat' => ['nullable', 'unique:dataterimas,no_alat'],
        ]);

        $data = $request->only([
            'no_alat',
            'nama_donatur',
            'jenis',
            'alamat',
            'nominal',
            'tgl'
        ]);

        Dataterima::create($data);

        return redirect()->route('superadmin.master.penerimaan');
    }


    public function editdata($id)
    {
        $dataterima = Dataterima::findOrFail($id);

        return view('superadmin.master.data_penerimaan.edit', compact('dataterima'));
    }

    public function edit(Request $request, $id)
    {
        $dataterima = Dataterima::findOrFail($id);

        $request->validate([
            'no_alat' => [
                'nullable',
                Rule::unique('dataterimas', 'no_alat')->ignore($dataterima->id),
            ],
        ]);

        $data = $request->only([
            'no_alat',
            'nama_donatur',
            'jenis',
            'alamat',
            'nominal',
            'tgl'
        ]);

        // dd($data);

        $dataterima->update($data);

        return redirect()->route('superadmin.master.penerimaan');
    }

    public function hapus($id)
    {
        Dataterima::destroy($id);

        return redirect()->route('superadmin.master.penerimaan');
    }
}
