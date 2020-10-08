<?php

namespace App\Http\Controllers;

use App\Http\Response\JsonResponseCustom;
use Domain\Contracts\Services\BaseServiceContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var $appService */
    protected $appService;

    /**
     * Controller constructor.
     * @param BaseServiceContract $appService
     */
    public function __construct(BaseServiceContract $appService)
    {
        $this->appService = $appService;
    }

    /**
     * @return BaseServiceContract
     */
    public function getAppService()
    {
        return $this->appService;
    }

    /**
     * @param $data
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function sendResp($view, $data)
    {
        if (request()->is('api/*') || request()->wantsJson()) {
            return JsonResponseCustom::create(true, $data, 'success');
        }
        return view($view, $data);
    }
}
