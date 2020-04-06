<?php

namespace Domain\Contracts\Services;

use Domain\Contracts\Repositories\Core\BaseRepositoryContract;

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
