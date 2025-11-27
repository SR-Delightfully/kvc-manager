<?php

namespace App\Helpers;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class AuthHelper
{
    private Client $client;
    private string $fromNumber;
    private string $verifyServiceSid;

    public function __construct()
    {
        $config = $settings['twilio'] ?? [];

        //load credentials from env.php
        $sid               = $config['sid'] ?? '';
        $token             = $config['token'] ?? '';
        $this->fromNumber  = $config['from'] ?? '';
        $this->verifyServiceSid = $config['verify_sid'] ?? '';

        $this->client = new Client($sid, $token);
    }

    public function sendMessage(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->fromNumber,
                'body' => $message
            ]);
            return true;
        } catch (RestException $e) {
            error_log("Twilio SMS Error: " . $e->getMessage());
            return false;
        }
    }

    //send SMS 2fa verification code
    public function sendVerificationCode(string $to): bool
    {
        try {
            $this->client->verify->v2
                ->services($this->verifyServiceSid)
                ->verifications
                ->create($to, "sms");

            return true;
        } catch (RestException $e) {
            error_log("Twilio Verify Send Error: " . $e->getMessage());
            return false;
        }
    }

    //send email 2fa verification code
    public function sendEmailVerificationCode(string $email): bool
    {
        try {
            $this->client->verify->v2
                ->services($this->verifyServiceSid)
                ->verifications
                ->create($email, "email");

            return true;
        } catch (RestException $e) {
            error_log("Twilio Verify Email Send Error: " . $e->getMessage());
            return false;
        }
    }

    //verifies 2fa code, used for email and SMS
    public function checkVerificationCode(string $to, string $code): bool
    {
        try {
            $result = $this->client->verify->v2
                ->services($this->verifyServiceSid)
                ->verificationChecks
                ->create([
                    "to"   => $to,
                    "code" => $code
                ]);

            return $result->status === "approved";
        } catch (RestException $e) {
            error_log("Twilio Verify Check Error: " . $e->getMessage());
            return false;
        }
    }
}
?>




<?php
/*
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
    require_once 'vendor/autoload.php';
    $sid    = "";
    $token  = "";
    $twilio = new Client($sid, $token);
    $message = $twilio->messages
      ->create("", // to
        array(
          "from" => "",
          "body" => "testing twilio"
        )
      );
print($message->sid);
?>
*/
