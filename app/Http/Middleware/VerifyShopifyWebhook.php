<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyShopifyWebhook
{
    
    public function handle(Request $request, Closure $next)
    {
        $shopifyHmac = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent(); // RAW body

        $calculatedHmac = base64_encode(
            hash_hmac(
                'sha256',
                $data,
                env('SHOPIFY_API_SECRET'),
                true
            )
        );
        if (!hash_equals($shopifyHmac, $calculatedHmac)) {
            Log::error('Webhook HMAC FAILED');
            abort(401, 'Invalid Shopify Webhook HMAC');
        }

        return $next($request);
    }
}
