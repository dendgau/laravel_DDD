<?php

namespace Domain\Services;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\BlogRepositoryContract;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\BlogServiceContract;
use Domain\Contracts\Services\CommentServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class BlogService
 * @package Domain\Services
 */
class BlogService extends BaseService implements BlogServiceContract
{
    /**
     * BlogService constructor.
     * @param BlogRepositoryContract $repo
     */
    public function __construct(BlogRepositoryContract $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Play the role as lazy load
     * @return mixed
     */
    public function getListBlogBelongUserByLazyLoad()
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = app(UserRepositoryContract::class);

        $user = $userRepo->find(Auth::id());
        $blogs = $user->blogs->all();
        foreach ($blogs as $b) {
            $comments[] = $b->comments->all();
        }
        return $blogs;
    }

    /**
     * Play the role as eager load
     * @return mixed
     */
    public function getListBlogBelongUserByEagerLoad()
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = app(UserRepositoryContract::class);

        $user = $userRepo->with('blogs.comments')->find(Auth::id());
        $blogs = $user->blogs->all();
        foreach ($blogs as $b) {
            $comments[] = $b->comments->all();
        }
        return $blogs;
    }

    /**
     * @param $id
     * @param $params
     * @return mixed
     */
    public function updateBlogById($id, $params)
    {
        /** @var $blogRepo BlogRepositoryContract */
        $blogRepo = app(BlogRepositoryContract::class);

        // Check blog exist for failure
        $blog = $blogRepo->find($id);

        // For POST method
        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        if (!empty($title) && !empty($content)) {
            $blog->title = $title;
            $blog->content = $content;
            $blog->save();
        }

        return $blog;
    }

    /**
     * Create multi blogs
     * @return array
     */
    public function autoInsertBlog()
    {
        /** @var $blogRepo BlogRepositoryContract */
        $blogRepo = app(BlogRepositoryContract::class);

        $blogRepo
            ->where('user_id', Auth::id())
            ->delete();

        $blogInsert = [];
        for ($i = 0; $i < 100; $i++) {
            $blogInsert[] = [
                'user_id' => Auth::id(),
                'title' => "Title blog {$i}",
                'content' => "Content blog {$i}",
            ];
        }
        return $blogRepo->insert($blogInsert);
    }

    /**
     * Auto create and insert blog and comment
     */
    public function autoInsertBlogComment()
    {
        /** @var CommentServiceContract $commentService */
        $commentService = app(CommentServiceContract::class);

        try {
            DB::beginTransaction();

            if (!$this->autoInsertBlog()) {
                throw new Exception('Can not auto create blog');
            }

            $blogs = $this->getRepo()
                ->all()
                ->pluck('id')
                ->toArray();

            if (empty($blogs) || !$commentService->autoInsertComment($blogs)) {
                throw new Exception('Can not auto create comment');
            }

            DB::commit();
        } catch (Exception $exc) {
            Log::error($exc->getMessage());
            DB::rollBack();
        }
    }
}
