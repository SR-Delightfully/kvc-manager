<?php

namespace App\Helpers;

class RegistrationCodeHelper
{
    private static ?string $cachedCode = null;
    private static ?string $cachedWeek = null;

    //returns code
    public static function getWeeklyCode(): string
    {
        $currentWeek = date('o-W'); // e.g. "2025-12"
        $secret      = $_ENV['REG_CODE_SECRET'] ?? 'some-fixed-secret';

        // create a hash based on (secret + week)
        $hash = hash('sha256', $secret . $currentWeek);

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code  = '';

        // use first 6 bytes of the hash to build a 6-char code
        for ($i = 0; $i < 6; $i++) {
            $byte   = hexdec(substr($hash, $i * 2, 2)); // 0–255
            $index  = $byte % strlen($chars);
            $code  .= $chars[$index];
        }

        return $code;
    }

    //generates random 6 length code
    private static function generateCode(int $length): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $code;
    }
}
