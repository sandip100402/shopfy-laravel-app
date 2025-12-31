<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\WebhookController;

Route::get('/', [ShopifyController::class, 'index']);
Route::get('/install', [ShopifyController::class, 'install'])->name('install');
Route::get('/callback', [ShopifyController::class, 'callback'])->name('callback');
Route::post(
    '/webhook/app-uninstalled',
    [WebhookController::class, 'appUninstalled']
)->name('appUninstalled');

Route::get('/dashboard', function () {

    // ❌ No session → block
    if (!session()->has('shop')) {
        abort(403, 'Session expired');
    }

    $shop = session('shop');

    // ❌ Token missing → block
    $shopData = \App\Models\Shop::where('shop', $shop)->first();

    if (!$shopData || empty($shopData->access_token)) {
        abort(403, 'Access token missing');
    }

    return "✅ Secure dashboard for shop: {$shop}";
});
