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
        'email',
        'is_admin'
    ];
    
    /** @var array $append */
    protected $appends = [
        'is_admin'
    ];

    /**
     * Append new attribute
     * @return type
     */
    public function getIsAdminAttribute()
    {
        return $this->attribute['admin'] === 'yes';
    }
    
    /**
     *  Get blog list of user
     */
    public function blogs()
    {
        return $this->hasMany(BlogEntity::class, 'user_id', 'id');
    }
}
