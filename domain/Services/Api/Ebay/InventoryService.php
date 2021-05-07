<?php

namespace Domain\Services\Api\Ebay;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\EbayServiceContract;
use DTS\eBaySDK\PostOrder\Services\PostOrderService;
use DTS\eBaySDK\PostOrder\Types\GetInquiryRestRequest;
use Exception;
use Illuminate\Support\Facades\Config;
use Infrastructure\Utils\CustomLogger;

/**
 * Class InventoryService
 * @package Domain\Services
 */
class InventoryService extends BaseService implements EbayServiceContract
{
    /** @var InventoryLocationService $ebayInventoryLocationService */
    protected $ebayInventoryLocationService;

    /** @var InventoryItemService $ebayInventoryItemService */
    protected $ebayInventoryItemService;

    /** @var OAuthService $ebayOAuthService */
    protected $ebayOAuthService;

    /** @var InventoryOfferService $ebayInventoryOffer */
    protected $ebayInventoryOffer;

    /**
     * TestingService constructor.
     * @param UserRepositoryContract $repo
     */
    public function __construct(UserRepositoryContract $repo)
    {
        $this->ebayInventoryLocationService = app(InventoryLocationService::class);
        $this->ebayInventoryItemService = app(InventoryItemService::class);
        $this->ebayOAuthService = app(OAuthService::class);
        $this->ebayInventoryOffer = app(InventoryOfferService::class);
        parent::__construct($repo);
    }

    /**
     * @return \DTS\eBaySDK\PostOrder\Types\GetInquiryRestResponse
     * @throws Exception
     */
    public function getInquire()
    {
        // Refresh token
        $respRefreshToken = $this->ebayOAuthService->refreshToken();
        Config::set('ebays.header.authToken', $respRefreshToken['access_token']);

        /** @var $ebayPostOrder PostOrderService */
        $ebayPostOrder = app('EbayPostOrder');
        $resp = $ebayPostOrder->getInquiry(new GetInquiryRestRequest([
            'inquiryId' => '54321'
        ]));
        return $resp;
    }

    /**
     * @return mixed
     */
    public function createInventory(): array
    {
        $log = app(CustomLogger::class);
        $log->initialize(config("logging.path.ebay"));

        try {
            // Refresh token
            $respRefreshToken = $this->ebayOAuthService->refreshToken();
            Config::set('ebays.header.authorization', $respRefreshToken['access_token']);

            // Process create inventory
            $params = $this->prepareCreateInventory();
            $this->ebayInventoryLocationService->createInventoryLocation($params);
            $this->ebayInventoryItemService->createInventoryItem($params);
            $respCreateOffer = $this->ebayInventoryOffer->createInventoryOffer($params);
            $respPublishOffer = $this->ebayInventoryOffer->publishInventoryOffer($respCreateOffer['offerId']);

            return $respPublishOffer;
        } catch (Exception $ex) {
            $log->error($ex->getMessage());
            return ['Error!'];
        }
    }

    /**
     * @return array
     */
    protected function prepareCreateInventory(): array
    {
        return [
            'location' => [
                'key' => 'ILDT_20210427',
                'name' => 'Laravel Ebay1 Location 2021-04-27'
            ],
            'item' => [
                'sku' => 'IIDT_20210427_' . time()
            ]
        ];
    }
}
