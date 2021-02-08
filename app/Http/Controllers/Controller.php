<?php

namespace App\Http\Controllers;

use App\Http\Response\JsonResponseCustom;
use Domain\Contracts\Services\BaseServiceContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
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
     * @param $view
     * @param $data
     * @return mixed
     */
    public function respView($view, $data)
    {
        if (request()->wantsJson()) {
            return JsonResponseCustom::create(true, $data, '', 200);
        }
        return view($view, $data);
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return mixed
     */
    public function respApi($data = [], $message = '', $code = 200)
    {
        return JsonResponseCustom::create(true, $data, $message, $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return mixed
     */
    public function respApiNoData($message = '', $code = 200)
    {
        return $this->respApi([], $message, $code);
    }
}
