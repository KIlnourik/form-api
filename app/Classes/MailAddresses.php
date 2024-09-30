<?php

namespace App\Classes;

use Illuminate\Http\Request;

class MailAddresses
{
    const MAIL_DOMAIN = '@example.com';

    public static function getMailAddresses (
        Request $request,
        string $value,
        $isSpecial=false,
        bool $hasAddress=false
    ): array
    {
        $addresses = [];

        $hasAddress
            ? array_push($addresses, $request->get('address'))
            : array_push($addresses, $value . self::MAIL_DOMAIN);

        $isSpecial && array_push($addresses, 'special' . self::MAIL_DOMAIN);

        return $addresses;
    }
}
