<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $this->from = env('TWILIO_WHATSAPP_FROM');
    }

    public function sendWhatsAppMessage($to, $body, $mediaUrl = null)
    {
        try {
            $messageParams = [
                'from' => $this->from,
                'body' => $body,
            ];

            if ($mediaUrl) {
                // Validasi ringan agar URL terlihat valid tanpa menyebabkan timeout
                if (filter_var($mediaUrl, FILTER_VALIDATE_URL) && str_ends_with($mediaUrl, '.pdf')) {
                    $messageParams['mediaUrl'] = [$mediaUrl];
                } else {
                    Log::warning("Invalid or unsupported media URL: $mediaUrl");
                    return [
                        'success' => false,
                        'error' => 'Invalid or unsupported media URL.'
                    ];
                }
            }

            $message = $this->client->messages->create(
                "whatsapp:$to",
                $messageParams
            );

            return [
                'success' => true,
                'sid' => $message->sid
            ];
        } catch (\Twilio\Exceptions\TwilioException $e) {
            Log::error('Twilio WhatsApp Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
