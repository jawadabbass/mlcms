<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Traits\MassEmailsTrait;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use MassEmailsTrait;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*
        /usr/local/bin/ea-php80 /home/salonst2022/site_files/artisan schedule:run
        */
        /*
        $schedule->call(function () {
            Mail::send('mail.test', [], function ($message) {
                $message->subject('Hi jawad');
                $message->to('jawad@medialinkers.com');
            });
        })->dailyAt('06:12');
        */

        $schedule->call(function () {
            $this->sendMassMailFromQueue();
        })->everyMinute();
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
