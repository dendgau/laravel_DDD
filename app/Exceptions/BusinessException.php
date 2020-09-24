<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\CustomExceptionBase;

/**
 * Class BusinessException
 * @package App\Exceptions
 */
class BusinessException extends CustomExceptionBase
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.business');
    }
}
