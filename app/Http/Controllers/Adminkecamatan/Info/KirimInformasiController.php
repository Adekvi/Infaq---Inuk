<?php

namespace App\Http\Controllers\Adminkecamatan\Info;

use App\Http\Controllers\Controller;
use App\Models\Pesan\WhatsappLog;
use App\Models\User;
use App\Models\Pesan\WhastappLog;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KirimInformasiController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin_kecamatan') {
                abort(403, 'Akses ditolak. Hanya petugas yang diizinkan.');
            }
            return $next($request);
        });
    }

    private function formatPhoneNumber($no_hp)
    {
        if (empty($no_hp)) {
            return null;
        }

        // Jika nomor sudah dalam format +62 dan valid, kembalikan langsung
        if (preg_match('/^\+62\d{10,13}$/', $no_hp)) {
            return $no_hp;
        }

        // Hilangkan spasi, tanda hubung, dan karakter non-digit
        $no_hp = preg_replace('/\D/', '', $no_hp);

        // Jika nomor diawali dengan "0", hapus "0"
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = substr($no_hp, 1);
        }

        // Tambahkan +62
        $no_hp = '+62' . $no_hp;

        // Validasi panjang nomor (10-13 digit setelah +62)
        if (preg_match('/^\+62\d{10,13}$/', $no_hp)) {
            return $no_hp;
        }

        return null;
    }

    public function sendWhatsApp(Request $request)
    {
        Log::info('Memulai proses pengiriman WhatsApp.', [
            'user_ids' => $request->input('user_ids'),
            'filename' => $request->input('filename'),
            'message_length' => strlen($request->input('message')),
        ]);

        // Validasi input
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'message' => 'required|string|max:1600',
            'filename' => 'required|string|regex:/^[a-zA-Z0-9_\-\.]+\.pdf$/',
        ]);

        $userIds = $request->input('user_ids');
        $message = $request->input('message');
        $filename = $request->input('filename');
        $filepath = 'public/laporan/' . $filename;

        // Validasi file PDF
        Log::info('Memeriksa keberadaan file PDF.', ['filepath' => $filepath]);
        if (!Storage::exists($filepath)) {
            Log::error('File PDF tidak ditemukan.', ['filepath' => $filepath]);
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        if (Storage::size($filepath) > 16 * 1024 * 1024) { // 16MB
            Log::error('Ukuran file PDF melebihi batas 16MB.', ['size' => Storage::size($filepath)]);
            return redirect()->back()->with('error', 'Ukuran file PDF melebihi batas 16MB untuk WhatsApp.');
        }

        // Buat URL publik untuk file PDF
        $mediaUrl = 'https://2c4584481b18.ngrok-free.app/storage/laporan/' . $filename;
        // $mediaUrl = asset('storage/laporan/' . $filename);
        Log::info('URL publik untuk file PDF dibuat.', ['mediaUrl' => $mediaUrl]);

        // Ambil pengguna dengan role admin_kabupaten
        $users = User::whereIn('id', $userIds)
            ->where('role', 'admin_kabupaten')
            ->get();

        if ($users->isEmpty()) {
            Log::error('Tidak ada pengguna valid yang dipilih.', ['user_ids' => $userIds]);
            return redirect()->back()->with('error', 'Tidak ada pengguna valid yang dipilih.');
        }

        $results = [];
        foreach ($users as $user) {
            Log::info('Memproses pengiriman untuk pengguna.', [
                'id_user' => $user->id,
                'username' => $user->username,
                'no_hp' => $user->no_hp,
            ]);

            // Format nomor telepon
            $toNumber = $this->formatPhoneNumber($user->no_hp);
            if (!$toNumber) {
                $results[] = [
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'status' => 'failed',
                    'error' => 'Nomor WhatsApp tidak valid.'
                ];

                WhatsappLog::create([
                    'id_user' => $user->id,
                    'to_number' => $user->no_hp ?? 'unknown',
                    'message' => $message,
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'status' => 'failed',
                    'twilio_sid' => null,
                    'error_message' => 'Nomor WhatsApp tidak valid.',
                ]);

                Log::warning('Pengiriman gagal karena nomor tidak valid.', [
                    'id_user' => $user->id,
                    'username' => $user->username,
                ]);
                continue;
            }

            // Kirim pesan WhatsApp
            try {
                Log::info('Mengirim pesan WhatsApp.', [
                    'to_number' => $toNumber,
                    'message' => $message,
                    'mediaUrl' => $mediaUrl,
                ]);

                $response = $this->twilioService->sendWhatsAppMessage($toNumber, $message, $mediaUrl);

                // Simpan log pengiriman
                WhatsappLog::create([
                    'id_user' => $user->id,
                    'to_number' => $toNumber,
                    'message' => $message,
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'status' => $response['success'] ? 'sent' : 'failed',
                    'twilio_sid' => $response['success'] ? $response['sid'] : null,
                    'error_message' => $response['success'] ? null : $response['error'],
                ]);

                $results[] = [
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'status' => $response['success'] ? 'sent' : 'failed',
                    'error' => $response['success'] ? null : $response['error']
                ];

                Log::info('Pengiriman selesai.', [
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'status' => $response['success'] ? 'sent' : 'failed',
                    'twilio_sid' => $response['success'] ? $response['sid'] : null,
                ]);
            } catch (\Exception $e) {
                $errorMessage = 'Gagal mengirim pesan: ' . $e->getMessage();
                Log::error($errorMessage, [
                    'to_number' => $toNumber,
                    'id_user' => $user->id,
                    'username' => $user->username,
                ]);

                $results[] = [
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'status' => 'failed',
                    'error' => $errorMessage
                ];

                WhatsappLog::create([
                    'id_user' => $user->id,
                    'to_number' => $toNumber,
                    'message' => $message,
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'status' => 'failed',
                    'twilio_sid' => null,
                    'error_message' => $errorMessage,
                ]);
            }
        }

        // Berikan feedback berdasarkan hasil
        $successCount = count(array_filter($results, fn($result) => $result['status'] === 'sent'));
        $failedCount = count($results) - $successCount;

        Log::info('Hasil pengiriman WhatsApp.', [
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'total_users' => count($results),
        ]);

        if ($successCount === count($results)) {
            return redirect()->back()->with('success', 'Pesan berhasil dikirim ke ' . $successCount . ' pengguna.');
        } elseif ($failedCount === count($results)) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan ke semua pengguna.');
        } else {
            return redirect()->back()->with('warning', "Pesan berhasil dikirim ke $successCount pengguna, tetapi gagal untuk $failedCount pengguna.");
        }
    }

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
        $cari = $request->input('cari');
        $lembar = $request->input('lembar', 10);
        $halaman = $request->input('halaman', 1);

        // Validasi input filter
        $tanggal = $tanggal ? Carbon::parse($tanggal)->startOfDay() : null;
        $month = is_numeric($month) && $month >= 1 && $month <= 12 ? (int)$month : null;
        $tahun = is_numeric($tahun) && $tahun >= 1900 && $tahun <= now()->year ? (int)$tahun : null;
        $week = is_numeric($week) && $week >= 1 && $week <= 53 ? (int)$week : null;

        // Ambil file PDF dari storage
        $laporanPdf = collect(Storage::files('public/admin_kecamatan/laporan/pdf'))
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
            ->map(function ($file) {
                return [
                    'filename' => basename($file),
                    'filename_without_ext' => pathinfo($file, PATHINFO_FILENAME), // Nama file tanpa ekstensi
                    'filepath_pdf' => $file,
                    'created_at' => Carbon::createFromTimestamp(Storage::lastModified($file)),
                    'size' => Storage::size($file) / 1024, // Ukuran dalam KB
                ];
            });

        // Ambil file Excel dari storage
        $laporanExcel = collect(Storage::files('public/admin_kecamatan/laporan/excel'))
            ->filter(fn($file) => in_array(pathinfo($file, PATHINFO_EXTENSION), ['xlsx', 'xls']))
            ->map(function ($file) {
                return [
                    'filename_without_ext' => pathinfo($file, PATHINFO_FILENAME), // Nama file tanpa ekstensi
                    'filepath_excel' => $file,
                ];
            })->keyBy('filename_without_ext'); // Index berdasarkan nama file tanpa ekstensi

        // Gabungkan data PDF dan Excel
        $laporan = $laporanPdf->map(function ($pdf) use ($laporanExcel) {
            $excel = $laporanExcel->get($pdf['filename_without_ext']);
            return [
                'filename' => $pdf['filename'],
                'filepath_pdf' => $pdf['filepath_pdf'],
                'filepath_excel' => $excel ? $excel['filepath_excel'] : null, // Tambahkan filepath_excel jika ada
                'created_at' => $pdf['created_at'],
                'size' => $pdf['size'],
            ];
        });

        // Filter berdasarkan opsi
        if ($filterOption !== 'all') {
            $laporan = $laporan->filter(function ($file) use ($filterOption, $tanggal, $month, $tahun, $week) {
                $fileDate = $file['created_at'];
                return match ($filterOption) {
                    'day' => $tanggal && $fileDate->isSameDay($tanggal),
                    'month' => $month && $tahun && $fileDate->year == $tahun && $fileDate->month == $month,
                    'year' => $tahun && $fileDate->year == $tahun,
                    'week' => $week && $tahun && $fileDate->between(
                        Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1),
                        Carbon::create($tahun, 1, 1)->startOfWeek()->addWeeks($week - 1)->endOfWeek()
                    ),
                    default => true,
                };
            });
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $laporan = $laporan->filter(fn($file) => stripos($file['filename'], $search) !== false);
        }

        // Paginate koleksi
        $total = $laporan->count();
        $laporan = $laporan->slice(($page - 1) * $entries, $entries)->values();
        $laporan = new LengthAwarePaginator($laporan, $total, $entries, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);


        // Data untuk dropdown filter
        $months = collect(range(1, 12))->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')]);
        $years = range(now()->year, now()->year - 10);
        $weeks = range(1, 53);

        // Query untuk user admin
        $useradmin = User::whereIn('role', ['admin_kabupaten'])
            ->when($cari, fn($q) => $q->where('id', 'LIKE', "%{$cari}%")
                ->orWhere('username', 'LIKE', "%{$cari}%")
                ->orWhere('no_hp', 'LIKE', "%{$cari}%"))
            ->orderByDesc('id')
            ->paginate($lembar, ['*'], 'halaman', $halaman)
            ->appends(['cari' => $cari, 'lembar' => $lembar]);

        // dd($laporan);
        // Log untuk debugging
        Log::info('Paginasi Data Laporan', [
            'total' => $laporan->total(),
            'per_page' => $laporan->perPage(),
            'current_page' => $laporan->currentPage(),
            'filter' => compact('filterOption', 'tanggal', 'month', 'tahun', 'week'),
            'search' => $search,
        ]);

        return view('admin_kecamatan.info.index', compact(
            'useradmin',
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
            'cari',
            'lembar'
        ));
    }

    public function deleteLaporan(Request $request, $filename)
    {
        // Direktori dan path file
        $directory = 'public/admin_kecamatan/laporan/pdf';
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
