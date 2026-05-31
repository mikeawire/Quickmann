<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RecuringCharge;
use App\Console\Commands\InvestmentCheck;
use App\Console\Commands\PropertyCheck;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RecuringCharge::class,
        InvestmentCheck::class,
        PropertyCheck::class,
          Commands\DobReminder::class,
        Commands\HolidayReminder::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('property:check')->everyMinute();
        $schedule->command('queue:work')->everyMinute();
         $schedule->command('investment:check')->everyMinute();
            $schedule->command('dob:reminder')->daily();
         $schedule->command('holiday:reminder')->everyMinute();
        $schedule->command('recuring:charge')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
