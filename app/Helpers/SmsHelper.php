<?php

namespace App\Helpers;

class SmsHelper
{
    public function sendVerificationCode(string $phone): bool
    {
        // TODO: implement SMS sending logic
        return true;
    }

    public function checkVerificationCode(string $phone, string $code): bool
    {
        // TODO: implement SMS code checking logic
        return true;
    }
}
