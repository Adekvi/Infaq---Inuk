<?php

namespace App\Http\Controllers\Kolektor\Report;

use App\Exports\Kolektor\DataExcel;
use App\Http\Controllers\Controller;
use App\Jobs\GenerateExcelReport;
use App\Jobs\GeneratePdfReport;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Role\Transaksi\Penerimaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportDataController extends Controller
{
    /**
     * Validasi input request
     */
    private function validateRequest(Request $request): void
    {
        $request->validate([
            'periode' => 'nullable|in:custom,monthly,quarterly,semiannual,yearly',
            'start_date' => 'nullable|date|required_if:periode,custom',
            'end_date' => 'nullable|date|required_if:periode,custom|after_or_equal:start_date',
            'month' => 'nullable|integer|min:1|max:12|required_if:periode,monthly',
            'year' => 'nullable|integer|min:' . (Carbon::today()->year - 5) . '|max:' . Carbon::today()->year . '|required_if:periode,monthly,quarterly,semiannual,yearly',
        ]);
    }

    /**
     * Membuat query dasar untuk Penerimaan
     */
    private function buildBaseQuery()
    {
        return Penerimaan::where('id_user', Auth::user()->id)
            ->with(['user', 'plotting.kecamatan', 'plotting.kelurahan'])
            ->where('status', 'Kirim');
    }

    private function applyPeriodFilter($query, Request $request): void
    {
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');
        $year = $request->input('year');
        $showAll = filter_var($request->input('show_all'), FILTER_VALIDATE_BOOLEAN);

        // Jika showAll aktif, tidak perlu filter periode
        if ($showAll) {
            return;
        }

        // Default: hanya hari ini jika tidak ada periode
        if (!$periode) {
            $query->whereDate('tglSetor', Carbon::today()->toDateString());
            return;
        }

        // Filter berdasarkan periode
        if ($periode === 'custom' && $startDate && $endDate) {
            $query->whereBetween('tglSetor', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } elseif ($periode === 'monthly' && $month && $year) {
            $query->whereMonth('tglSetor', $month)
                ->whereYear('tglSetor', $year);
        } elseif (in_array($periode, ['quarterly', 'semiannual', 'yearly']) && $year) {
            if ($periode === 'yearly') {
                $query->whereYear('tglSetor', $year);
            } else {
                $currentMonth = Carbon::today()->month;
                $monthsToAdd = $periode === 'quarterly' ? 2 : 5;
                $interval = $periode === 'quarterly' ? 3 : 6;
                $startMonth = (ceil($currentMonth / $interval) - 1) * $interval + 1;
                $start = Carbon::create($year, $startMonth, 1)->startOfMonth();
                $end = $start->copy()->addMonths($monthsToAdd)->endOfMonth();
                $query->whereBetween('tglSetor', [$start, $end]);
            }
        }
    }

    /**
     * Menerapkan filter pencarian
     */
    private function applySearchFilter($query, ?string $search): void
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('tglSetor', 'LIKE', "%{$search}%")
                    ->orWhere('nominal', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('Rt', 'LIKE', "%{$search}%")
                    ->orWhere('Rw', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', fn($q2) => $q2->where('username', 'LIKE', "%{$search}%"))
                    ->orWhereHas('plotting.kecamatan', fn($q3) => $q3->where('nama_kecamatan', 'LIKE', "%{$search}%"))
                    ->orWhereHas('plotting.kelurahan', fn($q3) => $q3->where('nama_kelurahan', 'LIKE', "%{$search}%"));
            });
        }
    }

    /**
     * Menerapkan filter kecamatan dan kelurahan
     */
    private function applyLocationFilter($query, ?string $kecamatan, ?string $kelurahan): void
    {
        if ($kecamatan) {
            $query->whereHas('plotting.kecamatan', fn($q) => $q->where('db_kecamatans.id', $kecamatan));
        }

        if ($kelurahan) {
            $query->whereHas('plotting.kelurahan', fn($q) => $q->where('db_kelurahans.id', $kelurahan));
        }
    }

    /**
     * Menampilkan data dengan paginasi
     */
    public function index(Request $request)
    {
        $this->validateRequest($request);

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $showAll = filter_var($request->input('show_all'), FILTER_VALIDATE_BOOLEAN);
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');
        $year = $request->input('year');

        // Reset parameter filter periode saat showAll = true
        if ($showAll) {
            $page = 1; // Reset ke halaman 1
            $periode = null; // Reset filter periode
            $startDate = null;
            $endDate = null;
            $month = null;
            $year = null;
            $kecamatan = null; // Opsional: reset filter lokasi
            $kelurahan = null; // Opsional: reset filter lokasi
        }

        $query = $this->buildBaseQuery();

        // Terapkan filter hanya jika showAll = false
        if (!$showAll) {
            $this->applyPeriodFilter($query, $request);
            $this->applyLocationFilter($query, $kecamatan, $kelurahan);
        }

        // Terapkan filter pencarian (opsional)
        $this->applySearchFilter($query, $search);

        // Batch processing dengan paginasi
        $hasil = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $hasil->appends(compact('search', 'entries', 'kecamatan', 'kelurahan', 'showAll', 'periode', 'startDate', 'endDate', 'month', 'year'));

        // Tambahkan pesan jika tidak ada data
        $message = null;
        if ($hasil->isEmpty() && $periode === 'monthly' && $month && $year && !$showAll) {
            $monthName = Carbon::create()->month($month)->format('F');
            $message = "Tidak ada data untuk bulan $monthName $year.";
        } elseif ($hasil->isEmpty() && $showAll) {
            $message = "Tidak ada data yang tersedia.";
        }

        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();

        // Ambil nilai unik Rt dan Rw dari penerimaans
        $rts = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Kirim')
            ->distinct()
            ->pluck('Rt')
            ->filter()
            ->sort()
            ->values();
        $rws = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Kirim')
            ->distinct()
            ->pluck('Rw')
            ->filter()
            ->sort()
            ->values();

        return view('kolektor.report.index', compact('hasil', 'search', 'entries', 'kecamatans', 'showAll', 'periode', 'startDate', 'endDate', 'month', 'year', 'message', 'rts', 'rws'));
    }

    /**
     * Ekspor data ke Excel
     */
    /**
     * Ekspor data ke Excel
     */
    public function exportExcel(Request $request)
    {
        $this->validateRequest($request);

        $search = $request->input('search');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');
        $year = $request->input('year');
        $show_All = filter_var($request->input('show_all'), FILTER_VALIDATE_BOOLEAN);

        $query = $this->buildBaseQuery();
        $this->applyPeriodFilter($query, $request);
        $this->applySearchFilter($query, $search);
        $this->applyLocationFilter($query, $kecamatan, $kelurahan);

        // Ambil data untuk Excel
        $data = $query->orderBy('id', 'desc')->get();
        $hasData = $data->count() > 0;

        if (!$hasData) {
            Log::warning('No data found for Excel export', $request->all());
            return response()->json(['error' => 'Tidak ada data untuk diekspor.'], 400);
        }

        // Persiapkan metadata untuk nama file dan header
        $filterOption = $periode ?: 'today';
        $tanggal = $periode === 'custom' ? ($startDate . ' - ' . $endDate) : null;
        $months = $month ? Carbon::create()->month($month)->format('F') : null;
        $tahun = $year;
        $showAll = $show_All; // Perbaiki variabel show_All menjadi showAll

        // Generate nama file berdasarkan periode
        $filename = 'Laporan_Data_';
        if ($periode === 'custom' && $startDate && $endDate) {
            $filename .= 'Tanggal_' . Carbon::parse($startDate)->format('Ymd') . '_to_' . Carbon::parse($endDate)->format('Ymd');
        } elseif ($periode === 'monthly' && $month && $year) {
            $filename .= 'Bulanan_' . $months . '_' . $year;
        } elseif ($periode === 'quarterly' && $year) {
            $filename .= 'Triwulan_' . $year;
        } elseif ($periode === 'semiannual' && $year) {
            $filename .= 'Semesteran_' . $year;
        } elseif ($periode === 'yearly' && $year) {
            $filename .= 'Tahunan_' . $year;
        } else {
            $filename .= 'Harian_' . Carbon::today()->format('Ymd');
        }
        $filename .= '_' . now()->format('His') . '.xlsx'; // Tambahkan timestamp untuk keunikan

        // Tentukan path penyimpanan
        $directory = 'public/laporan/excel';
        $storagePath = $directory . '/' . $filename;

        // Dispatch job untuk generate Excel
        GenerateExcelReport::dispatch([
            'hasilinfaq' => $data,
            'filterOption' => $filterOption,
            'tanggal' => $tanggal,
            'months' => $months,
            'tahun' => $tahun,
            'showAll' => $showAll,
            'storagePath' => $storagePath,
            'filename' => $filename,
        ])->afterResponse();

        // Log data yang dikirim ke job
        Log::info('Dispatching Excel job', [
            'filename' => $filename,
            'storagePath' => $storagePath,
            'filterOption' => $filterOption,
            'showAll' => $showAll
        ]);

        // Kembalikan respons JSON dengan status pending
        return response()->json([
            'message' => 'Laporan Excel sedang diproses. File akan tersedia di storage setelah selesai.',
            'filename' => $filename,
            'path' => $storagePath
        ], 200);
    }

    public function downloadExcel($filename)
    {
        $storagePath = 'public/laporan/excel/' . $filename; // Tambahkan tanda '/'
        Log::info('Attempting to download Excel: ' . $storagePath);
        if (!Storage::exists($storagePath)) {
            Log::warning('Excel file not found: ' . $storagePath);
            return response()->json(['error' => 'File laporan belum tersedia atau tidak ditemukan.'], 404);
        }
        return response()->download(storage_path('app/' . $storagePath), $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }

    /**
     * Ekspor data ke PDF
     */
    public function exportPdf(Request $request)
    {
        $this->validateRequest($request);

        $search = $request->input('search');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');
        $year = $request->input('year');
        $showAll = filter_var($request->input('show_all'), FILTER_VALIDATE_BOOLEAN);

        $query = $this->buildBaseQuery();
        $this->applyPeriodFilter($query, $request);
        $this->applySearchFilter($query, $search);
        $this->applyLocationFilter($query, $kecamatan, $kelurahan);

        // Ambil data untuk PDF
        $hasilinfaq = $query->orderBy('id', 'desc')->get();
        $hasData = $hasilinfaq->count() > 0;

        if (!$hasData) {
            return redirect()->back()->withErrors(['export' => 'Tidak ada data untuk diekspor.']);
        }

        // Persiapkan variabel untuk job
        $filterOption = $periode ?: 'today';
        $tanggal = $periode === 'custom' ? ($startDate . ' - ' . $endDate) : null;
        $months = $month ? Carbon::create()->month($month)->format('F') : null;
        $tahun = $year;
        $show_All = $showAll;

        // Generate filename
        $filename = 'Laporan_Hasil_Setoran_' . now()->format('Ymd_His') . '.pdf';
        $directory = 'public/laporan/pdf';
        $storagePath = $directory . '/' . $filename;

        // Dispatch job untuk generate PDF
        GeneratePdfReport::dispatch([
            'hasilinfaq' => $hasilinfaq,
            'filterOption' => $filterOption,
            'tanggal' => $tanggal,
            'month' => $month,
            'tahun' => $tahun,
            'months' => $months,
            'show_All' => $show_All,
            'storagePath' => $storagePath,
            'filename' => $filename,
        ])->afterResponse();

        // Kembalikan response dengan status pending
        return response()->json([
            'message' => 'Laporan sedang diproses. File akan tersedia di storage setelah selesai.',
            'filename' => $filename,
            'path' => $storagePath
        ]);
    }

    public function downloadPdf($filename)
    {
        $storagePath = 'public/laporan/pdf' . $filename;
        Log::info('Attempting to download: ' . $storagePath);
        if (!Storage::exists($storagePath)) {
            Log::warning('File not found: ' . $storagePath);
            return redirect()->back()->withErrors(['download' => 'File laporan belum tersedia atau tidak ditemukan.']);
        }
        return response()->download(storage_path('app/' . $storagePath), $filename, ['Content-Type' => 'application/pdf']);
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }
}
