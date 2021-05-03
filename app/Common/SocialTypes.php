<?php

namespace App\Common;

class SocialTypes
{
    const GITHUB = 'github';
    const GOOGLE = 'google';

    public static function has(string $type): bool
    {
        return in_array( $type,[
            self::GITHUB,
            self::GOOGLE,
        ]);
    }
}

