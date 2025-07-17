<?php

namespace App\Http\Controllers\Adminkecamatan\Pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TampilController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dari request dengan default value
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $filterOption = $request->input('filter_option', 'all');
        $tanggal = $request->input('tanggal');
        $month = $request->input('month');
        $tahun = $request->input('tahun');
        $week = $request->input('week');

        // Validasi input filter
        $tanggal = $tanggal ? Carbon::parse($tanggal)->startOfDay() : null;
        $month = is_numeric($month) && $month >= 1 && $month <= 12 ? (int)$month : null;
        $tahun = is_numeric($tahun) && $tahun >= 1900 && $tahun <= now()->year ? (int)$tahun : null;
        $week = is_numeric($week) && $week >= 1 && $week <= 53 ? (int)$week : null;

        $months = collect(range(1, 12))->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')]);
        $years = range(now()->year, now()->year - 10);
        $weeks = range(1, 53);

        $query = Pengirimaninfaq::where('status', 'Terkirim')->orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('namaPenerima', 'LIKE', "%{$search}%")
                    ->orWhere('namaPengirim', 'LIKE', "%{$search}%")
                    ->orWhere('nama_kecamatan', 'LIKE', "%{$search}%")
                    ->orWhere('tglKirim', 'LIKE', "%{$search}%")
                    ->orWhere('pesan', 'LIKE', "%{$search}%")
                    ->orWhere('file_kirim', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        // Ambil seluruh data dahulu untuk disaring manual jika pakai filter tambahan
        $allData = $query->get();

        // Filter berdasarkan opsi
        if ($filterOption !== 'all') {
            $allData = $allData->filter(function ($file) use ($filterOption, $tanggal, $month, $tahun, $week) {
                $fileDate = $file->tglKirim ? Carbon::parse($file->tglKirim) : null;

                return match ($filterOption) {
                    'day' => $fileDate && $tanggal && $fileDate->isSameDay($tanggal),
                    'month' => $fileDate && $month && $tahun && $fileDate->year == $tahun && $fileDate->month == $month,
                    'year' => $fileDate && $tahun && $fileDate->year == $tahun,
                    'week' => $fileDate && $week && $tahun && $fileDate->between(
                        Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1),
                        Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1)->endOfWeek()
                    ),
                    default => true,
                };
            });
        }

        // Paginasi manual karena data sudah difilter
        $total = $allData->count();
        $laporan = $allData->slice(($page - 1) * $entries, $entries)->values();
        $laporan = new LengthAwarePaginator($laporan, $total, $entries, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // dd($laporan);

        return view('admin_kecamatan.kirim.index', compact(
            'laporan',
            'search',
            'entries',
            'filterOption',
            'tanggal',
            'month',
            'tahun',
            'week',
            'months',
            'years',
            'weeks'
        ));
    }

    // public function index(Request $request)
    // {
    //     // Ambil input dari request dengan default value
    //     $search = $request->input('search');
    //     $entries = $request->input('entries', 10);
    //     $page = $request->input('page', 1);
    //     $filterOption = $request->input('filter_option', 'all');
    //     $tanggal = $request->input('tanggal');
    //     $month = $request->input('month');
    //     $tahun = $request->input('tahun');
    //     $week = $request->input('week');
    //     $cari = $request->input('cari');
    //     $lembar = $request->input('lembar', 10);
    //     $halaman = $request->input('halaman', 1);

    //     // Validasi input filter
    //     $tanggal = $tanggal ? Carbon::parse($tanggal)->startOfDay() : null;
    //     $month = is_numeric($month) && $month >= 1 && $month <= 12 ? (int)$month : null;
    //     $tahun = is_numeric($tahun) && $tahun >= 1900 && $tahun <= now()->year ? (int)$tahun : null;
    //     $week = is_numeric($week) && $week >= 1 && $week <= 53 ? (int)$week : null;

    //     // Ambil file PDF dari storage
    //     $laporanPdf = collect(Storage::files('public/admin_kecamatan/laporan/pdf'))
    //         ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
    //         ->map(function ($file) {
    //             return [
    //                 'filename' => basename($file),
    //                 'filename_without_ext' => pathinfo($file, PATHINFO_FILENAME),
    //                 'filepath_pdf' => $file,
    //                 'created_at' => Carbon::createFromTimestamp(Storage::lastModified($file)),
    //                 'size' => Storage::size($file) / 1024, // Ukuran dalam KB
    //             ];
    //         })->keyBy('filename_without_ext');

    //     // Ambil file Excel dari storage
    //     $laporanExcel = collect(Storage::files('public/admin_kecamatan/laporan/excel'))
    //         ->filter(fn($file) => in_array(pathinfo($file, PATHINFO_EXTENSION), ['xlsx', 'xls']))
    //         ->map(function ($file) {
    //             return [
    //                 'filename_without_ext' => pathinfo($file, PATHINFO_FILENAME),
    //                 'filepath_excel' => $file,
    //             ];
    //         })->keyBy('filename_without_ext');

    //     // Ambil data dari database pengirimaninfaqs
    //     $dbPengiriman = PengirimanInfaq::orderByDesc('created_at')->get()->keyBy(function ($item) {
    //         try {
    //             $fileKirim = json_decode($item->file_kirim, true);
    //             if (is_array($fileKirim) && isset($fileKirim[0])) {
    //                 return pathinfo(basename($fileKirim[0]), PATHINFO_FILENAME);
    //             }
    //             Log::warning('Invalid file_kirim format for ID: ' . $item->id, ['file_kirim' => $item->file_kirim]);
    //             return null;
    //         } catch (\Exception $e) {
    //             Log::error('Error decoding file_kirim for ID: ' . $item->id, ['error' => $e->getMessage()]);
    //             return null;
    //         }
    //     })->filter(fn($item) => $item !== null); // Filter key null

    //     // Gabungkan data PDF, Excel, dan database
    //     $laporan = $laporanPdf->map(function ($pdf) use ($laporanExcel, $dbPengiriman) {
    //         $filenameWithoutExt = $pdf['filename_without_ext'];
    //         $excel = $laporanExcel->get($filenameWithoutExt);
    //         $dbData = $dbPengiriman->get($filenameWithoutExt);

    //         return (object) [
    //             'filename' => $pdf['filename'],
    //             'filepath_pdf' => $pdf['filepath_pdf'],
    //             'filepath_excel' => $excel['filepath_excel'] ?? null,
    //             'created_at' => $pdf['created_at'],
    //             'size' => $pdf['size'],
    //             'tglKirim' => $dbData->tglKirim ?? null,
    //             'namaPenerima' => $dbData->namaPenerima ?? null,
    //             'status' => $dbData->status ?? null,
    //         ];
    //     })->values();

    //     // Filter berdasarkan opsi
    //     if ($filterOption !== 'all') {
    //         $laporan = $laporan->filter(function ($file) use ($filterOption, $tanggal, $month, $tahun, $week) {
    //             $fileDate = $file->created_at;
    //             return match ($filterOption) {
    //                 'day' => $tanggal && $fileDate->isSameDay($tanggal),
    //                 'month' => $month && $tahun && $fileDate->year == $tahun && $fileDate->month == $month,
    //                 'year' => $tahun && $fileDate->year == $tahun,
    //                 'week' => $week && $tahun && $fileDate->between(
    //                     Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1),
    //                     Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1)->endOfWeek()
    //                 ),
    //                 default => true,
    //             };
    //         })->values();
    //     }

    //     // Filter berdasarkan pencarian
    //     if ($search) {
    //         $laporan = $laporan->filter(function ($file) use ($search) {
    //             return stripos($file->filename, $search) !== false ||
    //                 stripos($file->namaPenerima ?? '', $search) !== false ||
    //                 stripos($file->status ?? '', $search) !== false;
    //         })->values();
    //     }

    //     // Paginate koleksi
    //     $total = $laporan->count();
    //     $laporan = $laporan->slice(($page - 1) * $entries, $entries)->values();
    //     $laporan = new LengthAwarePaginator($laporan, $total, $entries, $page, [
    //         'path' => $request->url(),
    //         'query' => $request->query(),
    //     ]);

    //     // Data untuk dropdown filter
    //     $months = collect(range(1, 12))->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')]);
    //     $years = range(now()->year, now()->year - 10);
    //     $weeks = range(1, 53);

    //     // Log untuk debugging
    //     Log::info('Paginasi Data Laporan', [
    //         'total' => $laporan->total(),
    //         'per_page' => $laporan->perPage(),
    //         'current_page' => $laporan->currentPage(),
    //         'filter' => compact('filterOption', 'tanggal', 'month', 'tahun', 'week'),
    //         'search' => $search,
    //         'laporan_count' => $laporan->count(),
    //     ]);

    //     dd($laporan);

    //     return view('admin_kecamatan.kirim.index', compact(
    //         'laporan',
    //         'search',
    //         'entries',
    //         'filterOption',
    //         'tanggal',
    //         'month',
    //         'tahun',
    //         'week',
    //         'months',
    //         'years',
    //         'weeks',
    //         'cari',
    //         'lembar'
    //     ));
    // }

    public function tampil()
    {
        $adminKecamatan = User::where('role', 'admin_kecamatan')
            ->where('status', 'A')
            ->first();

        $adminKabupaten = User::where('role', 'admin_kabupaten')
            ->where('status', 'A')
            ->first();

        $kecamatan = Db_kecamatan::where('status', 'Aktif')->first();

        // dd($diri);

        return view('admin_kecamatan.kirim.tampil', compact('kecamatan', 'adminKecamatan', 'adminKabupaten'));
    }

    public function deleteLaporan(Request $request, $filename)
    {
        // Direktori dan path file
        $directory = 'public/admin_kecamatan/laporan/excel';
        $filepath = $directory . '/' . $filename;

        // Pastikan file ada dan hapus
        if (Storage::exists($filepath)) {
            Storage::delete($filepath);
            Log::info('File dihapus: ' . storage_path('app/' . $filepath));
            return redirect()->route('admin_kecamatan.info-kirim')->with('success', 'File berhasil dihapus.');
        }

        return redirect()->route('admin_kecamatan.info-kirim')->with('error', 'File tidak ditemukan.');
    }
}
