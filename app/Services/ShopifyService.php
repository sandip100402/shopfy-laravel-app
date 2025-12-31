<?php

namespace App\Services;

use GuzzleHttp\Client;

class ShopifyService
{
    public static function registerAppUninstalledWebhook($shop, $accessToken)
    {
        $client = new Client();

        $response = $client->post(
            "https://{$shop}/admin/api/2024-01/webhooks.json",
            [
                'headers' => [
                    'X-Shopify-Access-Token' => $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'webhook' => [
                        'topic' => 'app/uninstalled',
                        'address' => env('APP_URL') . '/webhook/app-uninstalled',
                        'format' => 'json',
                    ],
                ],
            ]
        );

        return json_decode($response->getBody(), true);
    }
}
