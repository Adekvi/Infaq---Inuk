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

        dd($struktur);

        // DONASI
        // Mendapatkan tahun dan bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Total donasi untuk tahun saat ini dengan status 'Kirim'
        $total_donasi_tahun = Penerimaan::whereYear('tglSetor', $currentYear)
            ->sum('nominal');

        // Total donasi per bulan untuk tahun saat ini
        $donasi_bulanan = Penerimaan::selectRaw('MONTH(tglSetor) as bulan, SUM(nominal) as total')
            ->whereYear('tglSetor', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ubah angka bulan menjadi nama bulan Indonesia
        $total_donasi_per_bulan = [];
        foreach ($donasi_bulanan as $data) {
            $namaBulan = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $total_donasi_per_bulan[$namaBulan] = $data->total;
        }

        // Ambil semua data penerimaan
        $penerimaan = Penerimaan::all();

        // Total donasi
        $totalDonasi = $penerimaan->sum('nominal');

        // Jumlah donatur (jumlah baris)
        $jumlahDonatur = $penerimaan->count();

        // Data per kecamatan
        // Ambil semua kecamatan unik dari tabel plottings
        $kecamatans = Db_kecamatan::pluck('nama_kecamatan', 'id')->toArray();

        // Ambil data penerimaan dengan relasi plotting, filter status 'Pending'
        $data_penerimaan = Penerimaan::with(['plotting.kecamatan', 'plotting.kelurahan'])
            ->get();

        // Inisialisasi array untuk rekap per desa dan per kecamatan
        $rekap_per_desa = [];
        $rekap_per_kecamatan = [];
        $total_donatur_all = $data_penerimaan->count(); // Total donatur keseluruhan

        // Kelompokkan data per desa
        foreach ($data_penerimaan as $penerimaan) {
            $id_kecamatan = $penerimaan->plotting->id_kecamatan;
            $id_kelurahan = $penerimaan->plotting->id_kelurahan;
            $nama_desa = $penerimaan->plotting->kelurahan->nama_kelurahan ?? 'Unknown';
            $nama_kecamatan = $penerimaan->plotting->kecamatan->nama_kecamatan ?? 'Unknown';
            $key_desa = $id_kecamatan . '_' . $id_kelurahan; // Unique key untuk desa
            $key_kecamatan = $id_kecamatan; // Unique key untuk kecamatan

            // Rekap per desa
            if (!isset($rekap_per_desa[$key_desa])) {
                $rekap_per_desa[$key_desa] = [
                    'id_kecamatan' => $id_kecamatan,
                    'id_desa' => $id_kelurahan,
                    'nama_desa' => $nama_desa,
                    'jumlah_donatur_mengirim' => 0,
                    'total_donasi' => 0,
                    'total_donatur' => 0, // Asumsi total donatur per desa dihitung dari data penerimaan
                ];
            }

            // Tambahkan data donasi
            $rekap_per_desa[$key_desa]['jumlah_donatur_mengirim'] += 1; // 1 entri = 1 donatur
            $rekap_per_desa[$key_desa]['total_donasi'] += $penerimaan->nominal ?? 0;
            $rekap_per_desa[$key_desa]['total_donatur'] += 1; // Total donatur di desa

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

        // Hitung persentase untuk rekap per kecamatan
        foreach ($rekap_per_kecamatan as &$kecamatan) {
            $kecamatan['persentase'] = $kecamatan['total_donatur'] > 0
                ? round(($kecamatan['jumlah_donatur_mengirim'] / $kecamatan['total_donatur']) * 100, 2)
                : 0;
        }

        // Ubah format array agar sesuai dengan JavaScript (tanpa key numerik)
        $rekap_per_desa = array_values($rekap_per_desa);
        $rekap_per_kecamatan = array_values($rekap_per_kecamatan);

        // dd($rekap_per_kecamatan);

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
