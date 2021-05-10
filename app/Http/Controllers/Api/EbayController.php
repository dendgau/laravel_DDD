<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Contracts\Services\EbayServiceContract;
use Domain\Services\Api\Ebay\PostOrderService;
use Domain\Services\Api\Ebay\SimpleService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

/**
 * Class EbayController
 * @package App\Http\Controllers\Api
 */
class EbayController extends Controller
{
    /**
     * AuthController constructor.
     * @param EbayServiceContract $appService
     */
    public function __construct(EbayServiceContract $appService)
    {
        parent::__construct($appService);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function testSDK(Request $request)
    {
        return $this->appService->createInventory();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function testInquire(Request $request)
    {
        /** @var $postOrderService PostOrderService */
        $postOrderService = app(PostOrderService::class);
        return $postOrderService->getInquire();
    }

    /**
     * @param Request $request
     */
    public function testSimple(Request $request)
    {
        /** @var SimpleService $simpleService */
        $simpleService = app(SimpleService::class);

        $respRefreshToken = $simpleService->refreshToken();
        if ($respRefreshToken->failed()) {
            return $respRefreshToken;
        }
        $token = Arr::get($respRefreshToken->json(), 'access_token');
        return $simpleService->createLocation($token);
    }
}
