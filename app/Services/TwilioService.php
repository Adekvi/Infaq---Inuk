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

    public function sendWhatsAppMessage($to, $body)
    {
        try {
            $message = $this->client->messages->create(
                "whatsapp:$to",
                [
                    "from" => $this->from,
                    "body" => $body
                ]
            );
            return $message->sid;
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Error: ' . $e->getMessage());
            return false;
        }
    }
}
