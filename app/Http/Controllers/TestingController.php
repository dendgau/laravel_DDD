<?php

namespace App\Http\Controllers;

use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Infrastructure\Utils\CustomLogger;

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

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        /** @var $testService TestingServiceContract */
        $testService = $this->getAppService();

        $data = [
            'users' => $testService->getAllUser()
        ];

        return $this->sendResp('testing.index', $data);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function log(Request $request)
    {
        /** @var $testService TestingServiceContract */
        $testService = $this->getAppService();

        /** @var $customLog CustomLogger */
        $customLog = app(CustomLogger::class);

        $context = [
            'users' => $testService->getAllUser()->toArray()
        ];

        foreach (config('logging.path') as $key => $path) {
            $customLog->initialize($path);
            $customLog->debug('Test log ' . $key, $context);
        }
        Log::debug('Test log app is no double');
    }
}
