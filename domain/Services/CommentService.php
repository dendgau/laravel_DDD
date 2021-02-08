<?php

namespace Domain\Services;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\CommentRepositoryContract;
use Domain\Contracts\Services\CommentServiceContract;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentService
 * @package Domain\Services
 */
class CommentService extends BaseService implements CommentServiceContract
{
    /**
     * CommentService constructor.
     * @param CommentRepositoryContract $repo
     */
    public function __construct(CommentRepositoryContract $repo)
    {
        parent::__construct($repo);
    }

    /**
     * @param $blogs
     * @return mixed
     */
    public function autoInsertComment(array $blogs)
    {
        /** @var $commentRepo CommentRepositoryContract */
        $commentRepo = app(CommentRepositoryContract::class);

        $commentRepo->where('user_id', Auth::id())->delete();
        $commentInsert = [];
        foreach ($blogs as $blog) {
            $commentInsert[] = [
                'user_id' => Auth::id(),
                'blog_id' => $blog,
                'content' => "Content comment of blog $blog",
            ];
        }
        return $commentRepo->insert($commentInsert);
    }
}
