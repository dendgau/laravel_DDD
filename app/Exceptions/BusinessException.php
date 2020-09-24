<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\BaseException;

/**
 * Class BusinessException
 * @package App\Exceptions
 */
class BusinessException extends BaseException
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.business');
    }
}
