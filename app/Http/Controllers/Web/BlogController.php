<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Domain\Contracts\Repositories\BlogRepositoryContract;
use Domain\Contracts\Repositories\CommentRepositoryContract;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\BlogServiceContract;
use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * BlogController constructor.
     * @param BlogServiceContract $appService
     */
    public function __construct(BlogServiceContract $appService)
    {
        parent::__construct($appService);
    }

    /**
     * @return mixed
     */
    public function list()
    {
        DB::enableQueryLog();
        $blog1 = $this->getService()->getListBlogBelongUserByLazyLoad();
        $blog2 = $this->getService()->getListBlogBelongUserByEagerLoad();
        $query = DB::getQueryLog();
        dd($query);
        return $this->respView('blog.list', [
            'blog1' => $blog1,
            'blog2' => $blog2,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $paramsUpdate = $request->only(['title', 'content']);
        $blog = $this->getService()->updateBlogById($id, $paramsUpdate);
        return $this->respView('blog.update', [
            'title' => $blog->title,
            'content' => $blog->content
        ]);
    }

    /**
     * Auto create 100 blog with defaut user
     * @param Request $request
     */
    public function create(Request $request)
    {
        $this->getService()->autoInsertBlogComment();
    }
}
