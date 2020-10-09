<?php

namespace App\Exceptions\Abstractions;

use App\Exceptions\Contracts\LogExceptionContract;
use App\Exceptions\Traits\WriteLogException;
use Exception;

/**
 * Class CustomExceptionBase
 * @package App\Exceptions
 */
abstract class CustomExceptionBase extends Exception implements LogExceptionContract
{
    use WriteLogException;

    /** @var array $data */
    protected $data;

    /**
     * BaseException constructor.
     * @param string $message
     * @param array $data
     */
    public function __construct($message = "", $data = [])
    {
        parent::__construct($message, 0, null);

        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'file' => $this->getFile() . ':' . $this->getLine(),
            'data' => $this->data
        ];
    }
}
