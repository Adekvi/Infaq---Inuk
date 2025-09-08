<?php

namespace App\Http\Controllers\Superadmin\Master\DataPlotting;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlottingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan'); // ini adalah ID
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Plotting::with(['user.setting', 'datadiri', 'kecamatan', 'kelurahan'])
            ->orderBy('plottings.id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('Rt', 'LIKE', "%{$search}%")
                    ->orWhere('Rw', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where(function ($sub) use ($search) {
                            $sub->where('username', 'LIKE', "%{$search}%")
                                ->orWhere('no_hp', 'LIKE', "%{$search}%")
                                ->orWhere('role', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%")
                                ->orWhere('status', 'LIKE', "%{$search}%");
                        });
                    })
                    ->orWhereHas('kecamatan', function ($q3) use ($search) {
                        $q3->where('nama_kecamatan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('kelurahan', function ($q3) use ($search) {
                        $q3->where('nama_kelurahan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('datadiri', function ($q3) use ($search) {
                        $q3->where('nama_lengkap', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter kecamatan
        if ($kecamatan) {
            $query->whereHas('kecamatan', function ($q) use ($kecamatan) {
                $q->where('db_kecamatans.id', $kecamatan);
            });
        }

        // Filter kelurahan lewat pivot
        if ($kelurahan) {
            $query->whereHas('kelurahan', function ($q) use ($kelurahan) {
                $q->where('db_kelurahans.id', $kelurahan);
            });
        }

        $plotting = $query->orderBy('plottings.id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $plotting->appends(['search' => $search, 'entries' => $entries, 'kecamatan' => $kecamatan, 'kelurahan' => $kelurahan]);

        // Transformasi JSON
        foreach ($plotting as $item) {
            $item->Rt = json_decode($item->Rt, true) ? implode(' - ', json_decode($item->Rt, true)) : '-';
            $item->Rw = json_decode($item->Rw, true) ? implode(' - ', json_decode($item->Rw, true)) : '-';
        }

        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();
        $kelurahans = Db_kelurahan::all();

        // Hapus dd($plotting) setelah debugging selesai
        // dd($plotting);

        return view('superadmin.master.data_plotting.index', compact('search', 'entries', 'plotting', 'kecamatans', 'kelurahans'));
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }

    public function tambahdata()
    {
        $user = User::where('status', 'A')
            ->whereNotIn('role', ['superadmin', 'admin_kecamatan', 'admin_kabupaten'])
            ->get();

        // dd($user); // Untuk debugging, bisa dihapus setelah verifikasi

        $kecamatan = Db_kecamatan::where('status', 'Aktif')->get();
        $kelurahan = Db_kelurahan::all();

        return view('superadmin.master.data_plotting.tambah', compact('kecamatan', 'kelurahan', 'user'));
    }

    public function tambah(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_kelurahan' => 'required|array|min:1',
            'id_kelurahan.*' => 'exists:db_kelurahans,id',
            'Rt' => 'required|array|min:1',
            'Rt.*' => 'string|max:255',
            'Rw' => 'required|array|min:1',
            'Rw.*' => 'string|max:255',
        ]);

        // Ambil id_datadiri berdasarkan id_user
        $dataDiri = DataDiri::where('id_user', $request->id_user)->first();

        $plotting = Plotting::create([
            'id_user' => $request->id_user,
            'id_datadiri' => $dataDiri ? $dataDiri->id : null,
            'id_kecamatan' => $request->id_kecamatan,
            'Rt' => json_encode($request->Rt),
            'Rw' => json_encode($request->Rw),
        ]);

        $plotting->kelurahan()->sync($request->id_kelurahan); // array of kelurahan ID

        return redirect()->route('superadmin.master.plotting');
    }

    public function editdata($id)
    {
        // Ambil data plotting berdasarkan ID
        $plotting = Plotting::with('kecamatan', 'kelurahan')->findOrFail($id);

        // Ambil daftar user
        $user = User::where('status', 'A')
            ->whereNotIn('role', ['superadmin', 'admin_kecamatan', 'admin_kabupaten'])
            ->where('id', $plotting->id_user) // sesuaikan nama kolom foreign key
            ->first();

        // dd($user);

        // Ambil semua kecamatan
        $kecamatan = Db_kecamatan::all();

        // Ambil kelurahan berdasarkan id_kecamatan dari plotting
        $kelurahan = Db_kelurahan::where('id_kecamatan', $plotting->id_kecamatan)->get();

        // Ambil ID kecamatan dan kelurahan yang dipilih
        $pilihKec = $plotting->id_kecamatan;
        $pilihKel = $plotting->id_kelurahan;

        // Decode JSON untuk RT dan RW
        $rts = json_decode($plotting->Rt, true) ?? [];
        $rws = json_decode($plotting->Rw, true) ?? [];

        return view('superadmin.master.data_plotting.edit', compact(
            'plotting',
            'user',
            'kecamatan',
            'kelurahan',
            'pilihKec',
            'pilihKel',
            'rts',
            'rws'
        ));
    }

    public function edit(Request $request, $id)
    {
        // Debugging input (uncomment untuk uji coba)
        // dd($request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_kecamatan' => 'nullable|exists:db_kecamatans,id',
            'id_kelurahan' => 'nullable|exists:db_kelurahans,id',
            'Rt' => 'required|array|min:1',
            'Rt.*' => 'required|regex:/^[0-9]{1,3}$/',
            'Rw' => 'required|array|min:1',
            'Rw.*' => 'required|regex:/^[0-9]{1,3}$/',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data dari request
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahanId = $request->input('id_kelurahan');
        $rts = $request->input('Rt');
        $rws = $request->input('Rw');

        // Pastikan jumlah RT dan RW sesuai
        if (count($rts) !== count($rws)) {
            Log::error('Jumlah RT/RW tidak sesuai', [
                'rt_count' => count($rts),
                'rw_count' => count($rws),
            ]);
            return redirect()->back()
                ->withErrors(['rt' => 'Jumlah RT dan RW tidak sesuai.'])
                ->withInput();
        }

        $plotting = Plotting::findOrFail($id);

        // Ambil data diri terkait user
        $dataDiri = DataDiri::where('id_user', $plotting->id_user)->first();

        try {
            // Simpan data plotting
            $plotting->update([
                'id_user' => $plotting->id_user, // Gunakan id_user yang sudah ada
                'id_datadiri' => $dataDiri ? $dataDiri->id : null,
                'id_kecamatan' => $kecamatanId,
                'id_kelurahan' => $kelurahanId,
                'Rt' => json_encode($rts),
                'Rw' => json_encode($rws),
            ]);

            Log::info('Data plotting tersimpan', [
                'plotting_id' => $plotting->id,
                'kecamatan_id' => $kecamatanId,
                'kelurahan_id' => $kelurahanId,
                'rt' => $rts,
                'rw' => $rws,
            ]);

            return redirect()->route('superadmin.master.plotting')->with('success', 'Data plotting berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan plotting', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan data plotting: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function hapus($id)
    {
        Plotting::destroy($id);

        return redirect()->route('superadmin.master.plotting');
    }
}
