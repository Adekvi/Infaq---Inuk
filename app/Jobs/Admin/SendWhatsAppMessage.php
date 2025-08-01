<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pesan\WhatsappLog;
use App\Models\Role\Transaksi\PengirimanInfaq;
use App\Services\FonnteService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;
    protected $fileUrl;
    protected $filename;
    protected $tempPath;
    protected $requestData;

    public function __construct($to, $message, $fileUrl, $filename, $tempPath, $requestData)
    {
        $this->to = $to;
        $this->message = $message;
        $this->fileUrl = $fileUrl;
        $this->filename = $filename;
        $this->tempPath = $tempPath;
        $this->requestData = $requestData;
    }

    public function handle(FonnteService $fonnte)
    {
        $client = new Client();
        $success = false;

        try {
            $params = [
                'target' => $this->to,
                'message' => $this->message,
            ];

            if ($this->fileUrl) {
                $params['file'] = $this->fileUrl; // Pastikan ini URL publik
            }

            Log::info('Mengirim pesan ke Fonnte', ['params' => $params]);

            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => env('FONNTE_TOKEN'),
                ],
                'form_params' => $params,
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info('Fonnte Response:', $result);
            $success = isset($result['status']) && $result['status'] === true;

            // Simpan ke database
            PengirimanInfaq::create([
                'id_user' => Auth::id(),
                'nama_kecamatan' => $this->requestData['nama_kecamatan'],
                'namaPengirim' => $this->requestData['namaPengirim'],
                'namaPenerima' => $this->requestData['namaPenerima'],
                'no_hp' => $this->to,
                'tglKirim' => $this->requestData['tglKirim'],
                'pesan' => $this->message,
                'file_kirim' => $this->filename,
                'status' => $success ? 'sent' : 'failed',
            ]);

            WhatsappLog::create([
                'id_user' => Auth::id(),
                'to_number' => $this->to,
                'message' => $this->message,
                'filename' => $this->filename,
                'filepath' => $this->tempPath,
                'status' => $success ? 'sent' : 'failed',
                'twilio_sid' => null,
                'error_message' => $success ? null : 'Gagal mengirim pesan via Fonnte',
            ]);
        } catch (\Exception $e) {
            Log::error('Error mengirim pesan WhatsApp: ' . $e->getMessage());

            PengirimanInfaq::create([
                'id_user' => Auth::id(),
                'nama_kecamatan' => $this->requestData['nama_kecamatan'],
                'namaPengirim' => $this->requestData['namaPengirim'],
                'namaPenerima' => $this->requestData['namaPenerima'],
                'no_hp' => $this->to,
                'tglKirim' => $this->requestData['tglKirim'],
                'pesan' => $this->message,
                'file_kirim' => $this->filename,
                'status' => 'failed',
            ]);

            WhatsappLog::create([
                'id_user' => Auth::id(),
                'to_number' => $this->to,
                'message' => $this->message,
                'filename' => $this->filename,
                'filepath' => $this->tempPath,
                'status' => 'failed',
                'twilio_sid' => null,
                'error_message' => 'Gagal mengirim: ' . $e->getMessage(),
            ]);
        }

        // Hapus file sementara
        // if (Storage::disk('public')->exists($this->tempPath)) {
        //     Storage::disk('public')->delete($this->tempPath);
        // }
    }
}
