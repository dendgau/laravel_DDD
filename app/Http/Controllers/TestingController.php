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

        /** @var $customLog CustomLogger */
        $customLog = app(CustomLogger::class);
        $customLog->initialize(config('logging.path.application'));

        $data = [
            'users' => $testService->getAllUser()
        ];

        // dd(Log::getFacadeRoot()->getChannels(), app()->make('log')->getChannels());
        Log::info('Test log application');
        $customLog->info('Test log business');

        return $this->sendResp('testing.index', $data);
    }
}
