<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StopDevServer extends Command
{
    protected $signature = 'serve:stop';

    public function handle()
    {
        exec('pkill ngrok');
        exec('pkill -f "php artisan serve"');
    
        $this->info('🛑 Laravel & ngrok stopped');
    }
}



