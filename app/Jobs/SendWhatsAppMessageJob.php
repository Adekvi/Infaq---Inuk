<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;
    protected $mediaUrl;

    public function __construct($phone, $message, $mediaUrl = null)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->mediaUrl = $mediaUrl;
    }

    public function handle(FonnteService $fonnteService)
    {
        $response = $fonnteService->sendWhatsAppMessage($this->phone, $this->message, $this->mediaUrl);
        if (!$response) {
            Log::error('Gagal mengirim pesan WhatsApp', [
                'phone' => $this->phone,
                'message' => $this->message,
                'mediaUrl' => $this->mediaUrl,
                'response' => $response // Tambahkan log respons
            ]);
        } else {
            Log::info('Pesan WhatsApp berhasil dikirim', [
                'phone' => $this->phone,
                'mediaUrl' => $this->mediaUrl,
                'response' => $response // Tambahkan log respons
            ]);
        }
    }
}
