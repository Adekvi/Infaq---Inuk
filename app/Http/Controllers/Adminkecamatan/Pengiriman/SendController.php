<?php

namespace App\Http\Controllers\Adminkecamatan\Pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Pesan\WhatsappLog;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SendController extends Controller
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
        Log::info('Mulai kirim WhatsApp.', ['input' => $request->all()]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'tglKirim' => 'required|date',
            'namaPengirim' => 'required|string|max:255',
            'namaPenerima' => 'required|string|max:255',
            'no_hp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'nama_kecamatan' => 'required|string|max:255',
            'pesan' => 'nullable|string|max:1600',
            'file_kirim' => 'required|file|mimes:pdf,xls,xlsx|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file_kirim');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $file->getClientOriginalName());

        // Simpan file sementara ke public/temp
        $tempPath = 'temp/' . $filename;
        Storage::disk('public')->put($tempPath, file_get_contents($file));

        // URL publik sementara
        $mediaUrl = asset('storage/' . $tempPath);
        if (strpos($mediaUrl, 'http://') === 0) {
            $mediaUrl = str_replace('http://', 'https://', $mediaUrl);
        }

        $tanggalKirim = Carbon::parse($request->tglKirim)->translatedFormat('d F Y');

        // Pesan WhatsApp
        $pesan = $request->pesan ??
            "Assalamuallaikum Wr. Wb.\n" .
            "Saya *{$request->namaPengirim}* dari kecamatan *{$request->nama_kecamatan}* melampirkan dokumen:\n" .
            "📅 Tanggal: {$tanggalKirim}\n" .
            "📎 File: {$filename}\n" .
            "Mohon dicek dan ditindaklanjuti.\nTerima kasih.";

        $to = $this->formatPhoneNumber($request->no_hp);

        if (!$to) {
            return back()->with('error', 'Nomor WhatsApp tidak valid.');
        }

        try {
            $response = $this->twilioService->sendWhatsAppMessage($to, $pesan, $mediaUrl);

            // Hapus file temp setelah kirim
            Storage::disk('public')->delete($tempPath);

            // Catat log
            WhatsappLog::create([
                'id_user' => Auth::id(),
                'to_number' => $to,
                'message' => $pesan,
                'filename' => $filename,
                'filepath' => $tempPath,
                'status' => $response['success'] ? 'sent' : 'failed',
                'twilio_sid' => $response['sid'] ?? null,
                'error_message' => $response['error'] ?? null,
            ]);

            return $response['success']
                ? redirect()->route('admin_kecamatan.info-kirim')->with('success', 'Pesan berhasil dikirim.')
                : back()->with('error', 'Gagal mengirim: ' . $response['error']);
        } catch (\Exception $e) {
            Log::error('Error WhatsApp: ' . $e->getMessage());

            return back()->with('error', 'Gagal mengirim: ' . $e->getMessage());
        }
    }

    // public function sendWhatsApp(Request $request)
    // {
    //     Log::info('Memulai proses pengiriman WhatsApp.', [
    //         'input' => $request->all(),
    //     ]);

    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'tglKirim' => 'required|date',
    //         'namaPengirim' => 'required|string|max:255',
    //         'namaPenerima' => 'required|string|max:255',
    //         'no_hp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    //         'nama_kecamatan' => 'required|string|max:255',
    //         'pesan' => 'nullable|string|max:1600',
    //         'file_kirim' => 'nullable|file|mimes:pdf,jpeg,png,gif|max:10240',
    //     ]);

    //     if ($validator->fails()) {
    //         Log::error('Validasi gagal.', ['errors' => $validator->errors()]);
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Format nomor
    //     $toNumber = $this->formatPhoneNumber($request->no_hp);
    //     if (!$toNumber) {
    //         Log::error('Nomor WhatsApp tidak valid.', ['no_hp' => $request->no_hp]);
    //         return redirect()->back()->with('error', 'Nomor WhatsApp tidak valid.');
    //     }

    //     // Simpan file
    //     $file = $request->file('file_kirim');
    //     $filename = time() . '_' . $file->getClientOriginalName();
    //     $filepath = $file->storeAs('uploads', $filename, 'public');

    //     if (!$filepath) {
    //         Log::error('Gagal menyimpan file.', ['filename' => $filename]);
    //         return redirect()->back()->with('error', 'Gagal menyimpan file.');
    //     }

    //     // Buat mediaUrl
    //     $mediaUrl = env('PUBLIC_URL') . Storage::url($filepath);
    //     Log::info('URL publik untuk file dibuat.', ['mediaUrl' => $mediaUrl]);

    //     // Set pesan default jika tidak ada input
    //     $pesan = $request->pesan ?? "Assalamuallaikum Wr, Wb. Admin Kabupaten,\n" .
    //         "Mohon Maaf mengganggu waktunya,\n" .
    //         "Sebagai laporan, saya *{$request->namaPengirim}* dari ranting/kecamatan *{$request->nama_kecamatan}* melampirkan sebanyak dokumen data dengan rincian sebagai berikut,\n" .
    //         " -\n -\n -\n" .
    //         "Mohon untuk dapat dicek dan ditindaklanjuti.\nTerima kasih. 🙏\n\n" .
    //         "Wassalamu'alaikum Wr. Wb.";

    //     // Kirim WhatsApp via Twilio
    //     try {
    //         Log::info('Mengirim pesan WhatsApp.', [
    //             'to_number' => $toNumber,
    //             'message' => $pesan,
    //             'mediaUrl' => $mediaUrl,
    //         ]);

    //         $response = $this->twilioService->sendWhatsAppMessage(
    //             $toNumber,
    //             $pesan,
    //             'https://limewire.com/d/p1MMp#lfMObflOQX'
    //             // null
    //         );

    //         if (!$response['success']) {
    //             Log::error('Gagal mengirim pesan WhatsApp.', ['error' => $response['error']]);
    //             return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $response['error']);
    //         }

    //         // ✅ Kirim berhasil → simpan ke DB
    //         $pengiriman = PengirimanInfaq::create([
    //             'id_user' => Auth::user()->id,
    //             'nama_kecamatan' => $request->nama_kecamatan,
    //             'namaPengirim' => $request->namaPengirim,
    //             'namaPenerima' => $request->namaPenerima,
    //             'no_hp' => $toNumber,
    //             'tglKirim' => $request->tglKirim,
    //             'pesan' => $pesan,
    //             'file_kirim' => $filepath,
    //             'status' => 'sent',
    //         ]);

    //         WhatsappLog::create([
    //             'id_user' => Auth::user()->id,
    //             'to_number' => $toNumber,
    //             'message' => $pesan,
    //             'filename' => $filename,
    //             'filepath' => $filepath,
    //             'status' => 'sent',
    //             'twilio_sid' => $response['sid'],
    //             'error_message' => null,
    //         ]);

    //         return redirect()->route('admin_kecamatan.info-kirim')->with('success', 'Pesan dan dokumen berhasil dikirim.');
    //     } catch (\Exception $e) {
    //         $errorMessage = 'Gagal mengirim pesan: ' . $e->getMessage();
    //         Log::error($errorMessage, ['to_number' => $toNumber]);

    //         // Jangan simpan ke DB jika gagal
    //         return redirect()->back()->with('error', $errorMessage);
    //     }
    // }
}
