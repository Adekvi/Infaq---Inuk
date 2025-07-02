<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatadiriController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya petugas yang bisa akses
        $this->middleware('role:petugas');
    }

    public function create()
    {
        // Ambil data kecamatan untuk dropdown
        $kecamatans = Db_kecamatan::all();
        return view('petugas.identitas.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat' => 'required|string|max:255',
            'tgllahir' => 'required|date',
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_kelurahan' => 'required|exists:db_kelurahans,id',
            'Rw' => 'required|string|max:10',
            'Rt' => 'required|string|max:10',
            'alamat' => 'required|string|max:255',
        ]);

        // Simpan data identitas
        Datadiri::create([
            'id_user' => Auth::user()->id,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat' => $request->tempat,
            'tgllahir' => $request->tgllahir,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'Rw' => $request->Rw,
            'Rt' => $request->Rt,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('petugas.dashboard')->with('success', 'Data identitas berhasil disimpan.');
    }

    public function getKelurahan(Request $request)
    {
        $kelurahans = Db_kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();
        return response()->json($kelurahans);
    }
}
