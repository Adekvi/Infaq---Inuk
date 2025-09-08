<?php

namespace App\Http\Controllers\Kolektor\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Penerimaan\Dataterima;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\Role\Transaksi\Penerimaan;
use Carbon\Carbon;
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
            ->with(['user', 'plotting.kecamatan', 'plotting.kelurahan', 'dataterima']);

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

        $dataterima = Dataterima::where('id', $idUser)->first();

        // dd($dataterima);

        // Ambil kecamatan yang ada plottingnya
        $kecamatans = $plotting->groupBy('id_kecamatan');

        return view('kolektor.transaksi.penerimaan.tambah', compact('kecamatans', 'dataterima'));
    }

    public function searchNoAlat(Request $request)
    {
        $search = $request->get('q');

        $results = Dataterima::where('no_alat', 'like', "%{$search}%")
            ->select('id', 'no_alat', 'nama_donatur')
            ->limit(20)
            ->get();

        return response()->json(
            $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->no_alat, // hanya tampilkan no_alat
                    'no_alat' => $item->no_alat,
                    'nama_donatur' => $item->nama_donatur
                ];
            })
        );
    }

    public function searchNamaDonatur(Request $request)
    {
        $search = $request->get('q');

        $results = Dataterima::where('nama_donatur', 'like', "%{$search}%")
            ->select('id', 'no_alat', 'nama_donatur')
            ->limit(20)
            ->get();

        return response()->json(
            $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama_donatur, // hanya tampilkan nama_donatur
                    'no_alat' => $item->no_alat,
                    'nama_donatur' => $item->nama_donatur
                ];
            })
        );
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
        // dd($request->all());
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
            'no_alat' => 'required|string|max:255',
            'nama_donatur' => 'required|string|max:255',
        ]);

        if (count($request->Rt) !== count($request->Rw) || count($request->Rt) !== count($request->nominal)) {
            return back()->withErrors(['error' => 'Jumlah RT, RW, dan Nominal tidak sesuai'])->withInput();
        }

        $totalNominal = array_sum(array_map('floatval', $request->nominal));
        if ($totalNominal != $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total nominal'])->withInput();
        }

        $id_user = Auth::id();
        $dataDiri = Datadiri::where('id_user', $id_user)->first();

        // Cek / buat plotting
        $plotting = Plotting::firstOrCreate(
            [
                'id_user' => $id_user,
                'id_kecamatan' => $request->kecamatan,
                'id_kelurahan' => $request->kelurahan,
            ],
            [
                'id_datadiri' => $dataDiri->id ?? null,
                'Rt' => json_encode($request->Rt),
                'Rw' => json_encode($request->Rw),
            ]
        );

        if (!$plotting->wasRecentlyCreated) {
            $existingRt = json_decode($plotting->Rt, true) ?? [];
            $existingRw = json_decode($plotting->Rw, true) ?? [];
            $mergedRt = array_values(array_unique(array_merge($existingRt, $request->Rt)));
            $mergedRw = array_values(array_unique(array_merge($existingRw, $request->Rw)));
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

        // 🔹 Handle dataterima berdasarkan no_alat atau nama_donatur
        $id_terima = null;
        if ($request->no_alat || $request->nama_donatur) {
            $dataterima = Dataterima::where(function ($query) use ($request) {
                if ($request->no_alat) {
                    $query->where('no_alat', $request->no_alat);
                }
                if ($request->nama_donatur) {
                    $query->orWhere('nama_donatur', $request->nama_donatur);
                }
            })->first();

            // Ambil nama kelurahan berdasarkan id_kelurahan
            $kelurahan = Db_kelurahan::find($request->kelurahan); // Pastikan model Kelurahan sudah ada
            $nama_kelurahan = $kelurahan ? $kelurahan->nama_kelurahan : null;

            if (!$dataterima) {
                // Jika tidak ada, buat data baru
                $dataterima = Dataterima::create([
                    'no_alat' => $request->no_alat,
                    'nama_donatur' => $request->nama_donatur,
                    'nominal' => array_sum(array_map('floatval', $request->nominal)), // Total nominal dari array
                    'jenis' => 'INUK',
                    'tgl' => Carbon::now()->format('Y-m-d'), // Format tanggal yang benar
                    'alamat' => $nama_kelurahan, // Simpan nama kelurahan sebagai alamat
                ]);
            } else {
                // Jika ada tapi kolomnya belum lengkap, update datanya
                $updateData = [];
                if (!$dataterima->no_alat && $request->no_alat) {
                    $updateData['no_alat'] = $request->no_alat;
                }
                if (!$dataterima->nama_donatur && $request->nama_donatur) {
                    $updateData['nama_donatur'] = $request->nama_donatur;
                }
                if (!$dataterima->alamat && $nama_kelurahan) {
                    $updateData['alamat'] = $nama_kelurahan; // Update alamat jika kosong
                }
                if (!empty($updateData)) {
                    $dataterima->update($updateData);
                }
            }

            $id_terima = $dataterima->id;
        }

        foreach ($request->nominal as $index => $nominal) {
            $penerimaan = [
                'id_user' => $id_user,
                'id_plot' => $plotting->id,
                'id_terima' => $id_terima, // Tambahkan ini (bisa null jika tidak ada input)
                'nama_donatur' => $request->nama_donatur, // Simpan nama_donatur di sini juga
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
        $id_user = Auth::id();

        // Ambil data penerimaan yang ingin diedit
        $penerimaan = Penerimaan::where('id_user', $id_user)
            ->where('id', $id)
            ->with(['plotting.kecamatan', 'plotting.kelurahan', 'dataterima'])
            ->first();

        if (!$penerimaan) {
            return redirect()->route('kolektor.input.infaq')->with('error', 'Data penerimaan tidak ditemukan.');
        }

        // Ambil semua penerimaan dengan id_plot sama dan id_terima sama
        $penerimaans = Penerimaan::where('id_user', $id_user)
            ->where('id_plot', $penerimaan->id_plot)
            ->where('id_terima', $penerimaan->id_terima)
            ->get();

        return view('kolektor.transaksi.penerimaan.edit', compact('penerimaan', 'penerimaans'));
    }

    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'Rt.*' => 'required|string|max:255',
            'Rw.*' => 'required|string|max:255',
            'nominal.*' => 'required|numeric|min:0',
            'jumlah' => 'required|numeric|min:0',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tglSetor' => 'nullable|date',
            'namaBank' => 'nullable|string|max:255',
            'Rekening' => 'nullable|integer',
            'no_alat' => 'required|string|max:255',
            'nama_donatur' => 'required|string|max:255',
        ]);

        $rtCount = count($request->Rt);
        $rwCount = count($request->Rw);
        $nominalCount = count($request->nominal);
        if ($rtCount !== $rwCount || $rtCount !== $nominalCount) {
            return redirect()->back()->withErrors(['error' => 'Jumlah RT, RW, dan Nominal tidak sesuai.'])->withInput();
        }

        $totalNominal = array_sum(array_map('floatval', $request->nominal));
        if ($totalNominal != $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Jumlah tidak sesuai dengan total nominal.'])->withInput();
        }

        $id_user = Auth::id();
        $penerimaan = Penerimaan::where('id_user', $id_user)->where('id', $id)->first();
        if (!$penerimaan) {
            return redirect()->back()->with('error', 'Data penerimaan tidak ditemukan.');
        }

        $id_plot = $penerimaan->id_plot;

        // 🔹 Handle dataterima berdasarkan no_alat atau nama_donatur
        $dataterima = Dataterima::where('no_alat', $request->no_alat)
            ->orWhere('nama_donatur', $request->nama_donatur)
            ->first();

        if (!$dataterima) {
            $dataterima = Dataterima::create([
                'no_alat' => $request->no_alat,
                'nama_donatur' => $request->nama_donatur,
            ]);
        }

        $id_terima = $dataterima->id;

        // 🔹 Ambil semua record lama untuk id_plot & id_terima
        $oldPenerimaans = Penerimaan::where('id_user', $id_user)
            ->where('id_plot', $id_plot)
            ->where('id_terima', $id_terima)
            ->get();

        // Handle upload file bukti_foto
        $bukti_foto_path = $oldPenerimaans->first()?->bukti_foto ?? null;
        if ($request->hasFile('bukti_foto')) {
            if ($bukti_foto_path) {
                Storage::disk('public')->delete($bukti_foto_path);
            }
            $bukti_foto_path = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        foreach ($request->nominal as $index => $nominal) {
            if (isset($oldPenerimaans[$index])) {
                // Update data lama
                $old = $oldPenerimaans[$index];
                $old->update([
                    'Rt' => $request->Rt[$index],
                    'Rw' => $request->Rw[$index],
                    'nominal' => $nominal,
                    'jumlah' => $request->jumlah,
                    'bukti_foto' => $bukti_foto_path,
                    'tglSetor' => $request->tglSetor,
                    'namaBank' => $request->namaBank,
                    'Rekening' => $request->Rekening,
                    'status' => 'Pending',
                    'id_terima' => $id_terima,
                    'nama_donatur' => $request->nama_donatur,
                ]);
            } else {
                // Tambah data baru jika input lebih banyak
                Penerimaan::create([
                    'id_user' => $id_user,
                    'id_plot' => $id_plot,
                    'id_terima' => $id_terima,
                    'nama_donatur' => $request->nama_donatur,
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
        }

        // 🔹 Hapus data lama jika jumlah input sekarang lebih sedikit
        if (count($oldPenerimaans) > count($request->nominal)) {
            for ($i = count($request->nominal); $i < count($oldPenerimaans); $i++) {
                $oldPenerians = $oldPenerimaans[$i];
                if ($oldPenerians->bukti_foto) {
                    Storage::disk('public')->delete($oldPenerians->bukti_foto);
                }
                $oldPenerians->delete();
            }
        }

        return redirect()->route('kolektor.input.infaq');
    }
}
