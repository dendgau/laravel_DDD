<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\CustomExceptionBase;

/**
 * Class ApplicationException
 * @package App\Exceptions
 */
class ApplicationException extends CustomExceptionBase
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.application');
    }
}
