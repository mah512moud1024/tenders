<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from');

        if ($sid && $token && $this->from) {
            $this->client = new Client($sid, $token);
        } else {
            Log::error('Twilio credentials are not configured.');
        }
    }

    public function sendSms($to, $message)
    {
        if (!$this->client) {
            return false; // Or throw an exception
        }

        try {
            $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );
            return true;
        } catch (\Exception $e) {
            Log::error('Twilio SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
