<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangkamiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Tentang::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                    ->orWhere('subjudul', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('motto1', 'LIKE', "%{$search}%")
                    ->orWhere('motto2', 'LIKE', "%{$search}%")
                    ->orWhere('subjudul1', 'LIKE', "%{$search}%")
                    ->orWhere('foto', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan1', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan2', 'LIKE', "%{$search}%");
            });
        }

        $tentang = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $tentang->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.tentang.index', compact('entries', 'search', 'tentang'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Tentang::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.tentang.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'icon1' => 'nullable|image|max:2048',
            'icon2' => 'nullable|image|max:2048',
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $icon1 = null;
        $icon2 = null;
        $foto = null;

        if ($request->hasFile('icon1')) {
            $originalName = $request->file('icon1')->getClientOriginalName();
            $icon1 = $request->file('icon1')->storeAs('landing/tentang/icon1', $originalName, 'public');
        }
        if ($request->hasFile('icon2')) {
            $originalName = $request->file('icon2')->getClientOriginalName();
            $icon2 = $request->file('icon2')->storeAs('landing/tentang/icon2', $originalName, 'public');
        }
        if ($request->hasFile('foto')) {
            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/tentang/foto', $originalName, 'public');
        }

        $data = [
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'ringkasan' => $request->ringkasan,
            'motto1' => $request->motto1,
            'icon1' => $icon1,
            'ringkasan1' => $request->ringkasan1,
            'motto2' => $request->motto2,
            'icon2' => $icon2,
            'ringkasan2' => $request->ringkasan2,
            'subjudul1' => $request->subjudul1,
            'no_hp' => $request->no_hp,
            'foto' => $foto,
            'status' => $request->status,
        ];

        Tentang::create($data);

        return redirect()->route('superadmin.landing.tentang');
    }

    public function editdata($id)
    {
        $tentang = Tentang::findOrfail($id);

        return view('superadmin.landing.tentang.edit', compact('tentang'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'icon1' => 'nullable|image|max:2048',
            'icon2' => 'nullable|image|max:2048',
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $tentang = Tentang::findOrFail($id);

        $icon1 = $tentang->icon1; // Simpan dulu icon1 lama
        $icon2 = $tentang->icon2; // Simpan dulu icon1 lama
        $foto = $tentang->foto; // Simpan dulu icon1 lama

        if ($request->hasFile('icon1')) {
            // Hapus file icon1 lama jika ada (opsional)
            if ($icon1 && Storage::disk('public')->exists($icon1)) {
                Storage::disk('public')->delete($icon1);
            }

            $originalName = $request->file('icon1')->getClientOriginalName();
            $icon1 = $request->file('icon1')->storeAs('landing/struktur/tentang/icon1', $originalName, 'public');
        } else {
            $icon1 = $tentang->icon1;
        }

        if ($request->hasFile('icon2')) {
            // Hapus file icon2 lama jika ada (opsional)
            if ($icon2 && Storage::disk('public')->exists($icon2)) {
                Storage::disk('public')->delete($icon2);
            }

            $originalName = $request->file('icon2')->getClientOriginalName();
            $icon2 = $request->file('icon2')->storeAs('landing/tentang/icon2', $originalName, 'public');
        } else {
            $icon2 = $tentang->icon2;
        }

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada (opsional)
            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/tentang/foto', $originalName, 'public');
        } else {
            $foto = $tentang->foto;
        }

        $data = [
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'ringkasan' => $request->ringkasan,
            'motto1' => $request->motto1,
            'icon1' => $icon1,
            'ringkasan1' => $request->ringkasan1,
            'motto2' => $request->motto2,
            'icon2' => $icon2,
            'ringkasan2' => $request->ringkasan2,
            'subjudul1' => $request->subjudul1,
            'no_hp' => $request->no_hp,
            'foto' => $foto,
            'status' => $request->status,
        ];

        $tentang->update($data);

        return redirect()->route('superadmin.landing.tentang');
    }

    public function hapus($id)
    {
        Tentang::destroy($id);

        return redirect()->route('superadmin.landing.tentang');
    }
}
