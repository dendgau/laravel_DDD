<?php

namespace Domain\Repositories;

use Domain\Contracts\Repositories\CommentRepositoryContract;
use Domain\Entities\Eloquents\CommentEntity;
use Infrastructure\Persistences\Abstractions\BaseRepository;

/**
 * Class CommentRepository
 * @package Domain\Repositories
 */
class CommentRepository extends BaseRepository implements CommentRepositoryContract
{
    /**
     * @return string
     */
    public function model()
    {
        return CommentEntity::class;
    }
}
