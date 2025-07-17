<?php

namespace App\Http\Controllers\Kolektor\Plotting;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Setting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TempatController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:kolektor');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan'); // ini adalah ID
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Plotting::with(['user.setting', 'datadiri', 'kecamatan', 'kelurahan'])
            ->where('id_user', Auth::user()->id)
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

        if (!$plotting) {
            return redirect()->route('kolektor.plotting-tempat')->with('info', 'Silakan pilih plotting tempat.');
        }

        // dd($plotting);

        return view('kolektor.identitas.plotting.index', compact('search', 'entries', 'plotting', 'kecamatans', 'kelurahans'));
    }

    public function create()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // Ambil data kecamatan untuk dropdown
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();
        $kelurahans = Db_kelurahan::all();

        // dd($user);

        return view('kolektor.identitas.plotting.tambah', compact('user', 'kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        // Debugging input (uncomment untuk uji coba)
        // dd($request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'kelurahans' => 'required|array',
            'kelurahans.*' => 'exists:db_kelurahans,id',
            'rt' => 'required|array',
            'rt.*' => 'required|regex:/^[0-9]{1,3}$/',
            'rw' => 'required|array',
            'rw.*' => 'required|regex:/^[0-9]{1,3}$/',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data dari request
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahanIds = $request->input('kelurahans');
        $rts = $request->input('rt');
        $rws = $request->input('rw');

        // Pastikan jumlah RT dan RW sesuai dengan jumlah kelurahan
        if (count($rts) !== count($rws) || count($rts) < count($kelurahanIds)) {
            Log::error('Jumlah RT/RW tidak sesuai', [
                'rt_count' => count($rts),
                'rw_count' => count($rws),
                'kelurahan_count' => count($kelurahanIds),
            ]);
            return redirect()->back()
                ->withErrors(['rt' => 'Jumlah RT dan RW tidak sesuai dengan jumlah kelurahan yang dipilih.'])
                ->withInput();
        }

        // Ambil data diri terkait user
        $dataDiri = Datadiri::where('id_user', $request->id_user)->first();

        try {
            // Simpan data plotting
            $plotting = Plotting::create([
                'id_user' => Auth::id(),
                'id_datadiri' => $dataDiri ?? null,
                'id_kecamatan' => $kecamatanId,
                'Rt' => json_encode($rts),
                'Rw' => json_encode($rws),
            ]);

            // Sinkronkan kelurahan
            $plotting->kelurahan()->sync($kelurahanIds);

            Log::info('Data plotting tersimpan', [
                'plotting_id' => $plotting->id,
                'kecamatan_id' => $kecamatanId,
                'kelurahan_ids' => $kelurahanIds,
                'rt' => $rts,
                'rw' => $rws,
            ]);

            return redirect()->route('plotting.kolektor.index')
                ->with('success', 'Data plotting berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan plotting', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan data plotting: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function editdata($id)
    {
        // Ambil data plotting berdasarkan ID
        $plotting = Plotting::with('kelurahan')->findOrFail($id);

        // Ambil semua kecamatan
        $kecamatans = Db_kecamatan::all();

        // Ambil ID kelurahan dari relasi
        $kelurahanIds = $plotting->kelurahan->pluck('id')->toArray();

        // Decode JSON untuk RT dan RW
        $rts = json_decode($plotting->Rt, true) ?? [];
        $rws = json_decode($plotting->Rw, true) ?? [];

        return view('kolektor.identitas.plotting.edit', compact('plotting', 'kecamatans', 'kelurahanIds', 'rts', 'rws'));
    }

    public function edit(Request $request, $id)
    {
        // Debugging input (uncomment untuk uji coba)
        // dd($request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_kecamatan' => 'required|exists:db_kecamatans,id',
            'kelurahans' => 'required|array',
            'kelurahans.*' => 'exists:db_kelurahans,id',
            'rt' => 'required|array',
            'rt.*' => 'required|regex:/^[0-9]{1,3}$/',
            'rw' => 'required|array',
            'rw.*' => 'required|regex:/^[0-9]{1,3}$/',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data dari request
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahanIds = $request->input('kelurahans');
        $rts = $request->input('rt');
        $rws = $request->input('rw');

        // Pastikan jumlah RT dan RW sesuai dengan jumlah kelurahan
        if (count($rts) !== count($rws) || count($rts) < count($kelurahanIds)) {
            Log::error('Jumlah RT/RW tidak sesuai', [
                'rt_count' => count($rts),
                'rw_count' => count($rws),
                'kelurahan_count' => count($kelurahanIds),
            ]);
            return redirect()->back()
                ->withErrors(['rt' => 'Jumlah RT dan RW tidak sesuai dengan jumlah kelurahan yang dipilih.'])
                ->withInput();
        }

        $plotting = Plotting::findOrFail($id);

        // Ambil data diri terkait user
        $dataDiri = DataDiri::where('id_user', $request->id_user)->first();

        try {
            // Simpan data plotting
            $plotting->update([
                'id_user' => Auth::id(),
                'id_datadiri' => $dataDiri ?? null,
                'id_kecamatan' => $kecamatanId,
                'Rt' => json_encode($rts),
                'Rw' => json_encode($rws),
            ]);

            // Sinkronkan kelurahan
            $plotting->kelurahan()->sync($kelurahanIds);

            Log::info('Data plotting tersimpan', [
                'plotting_id' => $plotting->id,
                'kecamatan_id' => $kecamatanId,
                'kelurahan_ids' => $kelurahanIds,
                'rt' => $rts,
                'rw' => $rws,
            ]);

            return redirect()->route('plotting.kolektor.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan plotting', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan data plotting: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }
}
