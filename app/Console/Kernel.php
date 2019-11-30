<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        //ScrapeCommand.phpの実行。
        \App\Console\Commands\ScrapeMeigara::class,   //コマンドの登録
        \App\Console\Commands\ScrapeMeigaraList::class,   //コマンドの登録
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //ScrapeCommand.phpの実行。
        // スケジュールの登録（「->daily()」は毎日深夜１２時に実行）
        $schedule->command('command:scrapecommand')->daily();
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
