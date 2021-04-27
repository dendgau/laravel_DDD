<?php

namespace Domain\Services\Api\Ebay;

use Domain\Services\Api\Ebay\Traits\ProcessResponse;
use DTS\eBaySDK\Inventory\Types\Availability;
use DTS\eBaySDK\Inventory\Types\CreateOrReplaceInventoryItemRestRequest;
use DTS\eBaySDK\Inventory\Types\Dimension;
use DTS\eBaySDK\Inventory\Types\PackageWeightAndSize;
use DTS\eBaySDK\Inventory\Types\PickupAtLocationAvailability;
use DTS\eBaySDK\Inventory\Types\Product;
use DTS\eBaySDK\Inventory\Types\ShipToLocationAvailability;
use DTS\eBaySDK\Inventory\Types\TimeDuration;
use DTS\eBaySDK\Inventory\Types\Weight;
use Illuminate\Support\Arr;
use DTS\eBaySDK\Inventory\Services\InventoryService;

/**
 * Class InventoryLocationService
 * @package Domain\Services
 */
class InventoryItemService
{
    use ProcessResponse;

    protected InventoryService $ebayInventory;

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function createInventoryItem(array $params): array
    {
        $this->ebayInventory = app('EbayInventory');
        $result = $this->ebayInventory->createOrReplaceInventoryItem(
            $this->prepareCreateOrReplaceInventoryItem($params)
        );
        return $this->processResponse($result);
    }

    /**
     * @param array $params
     * @return CreateOrReplaceInventoryItemRestRequest
     */
    public function prepareCreateOrReplaceInventoryItem(array $params): CreateOrReplaceInventoryItemRestRequest
    {
        return new CreateOrReplaceInventoryItemRestRequest([
            'sku' => Arr::get($params, 'item.sku'),
            'packageWeightAndSize' => $this->preparePackageWeightAndSize(),
            'product' => $this->prepareProduct(),
            'condition' => 'NEW',
            'availability' => $this->prepareAvailability($params),
        ]);
    }

    /**
     * @return PackageWeightAndSize
     */
    protected function preparePackageWeightAndSize(): PackageWeightAndSize
    {
        return new PackageWeightAndSize([
            'dimensions' => $this->prepareDimensions(),
            'weight' => $this->prepareWeight(),
            'packageType' => 'USPS_LARGE_PACK'
        ]);
    }

    /**
     * @return Dimension
     */
    protected function prepareDimensions(): Dimension
    {
        return new Dimension([
            'height' => doubleval(20),
            'length' => doubleval(20),
            'width' => doubleval(20),
            'unit' => 'CENTIMETER'
        ]);
    }

    /**
     * @return Weight
     */
    protected function prepareWeight(): Weight
    {
        return new Weight([
            'unit' => 'GRAM',
            'value' => doubleval(200)
        ]);
    }

    /**
     * @return Product
     */
    protected function prepareProduct(): Product
    {
        return new Product([
            'title' => 'GoPro Hero4 Helmet Cam' . time(),
            'description' => 'New GoPro Hero4 Helmet Cam. Unopened box.',
            'brand' => 'GoPro',
            'mpn' => 'CHDHX-401',
            'imageUrls' => [
                "https://www.eslbuzz.com/wp-content/uploads/2018/04/food-esl.jpg"
            ],
            'aspects' => [
                'Brand' => ['GoPro'],
                'Type' => ['Helmet/Action'],
                'Storage Type' => ['Removable'],
                'Recording Definition' => ['High Definition'],
                'Media Format' => ['Flash Drive (SSD)'],
                'Optical Zoom' => ['10x']
            ]
        ]);
    }

    /**
     * @param array $params
     * @return Availability
     */
    protected function prepareAvailability(array $params): Availability
    {
        return new Availability([
            'pickupAtLocationAvailability' => [
                $this->preparePickupAtLocationAvailability($params)
            ],
            'shipToLocationAvailability' => $this->prepareShipToLocationAvailability($params)
        ]);
    }

    protected function prepareShipToLocationAvailability(array $params): ShipToLocationAvailability
    {
        return new ShipToLocationAvailability([
            'quantity' => 50
        ]);
    }

    /**
     * @param array $params
     * @return PickupAtLocationAvailability
     */
    protected function preparePickupAtLocationAvailability(array $params): PickupAtLocationAvailability
    {
        return new PickupAtLocationAvailability([
            'availabilityType' => 'IN_STOCK',
            'fulfillmentTime' => $this->prepareTimeDuration(),
            'merchantLocationKey' => Arr::get($params, 'location.key'),
            'quantity' => 50
        ]);
    }

    /**
     * @return TimeDuration
     */
    protected function prepareTimeDuration(): TimeDuration
    {
        return new TimeDuration([
            'unit' => 'BUSINESS_DAY',
            'value' => 5
        ]);
    }
}
