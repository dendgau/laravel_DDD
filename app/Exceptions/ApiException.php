<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\BaseException;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends BaseException
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.api');
    }
}
