<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Halaman1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Halaman1Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Halaman1::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul1', 'LIKE', "%{$search}%")
                    ->orWhere('kalimat1', 'LIKE', "%{$search}%")
                    ->orWhere('ringkas1', 'LIKE', "%{$search}%")
                    ->orWhere('foto1', 'LIKE', "%{$search}%")
                    ->orWhere('judul2', 'LIKE', "%{$search}%")
                    ->orWhere('kalimat2', 'LIKE', "%{$search}%")
                    ->orWhere('ringkas2', 'LIKE', "%{$search}%")
                    ->orWhere('foto2', 'LIKE', "%{$search}%");
            });
        }

        $halaman1 = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $halaman1->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.landing.navbar.index', compact('halaman1', 'search', 'entries'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Halaman1::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.navbar.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048', // dalam kilobyte
            'foto2' => 'nullable|image|max:2048',
        ]);

        $foto1 = null;
        $foto2 = null;

        if ($request->hasFile('foto1')) {
            $originalName1 = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/navbar/foto1', $originalName1, 'public');
        }

        if ($request->hasFile('foto2')) {
            $originalName2 = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/navbar/foto2', $originalName2, 'public');
        }

        $data = [
            'judul1' => $request->judul1,
            'kalimat1' => $request->kalimat1,
            'ringkas1' => $request->ringkas1,
            'foto1' => $foto1,
            'judul2' => $request->judul2,
            'kalimat2' => $request->kalimat2,
            'ringkas2' => $request->ringkas2,
            'foto2' => $foto2,
            'status' => $request->status,
        ];

        Halaman1::create($data);

        return redirect()->route('superadmin.landing.halaman1');
    }

    public function editdata($id)
    {
        $data = Halaman1::findOrFail($id);
        return view('superadmin.landing.navbar.edit', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto1' => 'nullable|image|max:2048', // dalam kilobyte
            'foto2' => 'nullable|image|max:2048',
        ]);

        $data = Halaman1::findOrFail($id);

        // Handle foto1
        if ($request->hasFile('foto1')) {
            if ($data->foto1 && Storage::disk('public')->exists($data->foto1)) {
                Storage::disk('public')->delete($data->foto1);
            }
            $originalName1 = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/navbar/foto1', $originalName1, 'public');
        } else {
            $foto1 = $data->foto1;
        }

        // Handle foto2
        if ($request->hasFile('foto2')) {
            if ($data->foto2 && Storage::disk('public')->exists($data->foto2)) {
                Storage::disk('public')->delete($data->foto2);
            }
            $originalName2 = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/navbar/foto2', $originalName2, 'public');
        } else {
            $foto2 = $data->foto2;
        }

        // Update data
        $data->update([
            'judul1' => $request->judul1,
            'kalimat1' => $request->kalimat1,
            'ringkas1' => $request->ringkas1,
            'foto1' => $foto1,
            'judul2' => $request->judul2,
            'kalimat2' => $request->kalimat2,
            'ringkas2' => $request->ringkas2,
            'foto2' => $foto2,
            'status' => $request->status,
        ]);

        return redirect()->route('superadmin.landing.halaman1')->with('success', 'Data berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $data = Halaman1::findOrFail($id);

        // Hapus foto1 jika ada
        if ($data->foto1 && Storage::disk('public')->exists($data->foto1)) {
            Storage::disk('public')->delete($data->foto1);
        }

        // Hapus foto2 jika ada
        if ($data->foto2 && Storage::disk('public')->exists($data->foto2)) {
            Storage::disk('public')->delete($data->foto2);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.halaman1')->with('success', 'Data dan foto berhasil dihapus.');
    }
}
