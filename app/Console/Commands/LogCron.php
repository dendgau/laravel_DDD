<?php

namespace App\Console\Commands;

use App\Jobs\LogJob;
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
    protected $signature = 'log:cron
                            {type : The type of log which you want to write}
                            {--time= : The time which you want to write again}';

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

        // Get argument and option
        $type = $this->argument('type');
        $time = $this->option('time');

        // Handle write log here
        $customLog->initialize(config("logging.path.{$type}"));
        $customLog->info('Start run cron job');

        // For test job and queue
        $queue = 0;
        for ($i = 1; $i <= $time; $i++) {
            $queue++;
            LogJob::dispatch($type, $i)
                ->onQueue('LogQueue' . $queue);
            if ($queue >= 3)
                $queue = 0;
        }

        $customLog->info('End run cron job');
        $customLog->uninitialized();

        return 0;
    }
}
