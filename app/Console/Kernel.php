<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the Kiwi sitemap fetch command to run daily at midnight
        $schedule->command('fetch:kiwi-sitemap')->daily();

        // You can also schedule the fetch:nested-kiwi-urls command if needed
        $schedule->command('fetch:nested-kiwi-urls')->hourly(); // Example: Run every hour
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    // Registering the custom commands
    protected $commands = [
        Commands\FetchKiwiSitemap::class,
        Commands\FetchNestedKiwiUrls::class,
        ];
}
