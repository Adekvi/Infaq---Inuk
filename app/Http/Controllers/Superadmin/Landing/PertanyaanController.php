<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Pertanyaan::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$search}%")
                    ->orWhere('foto', 'LIKE', "%{$search}%")
                    ->orWhere('pertanyaan1', 'LIKE', "%{$search}%")
                    ->orWhere('jawaban1', 'LIKE', "%{$search}%")
                    ->orWhere('pertanyaan2', 'LIKE', "%{$search}%")
                    ->orWhere('jawaban2', 'LIKE', "%{$search}%")
                    ->orWhere('pertanyaan3', 'LIKE', "%{$search}%")
                    ->orWhere('jawaban3', 'LIKE', "%{$search}%")
                    ->orWhere('pertanyaan4', 'LIKE', "%{$search}%")
                    ->orWhere('jawaban4', 'LIKE', "%{$search}%")
                    ->orWhere('pertanyaan5', 'LIKE', "%{$search}%")
                    ->orWhere('jawaban5', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $tanya = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $tanya->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.tanya.index', compact('entries', 'search', 'tanya'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Pertanyaan::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.tanya.tambah');
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
            $foto = $request->file('foto')->storeAs('landing/tanya/foto', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'pertanyaan1' => $request->pertanyaan1,
            'jawaban1' => $request->jawaban1,
            'pertanyaan2' => $request->pertanyaan2,
            'jawaban2' => $request->jawaban2,
            'pertanyaan3' => $request->pertanyaan3,
            'jawaban3' => $request->jawaban3,
            'pertanyaan4' => $request->pertanyaan4,
            'jawaban4' => $request->jawaban4,
            'pertanyaan5' => $request->pertanyaan5,
            'jawaban5' => $request->jawaban5,
            'foto' => $foto,
            'status' => $request->status,
        ];

        Pertanyaan::create($data);

        return redirect()->route('superadmin.landing.tanya');
    }

    public function editdata($id)
    {
        $tanya = Pertanyaan::findOrfail($id);

        return view('superadmin.landing.tanya.edit', compact('tanya'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $tanya = Pertanyaan::findOrFail($id);

        $foto = $tanya->foto; // Simpan dulu icon1 lama

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada (opsional)
            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $originalName = $request->file('foto')->getClientOriginalName();
            $foto = $request->file('foto')->storeAs('landing/tanya/foto', $originalName, 'public');
        } else {
            $foto = $tanya->foto;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'pertanyaan1' => $request->pertanyaan1,
            'jawaban1' => $request->jawaban1,
            'pertanyaan2' => $request->pertanyaan2,
            'jawaban2' => $request->jawaban2,
            'pertanyaan3' => $request->pertanyaan3,
            'jawaban3' => $request->jawaban3,
            'pertanyaan4' => $request->pertanyaan4,
            'jawaban4' => $request->jawaban4,
            'pertanyaan5' => $request->pertanyaan5,
            'jawaban5' => $request->jawaban5,
            'foto' => $foto,
            'status' => $request->status,
        ];

        $tanya->update($data);

        return redirect()->route('superadmin.landing.tanya');
    }

    public function hapus($id)
    {
        $data = Pertanyaan::findOrFail($id);

        // Hapus foto1 jika ada
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('superadmin.landing.tanya');
    }
}
