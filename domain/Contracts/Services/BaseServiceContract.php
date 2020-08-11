<?php

namespace Domain\Contracts\Services;

/**
 * Interface BaseServiceContract
 * @package Domain\Contracts\Services
 */
interface BaseServiceContract
{
    /**
     * @return BaseRepositoryContract
     */
    public function getRepo();
}
