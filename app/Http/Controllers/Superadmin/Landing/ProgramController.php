<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Program::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                    ->orWhere('tag', 'LIKE', "%{$search}%")
                    ->orWhere('judul', 'LIKE', "%{$search}%")
                    ->orWhere('program1', 'LIKE', "%{$search}%")
                    ->orWhere('foto1', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan1', 'LIKE', "%{$search}%")
                    ->orWhere('program2', 'LIKE', "%{$search}%")
                    ->orWhere('foto2', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan2', 'LIKE', "%{$search}%")
                    ->orWhere('program3', 'LIKE', "%{$search}%")
                    ->orWhere('foto3', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan3', 'LIKE', "%{$search}%")
                    ->orWhere('program4', 'LIKE', "%{$search}%")
                    ->orWhere('foto4', 'LIKE', "%{$search}%")
                    ->orWhere('ringkasan4', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $program = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $program->appends([
            'search' => $search,
            'entries' => $entries,
        ]);

        return view('superadmin.landing.program.index', compact('search', 'entries', 'program'));
    }

    public function updateStatus(Request $request)
    {
        $halamanId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $halaman = Program::findOrFail($halamanId);
        $halaman->status = $newStatus;
        $halaman->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        return view('superadmin.landing.program.tambah');
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

        if ($request->hasFile('31')) {
            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/program/foto1', $originalName, 'public');
        }
        if ($request->hasFile('foto2')) {
            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/program/foto2', $originalName, 'public');
        }
        if ($request->hasFile('foto3')) {
            $originalName = $request->file('foto3')->getClientOriginalName();
            $foto3 = $request->file('foto3')->storeAs('landing/program/foto3', $originalName, 'public');
        }
        if ($request->hasFile('foto4')) {
            $originalName = $request->file('foto4')->getClientOriginalName();
            $foto4 = $request->file('foto4')->storeAs('landing/program/foto4', $originalName, 'public');
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto1' => $foto1,
            'program1' => $request->program1,
            'ringkasan1' => $request->ringkasan1,
            'foto2' => $foto2,
            'program2' => $request->program2,
            'ringkasan2' => $request->ringkasan2,
            'foto3' => $foto3,
            'program3' => $request->program3,
            'ringkasan3' => $request->ringkasan3,
            'foto4' => $foto4,
            'program4' => $request->program4,
            'ringkasan4' => $request->ringkasan4,
            'status' => $request->status,
        ];

        Program::create($data);

        return redirect()->route('superadmin.landing.program');
    }

    public function editdata($id)
    {
        $program = Program::findOrfail($id);

        return view('superadmin.landing.program.edit', compact('program'));
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

        $program = Program::findOrFail($id);

        $foto1 = $program->foto1; // Simpan dulu icon1 lama
        $foto2 = $program->foto2; // Simpan dulu icon1 lama
        $foto3 = $program->foto3; // Simpan dulu icon1 lama
        $foto4 = $program->foto4; // Simpan dulu icon1 lama

        if ($request->hasFile('foto1')) {
            // Hapus file foto1 lama jika ada (opsional)
            if ($foto1 && Storage::disk('public')->exists($foto1)) {
                Storage::disk('public')->delete($foto1);
            }

            $originalName = $request->file('foto1')->getClientOriginalName();
            $foto1 = $request->file('foto1')->storeAs('landing/program/foto1', $originalName, 'public');
        } else {
            $foto1 = $program->foto1;
        }

        if ($request->hasFile('foto2')) {
            // Hapus file foto2 lama jika ada (opsional)
            if ($foto2 && Storage::disk('public')->exists($foto2)) {
                Storage::disk('public')->delete($foto2);
            }

            $originalName = $request->file('foto2')->getClientOriginalName();
            $foto2 = $request->file('foto2')->storeAs('landing/program/foto2', $originalName, 'public');
        } else {
            $foto2 = $program->foto2;
        }

        if ($request->hasFile('foto3')) {
            // Hapus file foto3 lama jika ada (opsional)
            if ($foto3 && Storage::disk('public')->exists($foto3)) {
                Storage::disk('public')->delete($foto3);
            }

            $originalName = $request->file('foto3')->getClientOriginalName();
            $foto3 = $request->file('foto3')->storeAs('landing/program/foto3', $originalName, 'public');
        } else {
            $foto3 = $program->foto3;
        }

        if ($request->hasFile('foto4')) {
            // Hapus file foto4 lama jika ada (opsional)
            if ($foto4 && Storage::disk('public')->exists($foto4)) {
                Storage::disk('public')->delete($foto4);
            }

            $originalName = $request->file('foto4')->getClientOriginalName();
            $foto4 = $request->file('foto4')->storeAs('landing/program/foto4', $originalName, 'public');
        } else {
            $foto4 = $program->foto4;
        }

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'foto1' => $foto1,
            'program1' => $request->program1,
            'ringkasan1' => $request->ringkasan1,
            'foto2' => $foto2,
            'program2' => $request->program2,
            'ringkasan2' => $request->ringkasan2,
            'foto3' => $foto3,
            'program3' => $request->program3,
            'ringkasan3' => $request->ringkasan3,
            'foto4' => $foto4,
            'program4' => $request->program4,
            'ringkasan4' => $request->ringkasan4,
            'status' => $request->status,
        ];

        $program->update($data);

        return redirect()->route('superadmin.landing.program');
    }

    public function hapus($id)
    {
        Program::destroy($id);

        return redirect()->route('superadmin.landing.program');
    }
}
