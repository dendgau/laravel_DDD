<?php

namespace App\Exceptions\Abstractions;

use App\Exceptions\Contracts\LogExceptionContract;
use App\Exceptions\Traits\WriteLogException;
use Exception;

/**
 * Class BaseException
 * @package App\Exceptions
 */
abstract class BaseException extends Exception implements LogExceptionContract
{
    use WriteLogException;

    /** @var array $data */
    protected $data;

    /**
     * BaseException constructor.
     * @param string $message
     * @param array $data
     */
    public function __construct($message = "", $data = [])
    {
        parent::__construct($message, 0, null);

        $this->data = $data;
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return $this->data;
    }

    abstract public function getLogPath();
}
