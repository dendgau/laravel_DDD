<?php

namespace Domain\Repositories;

use Domain\Abstractions\BaseRepository;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Entities\Eloquents\UserEntity;

/**
 * Class UserRepository
 * @package Domain\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * @return string
     */
    public function model()
    {
        return UserEntity::class;
    }
}
