<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Infrastructure\Utils\CustomLogger;

/**
 * Class LogJob
 * @package App\Jobs
 */
class LogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $typeLog;

    protected $index;

    /**
     * Create a new job instance.
     *
     * @param $typeLog
     * @param $index
     */
    public function __construct($typeLog, $index)
    {
        $this->typeLog = $typeLog;
        $this->index = $index;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        /** @var $customLog CustomLogger */
        $customLog = app(CustomLogger::class);
        $customLog->initialize(config('logging.path.' . $this->typeLog));
        $customLog->info('Running Job', [
            'data' => [
                'type' => $this->typeLog,
                'index' => $this->index
            ]
        ]);
        $customLog->uninitialized();
    }
}
