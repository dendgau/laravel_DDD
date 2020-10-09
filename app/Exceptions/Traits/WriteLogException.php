<?php

namespace App\Exceptions\Traits;

use Illuminate\Http\Request;

/**
 * Trait WriteLogException
 * @package App\Exceptions\Traits
 */
trait WriteLogException
{
    /**
     * @return string
     */
    public function getLogMessage()
    {
        /** @var $request Request */
        $request = app('request');

        return implode(' - ', [
            $request->ip(),
            $request->getMethod() . ' ' . $request->getPathInfo(),
            $this->getMessage()
        ]);
    }

    abstract public function getLogPath();
}
