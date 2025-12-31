<?php

namespace App\Helpers;

class ShopifyHelper
{
    public static function verifyHmac(array $query, string $secret): bool
    {
        if (!isset($query['hmac'])) {
            return false;
        }

        $hmac = $query['hmac'];
        unset($query['hmac'], $query['signature']);

        ksort($query);

        $computedHmac = hash_hmac(
            'sha256',
            urldecode(http_build_query($query)),
            $secret
        );

        return hash_equals($hmac, $computedHmac);
    }
}
