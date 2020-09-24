<?php

namespace App\Exceptions\Contracts;

/**
 * Interface LogExceptionContract
 * @package App\Exceptions\Contracts
 */
interface LogExceptionContract
{
    /**
     * @return string
     */
    public function getLogMessage();
}
