<?php

namespace App\Exceptions;

use \Illuminate\Validation\ValidationException as BaseValidationException;
use App\Exceptions\Contracts\LogExceptionContract;

/**
 * Class ValidationException
 * @package App\Exceptions
 */
class ValidationException extends BaseValidationException implements LogExceptionContract
{
    /**
     * @return string
     */
    public function getLogPath()
    {
        return config('logging.path.validation');
    }

    /**
     * @inheritDoc
     */
    public function getLogMessage()
    {
        return implode(' - ', [
            $this->getMessage(),
            json_encode($this->errors())
        ]);
    }
}
