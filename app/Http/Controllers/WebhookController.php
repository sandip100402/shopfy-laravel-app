<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Log;


class WebhookController extends Controller
{
    public function appUninstalled(Request $request)
    {
       
        Log::info('Webhook HMAC debug');
            
        $shop = $request->header('X-Shopify-Shop-Domain');

        Shop::where('shop', $shop)->delete();

        return response()->json(['status' => 'deleted'], 200);
    }
}
