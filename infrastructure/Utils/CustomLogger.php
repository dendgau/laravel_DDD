<?php

namespace Infrastructure\Utils;

use Illuminate\Foundation\Application;
use \Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLog;

/**
 * Class CustomLogger
 * @package Infrastructure\Utils
 */
class CustomLogger
{
    /** @var $logger Logger */
    protected $logger;

    /**
     * Create a custom Monolog instance
     *
     * @param array $config
     * @return MonoLog
     */
    public function __invoke(array $config)
    {
        $monolog = new MonoLog(env('APP_ENV'));
        $monolog->pushHandler(new StreamHandler($this->setPathLog($config['path'] ?? null)));
        return $monolog;
    }

    /**
     * Dynamically proxy method calls to the underlying logger.
     * Method: log|debug|info|notice|warning|error
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        try {
            $this->logger->{$method}(...$arguments);
        } catch (\Exception $ex) {
            throw new \LogicException($ex->getMessage());
        }
    }

    /**
     * @param null $path
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function initialize($path = null)
    {
        if (!$this->logger) {
            $appLog = app()->make('log');
            $channel = $appLog->getChannels();
            $this->logger = $appLog->channel(!empty($channel) ? $channel : null);
        }
        $this->setHandleLog($path);
    }

    /**
     * @param $path
     */
    protected function setHandleLog($path)
    {
        $this->logger
            ->getLogger() // Get monolog instance
            ->pushHandler(new StreamHandler($this->setPathLog($path)));
    }

    /**
     * @param $path
     * @return string
     */
    protected function setPathLog($path)
    {
        /** @var $utilDate CustomDateTime */
        $utilDate = app(CustomDateTime::class);

        $today = $utilDate->now();
        $path = implode('/', [
            $path ?? config('logging.path.application'),
            $today->year,
            $today->month,
            $today->day . '.log',
        ]);

        return $path;
    }
}
