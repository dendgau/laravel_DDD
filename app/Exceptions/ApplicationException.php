<?php

namespace App\Exceptions;

use App\Exceptions\Abstractions\BaseException;

/**
 * Class ApplicationException
 * @package App\Exceptions
 */
class ApplicationException extends BaseException
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('log.path.application');
    }
}
