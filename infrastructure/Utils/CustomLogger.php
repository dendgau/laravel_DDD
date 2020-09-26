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

    /** @var $levels array */
    protected $levels = [
        'log',
        'debug',
        'info',
        'notice',
        'warning',
        'error'
    ];

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
        if (!in_array($method, $this->levels)) {
            return;
        }

        try {
            $this->logger->{$method}(...$arguments);
            $this->clearHandleLog();
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
            $logger = app()->make('log');
            $channel = $logger->getChannels();
            $this->logger = $logger->channel(!empty($channel) ? $channel : null);
        }
        $this->clearHandleLog();
        $this->setHandleLog($path);
    }

    /**
     * Clear stream handle
     */
    protected function clearHandleLog()
    {
        foreach ($this->logger->getLogger()->getHandlers() as $item) {
            $this->logger
                ->getLogger()
                ->popHandler();
        }
    }

    /**
     * Add new stream handle
     * @param $path
     */
    protected function setHandleLog($path)
    {
        // Add new stream handle
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
