<?php

namespace Domain\Contracts\Services;

/**
 * Interface TestingServiceContract
 * @package Domain\Contracts\Services
 */
interface TestingServiceContract extends BaseServiceContract
{
    /**
     * @return mixed
     */
    public function getAllUser();
}
