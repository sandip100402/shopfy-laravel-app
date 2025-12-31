<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeLogs extends Command
{
    protected $signature = 'serve:logs';
    protected $description = 'Show Laravel serve logs';

    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            $this->error('Log file not found.');
            return;
        }

        $this->info('📜 Showing Laravel logs (Ctrl+C to exit)');
        passthru("tail -f {$logFile}");
    }
}
