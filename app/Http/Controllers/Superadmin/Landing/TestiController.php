<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Testimoni::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('foto', 'LIKE', "%{$search}%")
                    ->orWhere('nama', 'LIKE', "%{$search}%")
                    ->orWhere('jenis', 'LIKE', "%{$search}%")
                    ->orWhere('testi', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $testi = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $testi->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.testi.index', compact('entries', 'search', 'testi'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Testimoni::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.testi.tambah');
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
            $foto = $request->file('foto')->storeAs('landing/testi/foto', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto' => $foto,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'testi' => $request->testi,
            'status' => $request->status,
        ];

        Testimoni::create($data);

        return redirect()->route('superadmin.landing.testi');
    }

    public function editdata($id)
    {
        $testi = Testimoni::findOrfail($id);

        return view('superadmin.landing.testi.edit', compact('testi'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $testi = Testimoni::findOrFail($id);

        $foto = $testi->foto; // Simpan dulu icon1 lama

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada (opsional)
            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/testi/foto', $originalName, 'public');
        } else {
            $foto = $testi->foto;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto' => $foto,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'testi' => $request->testi,
            'status' => $request->status,
        ];

        $testi->update($data);

        return redirect()->route('superadmin.landing.testi');
    }

    public function hapus($id)
    {
        $data = Testimoni::findOrFail($id);

        // Hapus foto1 jika ada
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.testi');
    }
}
