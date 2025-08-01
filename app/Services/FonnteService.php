<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    public function sendWhatsAppMessage($to, $message, $fileUrl = null)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $params = [
                'target' => $to,
                'message' => $message,
            ];

            // Tambahkan URL file jika ada
            if ($fileUrl) {
                $params['file'] = $fileUrl;
            }

            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'form_params' => $params,
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info('Fonnte Response:', $result);

            // Kembalikan true hanya jika status sukses
            return isset($result['status']) && $result['status'] === true;
        } catch (\Exception $e) {
            Log::error('Error mengirim pesan WhatsApp: ' . $e->getMessage(), [
                'target' => $to,
                'message' => $message,
                'fileUrl' => $fileUrl
            ]);
            return false;
        }
    }
}
