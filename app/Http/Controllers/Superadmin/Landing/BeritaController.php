<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Berita::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('foto1', 'LIKE', "%{$search}%")
                    ->orWhere('motto1', 'LIKE', "%{$search}%")
                    ->orWhere('judul1', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('penulis', 'LIKE', "%{$search}%")
                    ->orWhere('tgl_berita', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $berita = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $berita->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.berita.index', compact('entries', 'search', 'berita'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Berita::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.berita.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $foto1 = null;
        $foto2 = null;

        if ($request->hasFile('foto1')) {
            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/berita/foto1', $originalName, 'public');
        }

        if ($request->hasFile('foto2')) {
            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/berita/foto2', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto1' => $foto1,
            'motto1' => $request->motto1,
            'judul1' => $request->judul1,
            'ringkasan1' => $request->ringkasan1,
            'penulis' => $request->penulis,
            'tgl_berita' => $request->tgl_berita,
            'foto2' => $foto2,
            'status' => $request->status,
        ];

        Berita::create($data);

        return redirect()->route('superadmin.landing.berita');
    }

    public function editdata($id)
    {
        $berita = Berita::findOrfail($id);

        return view('superadmin.landing.berita.edit', compact('berita'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $berita = Berita::findOrFail($id);

        $foto1 = $berita->foto1; // Simpan dulu icon1 lama
        $foto2 = $berita->foto2; // Simpan dulu icon1 lama

        if ($request->hasFile('foto1')) {
            // Hapus file foto1 lama jika ada (opsional)
            if ($foto1 && Storage::disk('public')->exists($foto1)) {
                Storage::disk('public')->delete($foto1);
            }

            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/berita/foto1', $originalName, 'public');
        } else {
            $foto1 = $berita->foto1;
        }

        if ($request->hasFile('foto2')) {
            // Hapus file foto2 lama jika ada (opsional)
            if ($foto2 && Storage::disk('public')->exists($foto2)) {
                Storage::disk('public')->delete($foto2);
            }

            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/berita/foto2', $originalName, 'public');
        } else {
            $foto2 = $berita->foto2;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto1' => $foto1,
            'motto1' => $request->motto1,
            'judul1' => $request->judul1,
            'ringkasan1' => $request->ringkasan1,
            'penulis' => $request->penulis,
            'tgl_berita' => $request->tgl_berita,
            'foto2' => $foto2,
            'status' => $request->status,
        ];

        $berita->update($data);

        return redirect()->route('superadmin.landing.berita');
    }

    public function hapus($id)
    {
        $data = Berita::findOrFail($id);

        // Hapus foto1 jika ada
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.berita');
    }
}
