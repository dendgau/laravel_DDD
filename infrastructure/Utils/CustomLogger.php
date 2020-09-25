<?php

namespace Infrastructure\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class CustomLogger
 * @package Infrastructure\Utils
 */
class CustomLogger
{
    /** @var $monolog Logger */
    protected $monolog;

    /**
     * Create a custom Monolog instance
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config)
    {
        $this->monolog = new Logger(env('APP_ENV'));
        $this->setHandleLog($config['path']);
        return $this->monolog;
    }

    public function __destruct()
    {
        $this->monolog->popHandler();
    }

    public function getLogInstance()
    {
        if (empty($this->logger)) {
            $this->monolog = app('log');
        }
        return $this->monolog;
    }

    /**
     * Dynamically proxy method calls to the underlying logger.
     * Method: log|debug|info|notice|warning|error
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        if (is_callable([$this->monolog, $method])) {
            $this->monolog->{$method}(...$arguments);
        }
        throw new \LogicException('Can not call function by __call in CustomLogger');
    }

    /**
     * @param $path
     */
    public function setHandleLog($path)
    {
        $this->monolog->pushHandler(new StreamHandler($this->setPathLog($path)));
    }

    /**
     * @param $path
     * @return string
     */
    public function setPathLog($path)
    {
        /** @var $utilDate CustomDateTime */
        $utilDate = app(CustomDateTime::class);

        $today = $utilDate->now();
        $path = implode('/', [
            $path,
            $today->year,
            $today->month,
            $today->day . '.log',
        ]);

        return $path;
    }
}
