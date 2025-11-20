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

        // If a new week has started, generate a new code.
        if (self::$cachedWeek !== $currentWeek) {
            self::$cachedWeek = $currentWeek;
            self::$cachedCode = self::generateCode(6);
        }

        return self::$cachedCode;
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
