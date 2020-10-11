<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Infrastructure\Utils\CustomLogger;

/**
 * Class LogCron
 * @copyright https://www.tutsmake.com/laravel-8-cron-job-task-scheduling-tutorial/
 * @package App\Console\Commands
 */
class LogCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws BindingResolutionException
     */
    public function handle()
    {
        /** @var $customLog CustomLogger */
        $customLog = app(CustomLogger::class);
        $customLog->initialize(config('logging.path.console'));

        $customLog->info('Start run cron job');
        // TODO: Do what you have to do with cron job
        $customLog->info('End run cron job');

        return 0;
    }
}
