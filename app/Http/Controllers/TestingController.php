<?php

namespace App\Http\Controllers;

use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Http\Request;

/**
 * Class TestingController
 * @package App\Http\Controllers
 */
class TestingController extends Controller
{
    /**
     * TestingController constructor.
     * @param TestingServiceContract $appService
     */
    public function __construct(TestingServiceContract $appService)
    {
        parent::__construct($appService);
    }

    public function index(Request $request)
    {
        /** @var $testService TestingServiceContract */
        $testService = $this->getAppService();

        $users = $testService->getAllUser();
        return $this->sendResp($users);
    }
}
