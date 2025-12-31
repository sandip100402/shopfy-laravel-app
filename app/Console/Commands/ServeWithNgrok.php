<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeWithNgrok extends Command
{
    protected $signature = 'serve:ngrok';
    protected $description = 'Serve Laravel with Ngrok + Shopify deploy';

    public function handle()
    {
        $this->info('Starting Laravel server...');
        exec('php artisan serve > /dev/null 2>&1 &');

        sleep(2);

        $this->info('Starting ngrok...');
        exec('ngrok http 8000 > /dev/null 2>&1 &');

        sleep(5);

        $json = file_get_contents('http://127.0.0.1:4040/api/tunnels');
        $data = json_decode($json, true);

        $publicUrl = $data['tunnels'][0]['public_url'];

        $this->info("Public URL: " . $publicUrl);

        $this->updateShopifyToml($publicUrl);

        $this->info('Deploying Shopify app...');
        exec('shopify app deploy --force');

        $this->info('✅ All done!');
    }

    private function updateShopifyToml($url)
    {
        $path = base_path('shopify.app.toml');

        $content = file_get_contents($path);

        // application_url update
        $content = preg_replace(
            '/application_url\s*=\s*".*"/',
            'application_url = "' . $url . '"',
            $content
        );

        // redirect_urls exact format update
        $redirectBlock = <<<TOML
    redirect_urls = [
    "{$url}",
    "{$url}/callback",
    "{$url}/install"
    ]
    TOML;

        $content = preg_replace(
            '/redirect_urls\s*=\s*\[[\s\S]*?\]/',
            $redirectBlock,
            $content
        );
        $content = preg_replace(
            '/(\[app_preferences\][\s\S]*?url\s*=\s*)".*"/',
            '$1"' . $url . '"',
            $content
        );
        file_put_contents($path, $content);

        $this->info('✅ shopify.app.toml updated successfully');
    }

}
