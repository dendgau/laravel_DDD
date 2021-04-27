<?php

namespace Domain\Services\Api\Ebay;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\EbayServiceContract;

/**
 * Class InventoryService
 * @package Domain\Services
 */
class InventoryService extends BaseService implements EbayServiceContract
{
    /**
     * TestingService constructor.
     * @param UserRepositoryContract $repo
     */
    public function __construct(UserRepositoryContract $repo)
    {
        parent::__construct($repo);
    }

    /**
     * @return mixed
     */
    public function createInventory()
    {
        /** @var InventoryLocationService $ebayInventoryLocation */
        $ebayInventoryLocation = app(InventoryLocationService::class);

        /** @var InventoryItemService $ebayInventoryItem */
        $ebayInventoryItem = app(InventoryItemService::class);

        $params = $this->prepareCreateInventory();
        // $respCreateInventoryLocation = $ebayInventoryLocation->createInventoryLocation($params);
        $respBulkCreateInventoryItem = $ebayInventoryItem->createInventoryItem($params);

        return [
            // $respCreateInventoryLocation,
            $respBulkCreateInventoryItem
        ];
    }

    /**
     * @return array
     */
    protected function prepareCreateInventory(): array
    {
        return [
            'location' => [
                'key' => 'LEDT_202123104261',
                'name' => 'Laravel Ebay1 Location 2021-04-26'
            ],
            'item' => [
                'sku' => 'WMSDT0011_IIDT01'
            ]
        ];
    }
}
