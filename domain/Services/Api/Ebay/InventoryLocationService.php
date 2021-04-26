<?php

namespace Domain\Services\Api\Ebay;

use DTS\eBaySDK\Inventory\Types\Address;
use DTS\eBaySDK\Inventory\Types\CreateInventoryLocationRestRequest;
use DTS\eBaySDK\Inventory\Types\LocationDetails;
use \Hkonnet\LaravelEbay\EbayServices;
use Illuminate\Support\Arr;

/**
 * Class InventoryLocationService
 * @package Domain\Services
 */
class InventoryLocationService
{
    /**
     * @param array $params
     * @return mixed
     */
    public function createInventoryLocation(array $params)
    {
        /** @var $ebayService EbayServices */
        $ebayService = app('Ebay');

        return $ebayService->createInventoryLocation(
            $this->prepareCreateInventoryLocationRequest($params)
        );
    }

    /**
     * @param array $params
     * @return CreateInventoryLocationRestRequest
     */
    protected function prepareCreateInventoryLocationRequest(array $params): CreateInventoryLocationRestRequest
    {
        return new CreateInventoryLocationRestRequest([
            'merchantLocationKey' => Arr::get($params, 'location.key', ''),
            'name' => Arr::get($params, 'location.name', ''),
            'location' => $this->prepareLocationDetail(),
            'merchantLocationStatus' => 'ENABLED',
            'locationTypes' => ['WAREHOUSE', 'STORE']
        ]);
    }

    /**
     * @return LocationDetails
     */
    protected function prepareLocationDetail(): LocationDetails
    {
        return new LocationDetails([
            'address' => $this->prepareAddress()
        ]);
    }

    /**
     * @return Address
     */
    protected function prepareAddress()
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
