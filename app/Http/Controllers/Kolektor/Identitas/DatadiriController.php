<?php

namespace App\Http\Controllers\Kolektor\Identitas;

use App\Http\Controllers\Controller;
use App\Models\Master\Setting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatadiriController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya petugas yang bisa akses
        $this->middleware('role:kolektor');
    }

    public function create()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // Ambil data kecamatan untuk dropdown
        $kecamatans = Db_kecamatan::all();
        $kelurahans = Db_kelurahan::all();

        // Ambil setting berdasarkan role user
        $setting = Setting::where('namasetting', 'Kolektor')->get();

        // dd($user);

        return view('kolektor.identitas.create', compact('user', 'kecamatans', 'kelurahans', 'setting'));
    }

    public function index()
    {
        $datadiri = Datadiri::where('id_user', Auth::user()->id)
            ->with([
                'user',
                'kecamatan',
                'kelurahan',
                'setting'
            ])
            ->first();

        if (!$datadiri) {
            return redirect()->route('kolektor.identitas.create')->with('info', 'Silakan lengkapi data identitas Anda.');
        }

        // dd($datadiri);

        return view('kolektor.identitas.index', compact('datadiri'));
    }

    public function store(Request $request)
    {
        Log::info('Mulai proses penyimpanan identitas kolektor', ['data' => $request->all()]);

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Validasi input sesuai dengan field dari HTML
            $request->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'username' => 'required|string|max:255',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat' => 'required|string|max:255',
                'tgllahir' => 'required|date',
                'id_kecamatan' => 'required|exists:db_kecamatans,id',
                'id_kelurahan' => 'required|exists:db_kelurahans,id',
                'Rw' => 'required|string|max:10',
                'Rt' => 'required|string|max:10',
                'alamat' => 'required|string',
            ]);

            // Proses upload foto
            $fotoPath = null;
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $originalName = $request->file('foto')->getClientOriginalName();
                $fileName = time() . '_' . str_replace(' ', '_', $originalName);

                // Pastikan folder fotos ada di storage/public
                if (!Storage::disk('public')->exists('fotos')) {
                    Storage::disk('public')->makeDirectory('fotos');
                }

                $fotoPath = $request->file('foto')->storeAs('fotos', $fileName, 'public');
                Log::info('Foto berhasil diupload', ['path' => $fotoPath]);
            } else {
                if ($request->hasFile('foto') && !$request->file('foto')->isValid()) {
                    Log::warning('File foto tidak valid', ['file' => $request->file('foto')]);
                    throw new \Exception('File foto tidak valid.');
                }
            }

            // Simpan data ke model Datadiri
            $datadiri = Datadiri::create([
                'id_user' => Auth::id(),
                'id_setting' => $request->id_setting, // Gunakan namasetting dari form
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat' => $request->tempat,
                'tgllahir' => $request->tgllahir,
                'id_kecamatan' => $request->id_kecamatan,
                'id_kelurahan' => $request->id_kelurahan,
                'Rw' => $request->Rw,
                'Rt' => $request->Rt,
                'alamat' => $request->alamat,
                'foto' => $fotoPath,
            ]);

            // Update username pengguna jika diperlukan
            $user = User::find(Auth::id());
            if ($user->username !== $request->username) {
                $user->update(['username' => $request->username]);
                Log::info('Username pengguna diperbarui', ['username' => $request->username]);
            }

            // Komit transaksi
            DB::commit();

            return redirect()->route('kolektor.identitas.index')->with('success', 'Data identitas berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();
            Log::error('Gagal menyimpan data identitas: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function tampilEdit($id)
    {
        $datadiri = Datadiri::findOrFail($id);
        $kecamatan = Db_kecamatan::all();
        $kelurahan = Db_kelurahan::all();

        return view('kolektor.identitas.edit', compact('datadiri', 'kecamatan', 'kelurahan'));
    }

    public function edit(Request $request, $id)
    {
        Log::info('Mulai proses pembaruan identitas kolektor', ['id' => $id, 'data' => $request->all()]);

        // Mulai transaksi
        DB::beginTransaction();

        try {
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
                'alamat' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kecamatans.*' => 'nullable|exists:db_kecamatans,id',
                'kelurahans.*' => 'nullable|exists:db_kelurahans,id',
                'rw.*' => 'nullable|string|max:10',
                'rt.*' => 'nullable|string|max:10',
            ]);

            // Validasi tambahan untuk memastikan jumlah elemen konsisten
            $kecamatans = $request->kecamatans ?? [];
            $kelurahans = $request->kelurahans ?? [];
            $rws = $request->rw ?? [];
            $rts = $request->rt ?? [];

            $count = count($kecamatans);
            if ($count > 0 && (count($kelurahans) !== $count || count($rws) !== $count || count($rts) !== $count)) {
                throw new \Exception('Jumlah kecamatan, kelurahan, RW, dan RT harus sama.');
            }

            // Ambil data yang ada
            $datadiri = Datadiri::findOrFail($id);

            // Proses upload foto
            $fotoPath = $datadiri->foto;
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Hapus foto lama jika ada
                if ($datadiri->foto && Storage::disk('public')->exists($datadiri->foto)) {
                    Storage::disk('public')->delete($datadiri->foto);
                }

                $originalName = $request->file('foto')->getClientOriginalName();
                $fileName = time() . '_' . str_replace(' ', '_', $originalName);

                // Pastikan folder fotos ada di storage/public
                if (!Storage::disk('public')->exists('fotos')) {
                    Storage::disk('public')->makeDirectory('fotos');
                }

                $fotoPath = $request->file('foto')->storeAs('fotos', $fileName, 'public');
                Log::info('Foto berhasil diupload', ['path' => $fotoPath]);
            } else {
                Log::warning('Tidak ada file foto yang diupload atau file tidak valid', ['file' => $request->file('foto')]);
            }

            // Update data datadiri
            $datadiri->update([
                'id_user' => Auth::id(),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat' => $request->tempat,
                'tgllahir' => $request->tgllahir,
                'foto' => $fotoPath,
                'id_kecamatan' => $request->id_kecamatan,
                'id_kelurahan' => $request->id_kelurahan,
                'Rw' => $request->Rw,
                'Rt' => $request->Rt,
                'alamat' => $request->alamat,
            ]);

            // Komit transaksi
            DB::commit();

            return redirect()->route('kolektor.identitas.index')->with('success', 'Data identitas berhasil diubah.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();
            Log::error('Gagal memperbarui data identitas: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }
}
