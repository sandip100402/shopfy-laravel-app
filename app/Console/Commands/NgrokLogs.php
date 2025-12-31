<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NgrokLogs extends Command
{
    protected $signature = 'ngrok:logs';
    protected $description = 'Show ngrok status and logs';

    public function handle()
    {
        $this->info('🌐 ngrok Dashboard');
        $this->line('👉 http://127.0.0.1:4040');
        $this->line('');

        $this->info('📡 Active ngrok process:');
        passthru('ps aux | grep ngrok | grep -v grep');
    }
}
