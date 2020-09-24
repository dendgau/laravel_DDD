<?php

namespace App\Exceptions\Traits;

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
        /** @var $request */
        $request = app('request');

        return implode(' - ', [
            $this->getCode(),
            $request->getMethod() . ' ' . $request->fullUrl(),
            $this->getMessage(),
            json_encode($this->getData())
        ]);
    }
}
