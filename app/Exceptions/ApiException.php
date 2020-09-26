<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\CustomExceptionBase;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends CustomExceptionBase
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('logging.path.api');
    }
}
