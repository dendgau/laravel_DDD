<?php

namespace Domain\Entities\Eloquents;

use Domain\Abstractions\BaseEntity;

/**
 * Class CommentEntity
 * @package Domain\Entities\Eloquents
 */
class CommentEntity extends BaseEntity
{
    /** @var string $table */
    protected $table = 'comments';
    
    protected $fillable = [
        'blog_id',
        'user_id',
        'content'
    ];
}
