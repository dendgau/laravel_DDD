<?php

namespace Infrastructure\Utils;

use \Illuminate\Log\Logger;
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
            throw new \LogicException('Can not find method to write log');
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
        $this->setupHandleLog($path);
    }

    /**
     * Clear stream handle
     */
    protected function clearHandleLog()
    {
        // Close stream file
        $this->logger
            ->getLogger()
            ->close();

        // Remove handle and keep default handle
        $dPath = $this->setPathLog(null);
        foreach ($this->logger->getLogger()->getHandlers() as $item) {
            if ($item->getUrl() != $dPath) {
                $this->logger
                    ->getLogger()
                    ->popHandler();
            }
        }
    }

    /**
     * Add new stream handle
     * @param $path
     */
    protected function setupHandleLog($path)
    {
        $cPath = $this->setPathLog($path); // For custom
        $dPath = $this->setPathLog(null); // For default

        // Check default handle is exited
        $exited = false;
        foreach ($this->logger->getLogger()->getHandlers() as $item) {
            if ($cPath == $dPath) {
                $exited = true;
                break;
            }
        }

        // Add new stream handle
        if (!$exited) {
            $this->logger
                ->getLogger() // Get monolog instance
                ->pushHandler(new StreamHandler($cPath));
        }
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
            $path ?? config('logging.channels.custom.path'),
            $today->year,
            $today->month,
            $today->day . '.log',
        ]);

        return $path;
    }
}
