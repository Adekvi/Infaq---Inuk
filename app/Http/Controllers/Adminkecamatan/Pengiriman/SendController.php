<?php

namespace App\Http\Controllers\AdminKecamatan\Pengiriman;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\SendWhatsAppMessage;
use App\Models\Role\Transaksi\PengirimanInfaq;
use App\Models\Pesan\WhatsappLog;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SendController extends Controller
{
    protected $fonnteService; // Ubah nama properti

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
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
        Log::info('Mulai kirim WhatsApp.', ['input' => $request->except('file_kirim')]);

        // Validasi
        $validator = Validator::make($request->all(), [
            'tglKirim'       => 'required|date',
            'namaPengirim'   => 'required|string|max:255',
            'namaPenerima'   => 'required|string|max:255',
            'no_hp'          => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'nama_kecamatan' => 'required|string|max:255',
            'pesan'          => 'nullable|string|max:1600',
            'file_kirim'     => 'nullable|file|mimes:pdf,xls,xlsx|max:10240',
        ]);

        if ($validator->fails()) {
            Log::info('Validasi gagal.', ['errors' => $validator->errors()->all()]);
            return back()->withErrors($validator)->withInput();
        }

        Log::info('Validasi berhasil.');

        $file = $request->file('file_kirim');
        $originalName = null;
        $filename = null;
        $tempPath = null;
        $fileUrl = null;

        if ($file) {
            $originalName = $file->getClientOriginalName(); // Misalnya: laporan_infaq.xlsx
            $timestamp = time();
            $filename = $timestamp . '_' . $originalName; // Simpan dengan nama unik namun tetap asli
            $tempPath = 'uploads/' . $filename;

            Log::info('Menyimpan file ke storage.', [
                'originalName' => $originalName,
                'filename' => $filename,
                'tempPath' => $tempPath
            ]);

            Storage::disk('public')->put($tempPath, file_get_contents($file));

            $appUrl = rtrim(config('app.url'), '/');
            $fileUrl = $appUrl . '/storage/' . $tempPath;

            Log::info('File URL disiapkan untuk pengiriman.', ['fileUrl' => $fileUrl]);
        } else {
            Log::info('Tidak ada file yang diupload.');
        }

        $tanggalKirim = Carbon::parse($request->tglKirim)->translatedFormat('d F Y');

        $pesan = $request->pesan ?? (
            "Assalamuallaikum Wr. Wb.\n" .
            "Saya *{$request->namaPengirim}* dari kecamatan *{$request->nama_kecamatan}* melampirkan dokumen:\n" .
            "📅 Tanggal: {$tanggalKirim}\n" .
            "📎 File: " . ($originalName ?? '[Tidak Ada File]') . "\n" .
            "Mohon dicek dan ditindaklanjuti.\nTerima kasih."
        );

        $to = $this->formatPhoneNumber($request->no_hp);

        if (!$to) {
            Log::warning('Nomor WhatsApp tidak valid.', ['no_hp' => $request->no_hp]);
            if ($tempPath) {
                Storage::disk('public')->delete($tempPath);
            }
            return back()->with('error', 'Nomor WhatsApp tidak valid.');
        }

        Log::info('Nomor tujuan sudah diformat.', ['to' => $to]);

        // Simpan data awal ke pengirimaninfaqs dengan status Pending
        Log::info('Menyimpan data awal ke pengirimaninfaqs.');
        $infaq = PengirimanInfaq::create([
            'id_user' => Auth::id(),
            'nama_kecamatan' => $request->nama_kecamatan,
            'namaPengirim' => $request->namaPengirim,
            'namaPenerima' => $request->namaPenerima,
            'no_hp' => $to,
            'tglKirim' => $request->tglKirim,
            'pesan' => $pesan,
            'file_kirim' => $filename,
            'status' => 'Pending',
        ]);

        try {
            Log::info('Mengirim pesan ke FonnteService...');
            $response = $this->fonnteService->sendWhatsAppMessage($to, $pesan, $fileUrl);
            Log::info('Response dari FonnteService diterima.', ['response' => $response]);

            $status = $response ? 'Terkirim' : 'Gagal';

            // Perbarui status di pengirimaninfaqs
            $infaq->update(['status' => $status]);

            // Simpan log ke WhatsappLog
            WhatsappLog::create([
                'id_user' => Auth::id(),
                'to_number' => $to,
                'message' => $pesan,
                'filename' => $filename,
                'filepath' => $tempPath,
                'status' => $status,
                'twilio_sid' => null,
                'error_message' => $status === 'Gagal' ? 'Gagal mengirim pesan via Fonnte' : null,
            ]);
            Log::info('WhatsappLog disimpan ke database.');

            // Hapus file setelah pengiriman
            if ($tempPath) {
                Log::info('Menghapus file.', ['path' => $tempPath]);
                Storage::disk('public')->delete($tempPath);
            }

            Log::info('Proses pengiriman selesai dengan status: ' . $status);

            return redirect()->route('admin_kecamatan.info-kirim')
                ->with('success', 'Pesan berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim pesan via Fonnte: ' . $e->getMessage(), [
                'to' => $to,
                'fileUrl' => $fileUrl
            ]);

            // Perbarui status ke Gagal
            $infaq->update(['status' => 'Gagal']);

            // Simpan log ke WhatsappLog
            WhatsappLog::create([
                'id_user' => Auth::id(),
                'to_number' => $to,
                'message' => $pesan,
                'filename' => $filename,
                'filepath' => $tempPath,
                'status' => 'Gagal',
                'twilio_sid' => null,
                'error_message' => 'Gagal mengirim: ' . $e->getMessage(),
            ]);

            // Hapus file jika ada
            if ($tempPath) {
                Log::info('Menghapus file setelah gagal.', ['path' => $tempPath]);
                Storage::disk('public')->delete($tempPath);
            }

            return back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }
}
