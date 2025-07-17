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
        $plotting = Plotting::findOrFail($id);
        $user = User::where('status', 'A')
            ->whereNotIn('role', ['superadmin', 'admin_kecamatan', 'admin_kabupaten'])
            ->get();
        $kecamatan = Db_kecamatan::all();
        $kelurahan = Db_kelurahan::where('id_kecamatan', $plotting->id_kecamatan)->get();

        return view('superadmin.master.data_plotting.edit', compact(
            'plotting',
            'user',
            'kecamatan',
            'kelurahan'
        ));
    }

    public function edit(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'id_kelurahan' => 'required|array|min:1',
            'id_kelurahan.*' => 'exists:db_kelurahans,id',
            'Rt' => 'required|array|min:1',
            'Rt.*' => 'string|max:255|not_in:""',
            'Rw' => 'required|array|min:1',
            'Rw.*' => 'string|max:255|not_in:""',
        ]);

        // Validasi custom untuk memastikan jumlah Rt dan Rw sama
        $validator = Validator::make($request->all(), [
            'Rt' => 'required|array|min:1',
            'Rw' => 'required|array|min:1',
        ], [], []);

        $validator->after(function ($validator) use ($request) {
            if (count($request->Rt) !== count($request->Rw)) {
                $validator->errors()->add('Rt', 'Jumlah RT dan RW harus sama.');
                $validator->errors()->add('Rw', 'Jumlah RT dan RW harus sama.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data plotting yang akan diedit
        $plotting = Plotting::findOrFail($id);

        // Ambil data diri terkait user
        $dataDiri = DataDiri::where('id_user', $request->id_user)->first();

        // Pastikan panjang array Rt dan Rw sama
        $rtArray = $request->Rt;
        $rwArray = $request->Rw;
        $maxLength = max(count($rtArray), count($rwArray));
        $rtArray = array_pad($rtArray, $maxLength, '');
        $rwArray = array_pad($rwArray, $maxLength, '');

        // Update data plotting
        $plotting->update([
            'id_user' => $request->id_user,
            'id_datadiri' => $dataDiri ? $dataDiri->id : null,
            'id_kecamatan' => $request->id_kecamatan,
            'Rt' => json_encode($rtArray),
            'Rw' => json_encode($rwArray),
        ]);

        // Sinkronisasi kelurahan di pivot table
        $plotting->kelurahan()->sync($request->id_kelurahan);

        Log::info('Plotting berhasil diupdate: ', $plotting->toArray());

        return redirect()->route('superadmin.master.plotting')->with('success', 'Data plotting berhasil diperbarui.');
    }


    public function hapus($id)
    {
        Plotting::destroy($id);

        return redirect()->route('superadmin.master.plotting');
    }
}
