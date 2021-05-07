<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Contracts\Services\EbayServiceContract;
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
        return $this->appService->getInquire();
    }

    /**
     * @param Request $request
     */
    public function testSimple(Request $request)
    {
        /** @var SimpleService $simple */
        $simple = app(SimpleService::class);

        $respRefreshToken = $simple->refreshToken();
        if ($respRefreshToken->failed()) {
            return $respRefreshToken;
        }
        $token = Arr::get($respRefreshToken->json(), 'access_token');
        return $simple->createLocation($token);
    }
}
