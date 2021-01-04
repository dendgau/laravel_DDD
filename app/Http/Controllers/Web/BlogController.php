<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Domain\Contracts\Repositories\BlogRepositoryContract;
use Domain\Contracts\Repositories\CommentRepositoryContract;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * TestingController constructor.
     * @param TestingServiceContract $appService
     */
    public function __construct(TestingServiceContract $appService)
    {
        parent::__construct($appService);
    }

    /**
     * Get user and blogs with relationship
     */
    public function get()
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = app(UserRepositoryContract::class);

        DB::enableQueryLog();

        // Play the role as lazy load
        $user = $userRepo->all()->first();
        $blogs = $user->blogs->all();

        // Play the role as eager load
        $users = $userRepo->with('blogs.comments')->get();
        $comments = $users->get(0)
            ->blogs->get(0)
            ->comments->all();

        $query = DB::getQueryLog();
        dd($query);
    }

    /**
     * Auto create 100 blog with defaut user
     * @param Request $request
     */
    public function create(Request $request)
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = app(UserRepositoryContract::class);

        /** @var $blogRepo BlogRepositoryContract */
        $blogRepo = app(BlogRepositoryContract::class);

        /** @var $commentRepo CommentRepositoryContract */
        $commentRepo = app(CommentRepositoryContract::class);

        $user = $userRepo->all()->first();
        try {
            $blogRepo->beginTransaction();
            $blogRepo->where('user_id', $user->id)->delete();

            // Create multi blogs
            $blogInsert = [];
            for ($i = 0; $i < 100; $i++) {
                $blogInsert[] = [
                    'user_id' => $user->id,
                    'title' => "Title blog {$i}",
                    'content' => "Content blog {$i}",
                ];
            }
            $blogRepo->insert($blogInsert);
            $blogs = $blogRepo->all();

            // Create multi comment
            $commentInsert = [];
            foreach ($blogs as $blog) {
                $commentInsert[] = [
                    'user_id' => $user->id,
                    'blog_id' => $blog->id,
                    'content' => "Content comment {$i}",
                ];
            }
            $commentRepo->insert($commentInsert);

            $blogRepo->commit();
        } catch (Exception $exc) {
            $blogRepo->rollback();
        }
    }
}
