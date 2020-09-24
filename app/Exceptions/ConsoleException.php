<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\CustomExceptionBase;

/**
 * Class ConsoleException
 * @package App\Exceptions
 */
class ConsoleException extends CustomExceptionBase
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.console');
    }
}
