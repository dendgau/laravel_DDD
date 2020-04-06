<?php

namespace Domain\Entities\Eloquents;

use Domain\Abstractions\BaseEntity;

/**
 * Class UserEntity
 * @package Domain\Entities\Eloquents
 */
class UserEntity extends BaseEntity
{
    /** @var string $table */
    protected $table = 'users';
}
