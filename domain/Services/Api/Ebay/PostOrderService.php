<?php

namespace Domain\Services\Api\Ebay;

use Illuminate\Support\Facades\Config;
use Infrastructure\Utils\CustomLogger;

/**
 * Class PostOrderService
 * @package Domain\Services\Api\Ebay
 */
class PostOrderService
{
    /** @var InquireService $inquireService */
    protected $inquireService;

    public function __construct()
    {
        $this->inquireService = app(InquireService::class);
    }

    /**
     * @return mixed|string[]
     * @throws \Exception
     */
    public function getInquire()
    {
        $log = app(CustomLogger::class);
        $log->initialize(config("logging.path.ebay"));

        try {
            $respRefreshToken = $this->ebayOAuthService->refreshToken();
            Config::set('ebays.header.authToken', $respRefreshToken['access_token']);
            return $this->inquireService->getInquire();
        } catch (\Exceptionn $ex) {
            $log->error($ex->getMessage());
            return ['Error!'];
        }
    }
}
