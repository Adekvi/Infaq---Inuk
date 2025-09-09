<?php

namespace App\Http\Controllers;

use App\Models\Landing\Berita;
use App\Models\Landing\Keunggulan;
use App\Models\Landing\Layanan;
use App\Models\Landing\Pertanyaan;
use App\Models\Landing\Program;
use App\Models\Landing\Struktur;
use App\Models\Landing\Tentang;
use App\Models\Landing\Testimoni;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $tentang = Tentang::where('status', 'Aktif')->first();
        $program = Program::where('status', 'Aktif')->first();
        $layanan = Layanan::where('status', 'Aktif')->first();
        $keunggulan = Keunggulan::where('status', 'Aktif')->first();
        $berita = Berita::where('status', 'Aktif')->get();
        $tanya = Pertanyaan::where('status', 'Aktif')->first();
        $struktur = Struktur::where('status', 'Aktif')->first();
        $testi = Testimoni::where('status', 'Aktif')->get();

        if ($struktur) {
            $struktur->penghimpunan_array = $struktur->penghimpunan ? explode('|', $struktur->penghimpunan) : [];
            $struktur->pendistribusian_array = $struktur->pendistribusian ? explode('|', $struktur->pendistribusian) : [];
            $struktur->keuangan_array = $struktur->keuangan ? explode('|', $struktur->keuangan) : [];
            $struktur->humas_array = $struktur->humas ? explode('|', $struktur->humas) : [];
        }

        // dd($struktur);

        // DONASI
        $currentYear = now()->year;
        $currentMonth = now()->month;  // Tidak digunakan, tapi simpan jika perlu

        $total_donasi_tahun = Penerimaan::whereYear('tglSetor', $currentYear)->sum('nominal');

        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->whereYear('tglSetor', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $total_donasi_per_bulan = [];
        foreach ($donasi_bulanan as $data) {
            $namaBulan = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $total_donasi_per_bulan[$namaBulan] = $data->total;
        }

        $penerimaan = Penerimaan::all();
        $totalDonasi = $penerimaan->sum('nominal');
        $jumlahDonatur = $penerimaan->count();

        // PERBAIKAN: Ambil data dengan handling null relasi (leftJoin jika perlu, tapi pakai whereHas untuk filter valid)
        $data_penerimaan = Penerimaan::with(['plotting.kecamatan', 'plotting.kelurahan'])
            ->whereHas('plotting')  // Hanya ambil yang punya plotting valid (hindari null)
            ->get();

        $kecamatans = Db_kecamatan::pluck('nama_kecamatan', 'id')->toArray();

        // Inisialisasi array kosong jika data null
        $rekap_per_desa = [];
        $rekap_per_kecamatan = [];

        // PERBAIKAN: Tambah check null di loop untuk hindari error
        foreach ($data_penerimaan as $penerimaan) {
            if (!$penerimaan->plotting || !$penerimaan->plotting->kecamatan || !$penerimaan->plotting->kelurahan) {
                continue;  // Skip jika relasi null
            }

            $id_kecamatan = $penerimaan->plotting->kecamatan->id;
            $id_kelurahan = $penerimaan->plotting->kelurahan->id;
            $nama_desa = $penerimaan->plotting->kelurahan->nama_kelurahan ?? 'Unknown';
            $nama_kecamatan = $penerimaan->plotting->kecamatan->nama_kecamatan ?? 'Unknown';
            $key_desa = $id_kecamatan . '_' . $id_kelurahan;
            $key_kecamatan = $id_kecamatan;

            // Rekap per desa
            if (!isset($rekap_per_desa[$key_desa])) {
                $rekap_per_desa[$key_desa] = [
                    'id_kecamatan' => $id_kecamatan,
                    'id_desa' => $id_kelurahan,
                    'nama_desa' => $nama_desa,
                    'jumlah_donatur_mengirim' => 0,
                    'total_donasi' => 0,
                    'total_donatur' => 0,
                ];
            }
            $rekap_per_desa[$key_desa]['jumlah_donatur_mengirim'] += 1;
            $rekap_per_desa[$key_desa]['total_donasi'] += $penerimaan->nominal ?? 0;
            $rekap_per_desa[$key_desa]['total_donatur'] += 1;

            // Rekap per kecamatan
            if (!isset($rekap_per_kecamatan[$key_kecamatan])) {
                $rekap_per_kecamatan[$key_kecamatan] = [
                    'id_kecamatan' => $id_kecamatan,
                    'nama_kecamatan' => $nama_kecamatan,
                    'jumlah_donatur_mengirim' => 0,
                    'total_donasi' => 0,
                    'total_donatur' => 0,
                ];
            }
            $rekap_per_kecamatan[$key_kecamatan]['jumlah_donatur_mengirim'] += 1;
            $rekap_per_kecamatan[$key_kecamatan]['total_donasi'] += $penerimaan->nominal ?? 0;
            $rekap_per_kecamatan[$key_kecamatan]['total_donatur'] += 1;
        }

        // PERBAIKAN: Tambah 'persentase' untuk setiap kecamatan (default 0 jika kosong)
        foreach ($rekap_per_kecamatan as &$kecamatan) {
            $kecamatan['persentase'] = $kecamatan['total_donatur'] > 0
                ? round(($kecamatan['jumlah_donatur_mengirim'] / $kecamatan['total_donatur']) * 100, 2)
                : 0;
        }

        // PERBAIKAN: Pastikan array indexed numeric (0,1,2...) untuk JSON valid di JS
        $rekap_per_desa = array_values($rekap_per_desa);
        $rekap_per_kecamatan = array_values($rekap_per_kecamatan);

        // Jika masih kosong setelah loop, set default empty array (hindari null)
        if (empty($rekap_per_desa)) $rekap_per_desa = [];
        if (empty($rekap_per_kecamatan)) $rekap_per_kecamatan = [];

        return view('index', compact(
            'tentang',
            'program',
            'layanan',
            'keunggulan',
            'berita',
            'tanya',
            'struktur',
            'testi',
            'total_donasi_tahun',
            'total_donasi_per_bulan',
            'totalDonasi',
            'jumlahDonatur',
            'kecamatans',
            'rekap_per_desa',
            'rekap_per_kecamatan'
        ));
    }
}
