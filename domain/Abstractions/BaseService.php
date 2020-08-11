<?php

namespace Domain\Abstractions;

use Infrastructure\Persistences\Contracts\BaseRepositoryContract;
use Domain\Contracts\Services\BaseServiceContract;

/**
 * Class BaseRepository
 * @package Domain\Abstractions
 */
abstract class BaseService implements BaseServiceContract
{
    /** @var $repo */
    protected $repo;

    /**
     * BaseService constructor.
     * @param BaseRepositoryContract $repo
     */
    public function __construct(BaseRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return BaseRepositoryContract
     */
    public function getRepo()
    {
        return $this->repo;
    }
}
