<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowBlogRequest;
use Domain\Contracts\Repositories\BlogRepositoryContract;
use Domain\Contracts\Repositories\CommentRepositoryContract;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\BlogServiceContract;
use Domain\Contracts\Services\TestingServiceContract;
use Domain\Entities\Eloquents\BlogEntity;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;

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
    public function index()
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
     * @param ShowBlogRequest $request
     * @param $id
     * @return mixed
     */
    public function show(ShowBlogRequest $request, $id)
    {
        // Example check policy
//        $blog = $this->getService()->getBlog($id);
//        $test1 = Gate::check('view', $blog);
//        $test2 = $request->user()->can('view', $blog);
//        $test3 = $this->authorize('view', [$blog]);
//        dd($test1, $test2, $test3);

        $blog = $this->getService()->getBlog($id);
        return $this->respView('blog.update', [
            'title' => $blog->title,
            'content' => $blog->content
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
        $this->getService()->updateBlog($id, $paramsUpdate);
        return redirect()->route('blog_show', ['id' => $id]);
    }

    /**
     * Auto create 100 blog with defaut user
     * @param Request $request
     */
    public function create(Request $request)
    {
        $this->getService()->autoInsertBlogComment();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $this->getService()->deleteBlog($id);
            $resp = redirect()->route('blog_list');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $resp = redirect()->route('blog_update', ['id' => $id]);
        }
        return $resp;
    }
}
