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

    /** @var array $visible */
    protected $visible = [
        'id',
        'name',
        'email'
    ];
}
