<?php

namespace Domain\Entities\Eloquents;

use Domain\Abstractions\BaseEntity;

/**
 * Class BlogEntity
 * @package Domain\Entities\Eloquents
 */
class BlogEntity extends BaseEntity
{
    /** @var string $table */
    protected $table = 'blogs';
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];
    
    /**
     *  Get comment list of blog
     */
    public function comments()
    {
        return $this->hasMany(CommentEntity::class, 'blog_id', 'id');
    }
}
