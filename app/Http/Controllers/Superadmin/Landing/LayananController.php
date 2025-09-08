<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Layanan::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                    ->orWhere('foto', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $layanan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $layanan->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.layanan.index', compact('entries', 'search', 'layanan'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Layanan::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.layanan.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/layanan/foto', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => $request->status,
        ];

        Layanan::create($data);

        return redirect()->route('superadmin.landing.layanan');
    }

    public function editdata($id)
    {
        $layanan = Layanan::findOrfail($id);

        return view('superadmin.landing.layanan.edit', compact('layanan'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $layanan = Layanan::findOrFail($id);

        $foto = $layanan->foto; // Simpan dulu icon1 lama

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada (opsional)
            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/layanan/foto', $originalName, 'public');
        } else {
            $foto = $layanan->foto;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => $request->status,
        ];

        $layanan->update($data);

        return redirect()->route('superadmin.landing.layanan');
    }

    public function hapus($id)
    {
        $data = Layanan::findOrFail($id);

        // Hapus foto1 jika ada
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.layanan');
    }
}
