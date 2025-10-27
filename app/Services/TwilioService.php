<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $from;
    protected $verifySid;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from');
        $this->verifySid = env('TWILIO_VERIFY_SID');

        if ($sid && $token) {
            $this->client = new Client($sid, $token);
        } else {
            Log::error('Twilio credentials are not configured.');
        }
    }

    /**
     * Old direct SMS sending (not recommended for verification).
     */
    public function sendSms($to, $message)
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Twilio SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * ✅ Send a verification code via Verify API
     */
    public function sendVerificationCode($to)
    {
        try {
            $this->client->verify->v2->services($this->verifySid)
                ->verifications
                ->create($to, 'sms' ,  ["'channel_configuration' => [
                        'sms' => [
                            'enable_whatsapp' => false
                        ]"]);
            return true;
        } catch (\Exception $e) {
            Log::error('Twilio Verify send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * ✅ Check the verification code entered by the user
     */
    public function checkVerificationCode($to, $code)
    {
        try {
            $verification = $this->client->verify->v2->services($this->verifySid)
                ->verificationChecks
                ->create([
                    'to' => $to,
                    'code' => $code,
                ]);

            return $verification->status === 'approved';
        } catch (\Exception $e) {
            Log::error('Twilio Verify check failed: ' . $e->getMessage());
            return false;
        }
    }
}
