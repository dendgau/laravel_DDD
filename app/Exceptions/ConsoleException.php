<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\BaseException;

/**
 * Class ConsoleException
 * @package App\Exceptions
 */
class ConsoleException extends BaseException
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.console');
    }
}
