<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Keunggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeunggulanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Keunggulan::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                    ->orWhere('kalimat', 'LIKE', "%{$search}%")
                    ->orWhere('motto', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $keunggulan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $keunggulan->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.keunggulan.index', compact('entries', 'search', 'keunggulan'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Keunggulan::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.keunggulan.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'foto4' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $foto1 = null;
        $foto2 = null;
        $foto3 = null;
        $foto4 = null;

        if ($request->hasFile('foto1')) {
            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        }

        if ($request->hasFile('foto2')) {
            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        }

        if ($request->hasFile('foto3')) {
            $originalName = $request->file('foto3')->getClientOriginalName();
            $foto3 = $request->file('foto3')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        }

        if ($request->hasFile('foto4')) {
            $originalName = $request->file('foto4')->getClientOriginalName();
            $foto4 = $request->file('foto4')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'motto1' => $request->motto1,
            'kalimat1' => $request->kalimat1,
            'ringkasan1' => $request->ringkasan1,
            'foto1' => $foto1,
            'motto2' => $request->motto2,
            'kalimat2' => $request->kalimat2,
            'ringkasan2' => $request->ringkasan2,
            'foto2' => $foto2,
            'motto3' => $request->motto3,
            'kalimat3' => $request->kalimat3,
            'ringkasan3' => $request->ringkasan3,
            'foto3' => $foto3,
            'motto4' => $request->motto4,
            'kalimat4' => $request->kalimat4,
            'ringkasan4' => $request->ringkasan4,
            'foto4' => $foto4,
            'status' => $request->status,
        ];

        Keunggulan::create($data);

        return redirect()->route('superadmin.landing.keunggulan');
    }

    public function editdata($id)
    {
        $keunggulan = Keunggulan::findOrfail($id);

        return view('superadmin.landing.keunggulan.edit', compact('keunggulan'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'foto4' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $keunggulan = Keunggulan::findOrFail($id);

        $foto1 = $keunggulan->foto1; // Simpan dulu icon1 lama
        $foto2 = $keunggulan->foto2; // Simpan dulu icon1 lama
        $foto3 = $keunggulan->foto3; // Simpan dulu icon1 lama
        $foto4 = $keunggulan->foto4; // Simpan dulu icon1 lama

        if ($request->hasFile('foto1')) {
            // Hapus file foto1 lama jika ada (opsional)
            if ($foto1 && Storage::disk('public')->exists($foto1)) {
                Storage::disk('public')->delete($foto1);
            }

            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        } else {
            $foto1 = $keunggulan->foto1;
        }

        if ($request->hasFile('foto2')) {
            // Hapus file foto2 lama jika ada (opsional)
            if ($foto2 && Storage::disk('public')->exists($foto2)) {
                Storage::disk('public')->delete($foto2);
            }

            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        } else {
            $foto2 = $keunggulan->foto2;
        }

        if ($request->hasFile('foto3')) {
            // Hapus file foto3 lama jika ada (opsional)
            if ($foto3 && Storage::disk('public')->exists($foto3)) {
                Storage::disk('public')->delete($foto3);
            }

            $originalName = $request->file('foto3')->getClientOriginalName();
            $foto3 = $request->file('foto3')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        } else {
            $foto3 = $keunggulan->foto3;
        }

        if ($request->hasFile('foto4')) {
            // Hapus file foto4 lama jika ada (opsional)
            if ($foto4 && Storage::disk('public')->exists($foto4)) {
                Storage::disk('public')->delete($foto4);
            }

            $originalName = $request->file('foto4')->getClientOriginalName();
            $foto4 = $request->file('foto4')->storeAs('landing/keunggulan/foto', $originalName, 'public');
        } else {
            $foto4 = $keunggulan->foto4;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kalimat1' => $request->kalimat1,
            'motto1' => $request->motto1,
            'ringkasan1' => $request->ringkasan1,
            'foto1' => $foto1,
            'kalimat2' => $request->kalimat2,
            'motto2' => $request->motto2,
            'ringkasan2' => $request->ringkasan2,
            'foto2' => $foto2,
            'kalimat3' => $request->kalimat3,
            'motto3' => $request->motto3,
            'ringkasan3' => $request->ringkasan3,
            'foto3' => $foto3,
            'kalimat4' => $request->kalimat4,
            'motto4' => $request->motto4,
            'ringkasan4' => $request->ringkasan4,
            'foto4' => $foto4,
            'status' => $request->status,
        ];

        $keunggulan->update($data);

        return redirect()->route('superadmin.landing.keunggulan');
    }

    public function hapus($id)
    {
        $data = Keunggulan::findOrFail($id);

        // Hapus foto jika ada
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.keunggulan');
    }
}
