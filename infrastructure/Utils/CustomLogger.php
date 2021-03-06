<?php

namespace Infrastructure\Utils;

use Illuminate\Contracts\Container\BindingResolutionException;
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
        } catch (\Exception $ex) {
            throw new \LogicException($ex->getMessage());
        }
    }

    /**
     * @param null $path
     * @param bool $keepPre
     * @throws BindingResolutionException
     */
    public function initialize($path = null, $keepPre = false)
    {
        if (!$this->logger) {
            $logger = app()->make('log');
            $channel = $logger->getChannels();
            $this->logger = $logger->channel(!empty($channel) ? $channel : null);
        }

        if (!$keepPre) {
            $this->clearHandleLog();
        }
        $this->setupHandleLog($path);
    }

    /**
     * Uninitialized handle stream
     */
    public function uninitialized()
    {
        $this->clearHandleLog();
    }

    /**
     * Clear stream handle
     */
    protected function clearHandleLog()
    {
        if (!$this->logger) {
            return;
        }

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

        // Define path
        $today = $utilDate->now();
        $path = implode('/', [
            $path ?? config('logging.channels.custom.path'),
            $today->year,
            $today->month
        ]);

        // Define name file
        $listScan = scandir($path);
        foreach ($listScan as $item) {
            if (strpos($item, '.log') == false) {
                continue;
            }
            $item = implode('/', [$path, $item]);
            if (filesize($item) < 1024) {
                return $item;
            }
        }

        return implode('/', [
            $path,
            $today->day . '-' . time() . '.log',
        ]);;
    }
}
