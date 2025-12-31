<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Helpers\ShopifyHelper;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\ShopifyService;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    public function index(Request $request)
    {
        // 1️⃣ Must come from Shopify (signed request)
        if (!$request->has(['shop', 'hmac', 'timestamp'])) {
            abort(403, 'Direct access not allowed');
        }
    
        // 2️⃣ Verify HMAC
        if (!\App\Helpers\ShopifyHelper::verifyHmac(
            $request->query(),
            env('SHOPIFY_API_SECRET')
        )) {
            abort(401, 'Invalid Shopify signature');
        }
    
        $shop = $request->shop;
    
        // 3️⃣ Check DB
        $shopData = Shop::where('shop', $shop)->first();
    
        /**
         * 🔑 IMPORTANT LOGIC
         * - Shop NOT in DB OR token missing
         * - This means app NOT installed yet
         * - So REDIRECT to install
         */
        if (!$shopData || empty($shopData->access_token)) {
            return redirect()->route('install', ['shop' => $shop]);
        }
    
        // 4️⃣ Installed app → create session
        session([
            'shop' => $shop,
            'shop_id' => $shopData->id,
            'verified_at' => now(),
        ]);
    
        // 5️⃣ Clean redirect
        return redirect('/dashboard');
    }
    
    
    


    // install.php equivalent
    public function install(Request $request)
    {
        $shop = $request->shop;

        $query = http_build_query([
            'client_id' => env('SHOPIFY_API_KEY'),
            'scope' => env('SHOPIFY_SCOPES'),
            'redirect_uri' => route('callback'),
            'response_type' => 'code',
        ]);

        return redirect("https://{$shop}/admin/oauth/authorize?{$query}");
    }

    // token.php equivalent (WITH GUZZLE)
    public function callback(Request $request)
    {
        // 🔐 HMAC verify
        if (!\App\Helpers\ShopifyHelper::verifyHmac(
            $request->query(),
            env('SHOPIFY_API_SECRET')
        )) {
            abort(401, 'Invalid HMAC');
        }

        $shop = $request->shop;

        // 🔹 Access token get (Guzzle)
        $client = new \GuzzleHttp\Client();

        $response = $client->post(
            "https://{$shop}/admin/oauth/access_token",
            [
                'form_params' => [
                    'client_id' => env('SHOPIFY_API_KEY'),
                    'client_secret' => env('SHOPIFY_API_SECRET'),
                    'code' => $request->code,
                ],
            ]
        );

        $data = json_decode($response->getBody(), true);

        // 🔹 Save token
        $shopModel = \App\Models\Shop::updateOrCreate(
            ['shop' => $shop],
            ['access_token' => $data['access_token']]
        );

        // ✅ REGISTER WEBHOOK HERE
        ShopifyService::registerAppUninstalledWebhook(
            $shop,
            $shopModel->access_token
        );
        
        // ✅ STORE SHOP IN SESSION (IMPORTANT)
        session([
            'shop' => $shop,
            'verified_at' => now(),
        ]);

        // 5️⃣ Redirect to clean dashboard
        return redirect('/dashboard');
    }

}
