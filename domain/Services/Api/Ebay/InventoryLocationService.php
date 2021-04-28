<?php

namespace Domain\Services\Api\Ebay;

use Domain\Services\Api\Ebay\Traits\ProcessResponse;
use DTS\eBaySDK\Inventory\Types\Address;
use DTS\eBaySDK\Inventory\Types\CreateInventoryLocationRestRequest;
use DTS\eBaySDK\Inventory\Types\GetInventoryItemRestRequest;
use DTS\eBaySDK\Inventory\Types\GetInventoryLocationRestRequest;
use DTS\eBaySDK\Inventory\Types\LocationDetails;
use Illuminate\Support\Arr;
use DTS\eBaySDK\Inventory\Services\InventoryService;

/**
 * Class InventoryLocationService
 * @package Domain\Services
 */
class InventoryLocationService
{
    use ProcessResponse;

    protected InventoryService $ebayInventory;

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function createInventoryLocation(array $params): array
    {
        $this->ebayInventory = app('EbayInventory');
        try {
            $result = $this->processResponse(
                $this->ebayInventory->createInventoryLocation(
                    $this->prepareCreateInventoryLocationRequest($params)
                )
            );
        } catch (\Exception $ex) {
            $result = $this->getInventoryLocation($params);
        }
        return $result;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function getInventoryLocation(array $params): array
    {
        $this->ebayInventory = app('EbayInventory');
        $result = $this->ebayInventory->getInventoryLocation(
            $this->prepareGetInventoryLocationRequest($params)
        );
        return $this->processResponse($result);;
    }

    /**
     * @param array $params
     * @return GetInventoryLocationRestRequest
     */
    protected function prepareGetInventoryLocationRequest(array $params): GetInventoryLocationRestRequest
    {
        return new GetInventoryLocationRestRequest([
            'merchantLocationKey' => Arr::get($params, 'location.key', ''),
        ]);
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
    protected function prepareAddress(): Address
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
