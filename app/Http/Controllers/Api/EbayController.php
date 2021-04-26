<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Contracts\Services\EbayServiceContract;
use Illuminate\Http\Request;
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
    public function test(Request $request)
    {
        return $this->appService->createInventory();
    }
}
