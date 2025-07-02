<?php

namespace App\Http\Controllers\Superadmin\Master\DataPetugas;

use App\Http\Controllers\Controller;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Wilayah\Db_kelurahan;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        // $filterKelurahan = $request->input('filter_kelurahan');

        // Query semua petugas dengan relasi kelurahans
        $query = Db_petugas::with('kelurahans')->orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_petugas', 'LIKE', "%{$search}%")
                    ->orWhereHas('kelurahans', function ($q2) use ($search) {
                        $q2->where('nama_kelurahan', 'LIKE', "%{$search}%");
                    });
            });
        }

        // // Filter berdasarkan kelurahan jika ada
        // if ($filterKelurahan) {
        //     $query->whereHas('kelurahans', function ($q) use ($filterKelurahan) {
        //         $q->where('db_kelurahans.id', $filterKelurahan);
        //     });
        // }

        // Paginasi dengan jumlah entri yang dipilih
        $petugas = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $petugas->appends(['search' => $search, 'entries' => $entries]);

        // $kelurahanList = Db_kelurahan::orderBy('nama_kelurahan')->get();

        return view('superadmin.master.data_petugas.index', compact('entries', 'page', 'search', 'petugas'));
    }

    public function tambahdata()
    {
        $kelurahan = Db_kelurahan::all();

        return view('superadmin.master.data_petugas.tambah', compact('kelurahan'));
    }

    public function tambah(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kelurahans' => 'required|array',
            'kelurahans.*.id_kelurahan' => 'required|exists:db_kelurahans,id',
            'kelurahans.*.RW' => 'nullable|string',
            'kelurahans.*.RT' => 'nullable|string',
        ]);

        // Buat petugas baru dan simpan instance model
        $petugas = Db_petugas::create([
            'nama_petugas' => $validated['nama_petugas'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Debugging (opsional, hapus setelah selesai)
        // dd($petugas);

        // Simpan relasi kelurahan dengan RW dan RT di tabel pivot
        foreach ($validated['kelurahans'] as $kelurahan) {
            $petugas->kelurahans()->attach($kelurahan['id_kelurahan'], [
                'RW' => $kelurahan['RW'],
                'RT' => $kelurahan['RT'],
            ]);
        }

        return redirect()->route('superadmin.master.dataPetugas')
            ->with('toast_success', 'Data berhasil ditambahkan');
    }

    public function editdata($id)
    {
        $petugas = Db_petugas::with('kelurahans')->findOrFail($id);

        // dd($petugas);

        $kelurahans = Db_kelurahan::orderBy('nama_kelurahan')->get();

        return view('superadmin.master.data_petugas.edit', compact('petugas', 'kelurahans'));
    }

    public function edit(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kelurahans' => 'required|array',
            'kelurahans.*.id_kelurahan' => 'required|exists:db_kelurahans,id',
            'kelurahans.*.RW' => 'nullable|string',
            'kelurahans.*.RT' => 'nullable|string',
        ]);

        // Ambil petugas berdasarkan ID
        $petugas = Db_petugas::findOrFail($id);

        // Update data petugas
        $petugas->update([
            'nama_petugas' => $validated['nama_petugas'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Sinkronkan relasi kelurahan dengan RW dan RT di tabel pivot
        $syncData = [];
        foreach ($validated['kelurahans'] as $kelurahan) {
            $syncData[$kelurahan['id_kelurahan']] = [
                'RW' => $kelurahan['RW'],
                'RT' => $kelurahan['RT'],
            ];
        }
        $petugas->kelurahans()->sync($syncData);

        return redirect()->route('superadmin.master.dataPetugas')
            ->with('toast_success', 'Data petugas berhasil diperbarui');
    }

    public function hapus($id)
    {
        Db_petugas::destroy($id);

        return redirect()->route('superadmin.master.dataPetugas')->with('toast_success', 'Data Berhasil dihapus');
    }
}
