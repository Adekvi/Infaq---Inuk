<?php

namespace App\Http\Controllers\AdminKecamatan\Pengiriman;

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
use Illuminate\Support\Facades\DB;
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

        $query = Pengirimaninfaq::where('status', 'Terkirim')->orderBy('id', 'asc')
            ->with('user');

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

        // dd($total);

        $kecamatan = Db_kecamatan::where('status', 'Aktif')->first();
        $totalDonasi = DB::table('penerimaans')
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $kecamatan->id) // sesuaikan kolomnya
            // ->where('penerimaans.status', 'Validasi')
            ->sum('penerimaans.nominal');

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
            'weeks',
            'totalDonasi'
        ));
    }

    public function tampil()
    {
        $user = Auth::user();

        // Ambil data admin dan kecamatan
        $adminKecamatan = User::where('role', 'admin_kecamatan')->where('status', 'A')->first();
        $adminKabupaten = User::where('role', 'admin_kabupaten')->where('status', 'A')->first();
        $kecamatan = Plotting::with('kecamatan')->where('id_user', $user->id)->first();

        // Cek jika kecamatan tersedia
        if (!$kecamatan) {
            return back()->with('error', 'Data kecamatan tidak ditemukan.');
        }

        // dd($kecamatan);

        // Hitung total donasi berdasarkan join ke tabel plottings
        $totalDonasi = DB::table('penerimaans')
            ->join('plottings', 'penerimaans.id_plot', '=', 'plottings.id')
            ->where('plottings.id_kecamatan', $kecamatan->id) // sesuaikan kolomnya
            // ->where('penerimaans.status', 'Kirim')
            ->sum('penerimaans.nominal');

        // dd($totalDonasi);

        return view('admin_kecamatan.kirim.tampil', compact('kecamatan', 'adminKecamatan', 'adminKabupaten', 'totalDonasi'));
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
