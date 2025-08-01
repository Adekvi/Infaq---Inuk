<?php

namespace App\Http\Controllers\Kolektor\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\Role\Transaksi\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $rt = $request->input('rt');
        $rw = $request->input('rw');

        // Query dasar untuk Penerimaan
        $query = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->with(['user', 'plotting.kecamatan', 'plotting.kelurahan']);

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('tglSetor', 'LIKE', "%{$search}%")
                    ->orWhere('nominal', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('Rt', 'LIKE', "%{$search}%")
                    ->orWhere('Rw', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('username', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kecamatan', function ($q3) use ($search) {
                        $q3->where('nama_kecamatan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kelurahan', function ($q3) use ($search) {
                        $q3->where('nama_kelurahan', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter kecamatan
        if ($kecamatan) {
            $query->whereHas('plotting.kecamatan', function ($q) use ($kecamatan) {
                $q->where('db_kecamatans.id', $kecamatan);
            });
        }

        // Filter kelurahan
        if ($kelurahan) {
            $query->whereHas('plotting.kelurahan', function ($q) use ($kelurahan) {
                $q->where('db_kelurahans.id', $kelurahan);
            });
        }

        // Filter Rt
        if ($rt) {
            $query->where('Rt', $rt);
        }

        // Filter Rw
        if ($rw) {
            $query->where('Rw', $rw);
        }

        // Ambil data dengan paginasi
        $terima = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $terima->appends([
            'search' => $search,
            'entries' => $entries,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'rt' => $rt,
            'rw' => $rw
        ]);

        // dd($terima);

        // Ambil data untuk dropdown
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();
        // Ambil nilai unik Rt dan Rw dari penerimaans
        $rts = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rt')
            ->filter()
            ->sort()
            ->values();
        $rws = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rw')
            ->filter()
            ->sort()
            ->values();

        return view('kolektor.transaksi.penerimaan.index', compact('terima', 'search', 'entries', 'kecamatans', 'rts', 'rws'));
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }

    public function tampiltambah()
    {
        $idUser = Auth::id();

        // Ambil plotting untuk user ini
        $plotting = Plotting::with(['kecamatan', 'kelurahan'])
            ->where('id_user', $idUser)
            ->get();

        // dd($plotting);

        // Ambil kecamatan yang ada plottingnya
        $kecamatans = $plotting->groupBy('id_kecamatan');

        return view('kolektor.transaksi.penerimaan.tambah', compact('kecamatans'));
    }

    // API AJAX untuk ambil kelurahan berdasarkan kecamatan
    public function getKelurahanByKecamatan(Request $request)
    {
        $idUser = Auth::id();

        $kelurahan = Plotting::with('kelurahan')
            ->where('id_user', $idUser)
            ->where('id_kecamatan', $request->id_kecamatan)
            ->get()
            ->unique('id_kelurahan') // Menghapus data duplikat berdasarkan id_kelurahan
            ->map(function ($item) {
                return [
                    'id' => $item->id_kelurahan,
                    'nama_kelurahan' => $item->kelurahan->nama_kelurahan,
                    'rt' => json_decode($item->Rt, true),
                    'rw' => json_decode($item->Rw, true),
                ];
            })
            ->values(); // Reset index agar rapi

        return response()->json($kelurahan);
    }

    public function tambah(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kecamatan' => 'required|exists:db_kecamatans,id',
            'kelurahan' => 'required|exists:db_kelurahans,id',
            'Rt.*' => 'required|string|max:255',
            'Rw.*' => 'required|string|max:255',
            'nominal.*' => 'required|numeric|min:0',
            'jumlah' => 'required|numeric|min:0',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tglSetor' => 'nullable|date',
            'namaBank' => 'nullable|string|max:255',
            'Rekening' => 'nullable|integer',
        ]);

        // Cek jumlah array RT, RW, dan nominal
        if (count($request->Rt) !== count($request->Rw) || count($request->Rt) !== count($request->nominal)) {
            return back()->withErrors(['error' => 'Jumlah RT, RW, dan Nominal tidak sesuai'])->withInput();
        }

        // Validasi total nominal
        $totalNominal = array_sum(array_map('floatval', $request->nominal));
        if ($totalNominal != $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total nominal'])->withInput();
        }

        $id_user = Auth::id();
        $dataDiri = Datadiri::where('id_user', $id_user)->first();

        // 🔹 Cek apakah plotting untuk user + kecamatan + kelurahan sudah ada
        $plotting = Plotting::where('id_user', $id_user)
            ->where('id_kecamatan', $request->kecamatan)
            ->where('id_kelurahan', $request->kelurahan)
            ->first();

        // Kalau belum ada → buat baru (RT/RW di-JSON-kan semua dari input)
        if (!$plotting) {
            $plotting = Plotting::create([
                'id_user' => $id_user,
                'id_datadiri' => $dataDiri->id ?? null,
                'id_kecamatan' => $request->kecamatan,
                'id_kelurahan' => $request->kelurahan,
                'Rt' => json_encode($request->Rt),
                'Rw' => json_encode($request->Rw),
            ]);
        } else {
            $existingRt = json_decode($plotting->Rt, true) ?? [];
            $existingRw = json_decode($plotting->Rw, true) ?? [];

            // Gabungkan & hilangkan duplikat
            $mergedRt = array_unique(array_merge($existingRt, $request->Rt));
            $mergedRw = array_unique(array_merge($existingRw, $request->Rw));

            // Reset index agar array numerik murni
            $mergedRt = array_values($mergedRt);
            $mergedRw = array_values($mergedRw);

            // Simpan lagi
            $plotting->update([
                'Rt' => json_encode($mergedRt, JSON_UNESCAPED_UNICODE),
                'Rw' => json_encode($mergedRw, JSON_UNESCAPED_UNICODE),
            ]);
        }

        // Simpan bukti foto jika ada
        $bukti_foto_path = null;
        if ($request->hasFile('bukti_foto')) {
            $bukti_foto_path = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        // 🔹 Simpan ke penerimaan (satu baris per RT/RW)
        foreach ($request->nominal as $index => $nominal) {
            $penerimaan = [
                'id_user' => $id_user,
                'id_plot' => $plotting->id,
                'Rt' => $request->Rt[$index],
                'Rw' => $request->Rw[$index],
                'nominal' => $nominal,
                'jumlah' => $request->jumlah,
                'bukti_foto' => $bukti_foto_path,
                'tglSetor' => $request->tglSetor,
                'namaBank' => $request->namaBank,
                'Rekening' => $request->Rekening,
                'status' => 'Pending',
            ];

            // dd($penerimaan);

            Penerimaan::create($penerimaan);
        }

        return redirect()->route('kolektor.input.infaq')->with('success', 'Data donasi berhasil disimpan.');
    }

    public function editdata(Request $request, $id)
    {
        // Ambil data penerimaan berdasarkan id_user dan id
        $penerimaan = Penerimaan::where('id_user', Auth::id())
            ->where('id', $id)
            ->with(['plotting.kecamatan', 'plotting.kelurahan'])
            ->first();

        if (!$penerimaan) {
            return redirect()->route('kolektor.input.infaq')->with('error', 'Data penerimaan tidak ditemukan.');
        }

        // Ambil semua record penerimaan terkait id_plot dan id_user
        $penerimaans = Penerimaan::where('id_user', Auth::id())
            ->where('id_plot', $penerimaan->id_plot)
            ->get();

        return view('kolektor.transaksi.penerimaan.edit', compact('penerimaan', 'penerimaans'));
    }

    public function edit(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'Rt.*' => 'required|string|max:255',
            'Rw.*' => 'required|string|max:255',
            'nominal.*' => 'required|numeric|min:0',
            'jumlah' => 'required|numeric|min:0',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tglSetor' => 'nullable|date',
            'namaBank' => 'nullable|string|max:255',
            'Rekening' => 'nullable|integer',
        ]);

        // Validasi jumlah elemen array Rt, Rw, dan nominal
        $rtCount = count($request->Rt);
        $rwCount = count($request->Rw);
        $nominalCount = count($request->nominal);
        if ($rtCount !== $rwCount || $rtCount !== $nominalCount) {
            return redirect()->back()->withErrors(['error' => 'Jumlah RT, RW, dan Nominal tidak sesuai.'])->withInput();
        }

        // Validasi total jumlah
        $totalNominal = array_sum(array_map('floatval', $request->nominal));
        if ($totalNominal != $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total nominal.'])->withInput();
        }

        // Ambil id_user dan id_plot
        $id_user = Auth::id();
        $penerimaan = Penerimaan::where('id_user', $id_user)->where('id', $id)->first();
        if (!$penerimaan) {
            return redirect()->back()->with('error', 'Data penerimaan tidak ditemukan.');
        }
        $id_plot = $penerimaan->id_plot;

        // Hapus semua record lama terkait id_plot dan id_user
        $oldPenerimaans = Penerimaan::where('id_user', $id_user)->where('id_plot', $id_plot)->get();
        foreach ($oldPenerimaans as $old) {
            if ($old->bukti_foto) {
                Storage::disk('public')->delete($old->bukti_foto);
            }
            $old->delete();
        }

        // Handle upload file bukti_foto
        $bukti_foto_path = $penerimaan->bukti_foto;
        if ($request->hasFile('bukti_foto')) {
            // Hapus file lama jika ada
            if ($bukti_foto_path) {
                Storage::disk('public')->delete($bukti_foto_path);
            }
            $bukti_foto_path = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        // Simpan data baru
        foreach ($request->nominal as $index => $nominal) {
            Penerimaan::create([
                'id_user' => $id_user,
                'id_plot' => $id_plot,
                'Rt' => $request->Rt[$index],
                'Rw' => $request->Rw[$index],
                'nominal' => $nominal,
                'jumlah' => $request->jumlah,
                'bukti_foto' => $bukti_foto_path,
                'tglSetor' => $request->tglSetor,
                'namaBank' => $request->namaBank,
                'Rekening' => $request->Rekening,
                'status' => 'Pending',
            ]);
        }

        return redirect()->route('kolektor.input.infaq');
    }
}
