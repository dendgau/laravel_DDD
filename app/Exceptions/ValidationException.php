<?php

namespace App\Exceptions;

use App\Exceptions\Traits\WriteLogException;
use \Illuminate\Validation\ValidationException as BaseValidationException;
use App\Exceptions\Contracts\LogExceptionContract;

/**
 * Class ValidationException
 * @package App\Exceptions
 */
class ValidationException extends BaseValidationException implements LogExceptionContract
{
    use WriteLogException;

    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('logging.path.validation');
    }

    public function getData()
    {
        return $this->errors();
    }
}
