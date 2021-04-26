<?php

namespace Domain\Services\Api;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use DTS\eBaySDK\Inventory\Types\Address;
use DTS\eBaySDK\Inventory\Types\CreateInventoryLocationRestRequest;
use DTS\eBaySDK\Inventory\Types\LocationDetails;
use \Hkonnet\LaravelEbay\EbayServices;

/**
 * Class EbayLocationService
 * @package Domain\Services
 */
class EbayLocationService
{
    /**
     * @return mixed
     */
    public function createInventoryLocation()
    {
        /** @var $ebayService EbayServices */
        $ebayService = app(EbayServices::class);
        return $ebayService
            ->createInventory(config('ebays'))
            ->createInventoryLocation($this->prepareCreateInventoryLocationRequest());
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function prepareCreateInventoryLocationRequest()
    {
        return new CreateInventoryLocationRestRequest([
            'merchantLocationKey' => 'DTLaravel_ebay',
            'location' => $this->prepareLocationDetail(),
            'name' => 'DuyTran Laravel Ebay',
            'merchantLocationStatus' => 'ENABLED',
            'locationTypes' => ['WAREHOUSE', 'STORE']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function prepareLocationDetail()
    {
        return new LocationDetails([
            'address' => $this->prepareAddress()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function prepareAddress()
    {
        return new Address([
            'addressLine1' => '6816',
            'addressLine2' => 'Vista Ave S',
            'stateOrProvince' => 'Washington',
            'postalCode' => '98108',
            'city' => 'Seattle',
            'country' => 'US'
        ]);
    }
}
