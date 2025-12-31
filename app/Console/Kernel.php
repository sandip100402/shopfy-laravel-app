<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Import your custom commands
use App\Console\Commands\ServeWithNgrok;
use App\Console\Commands\ServeLogs;
use App\Console\Commands\NgrokLogs;
use App\Console\Commands\StopDevServer;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        ServeWithNgrok::class,
        ServeLogs::class,
        NgrokLogs::class,
        StopDevServer::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Example (optional):
        // $schedule->command('serve:stop')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
