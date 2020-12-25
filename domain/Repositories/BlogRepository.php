<?php

namespace Domain\Repositories;

use Domain\Contracts\Repositories\BlogRepositoryContract;
use Domain\Entities\Eloquents\BlogEntity;
use Infrastructure\Persistences\Abstractions\BaseRepository;

/**
 * Class BlogRepository
 * @package Domain\Repositories
 */
class BlogRepository extends BaseRepository implements BlogRepositoryContract
{
    /**
     * @return string
     */
    public function model()
    {
        return BlogEntity::class;
    }
}
