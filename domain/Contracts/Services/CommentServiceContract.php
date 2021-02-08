<?php

namespace Domain\Contracts\Services;

/**
 * Interface CommentServiceContract
 * @package Domain\Contracts\Services
 */
interface CommentServiceContract extends BaseServiceContract
{
    /**
     * @param $blogs
     * @return mixed
     */
    public function autoInsertComment(array $blogs);
}
