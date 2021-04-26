<?php

namespace Domain\Services\Api\Ebay;

use DTS\eBaySDK\Inventory\Types\Availability;
use DTS\eBaySDK\Inventory\Types\CreateOrReplaceInventoryItemRestRequest;
use DTS\eBaySDK\Inventory\Types\PackageWeightAndSize;
use DTS\eBaySDK\Inventory\Types\PickupAtLocationAvailability;
use DTS\eBaySDK\Inventory\Types\ShipToLocationAvailability;
use DTS\eBaySDK\Inventory\Types\TimeDuration;
use DTS\eBaySDK\Inventory\Types\Weight;
use \Hkonnet\LaravelEbay\EbayServices;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Dimensions;

/**
 * Class InventoryLocationService
 * @package Domain\Services
 */
class InventoryItemService
{
    /**
     * @param array $params
     * @return mixed
     */
    public function createInventoryItem(array $params)
    {
        /** @var $ebayService EbayServices */
        $ebayService = app('Ebay');

        return $ebayService->createOrReplaceInventoryItem(
            $this->prepareCreateOrReplaceInventoryItem($params)
        );
    }

    /**
     * @param array $params
     * @return CreateOrReplaceInventoryItemRestRequest
     */
    public function prepareCreateOrReplaceInventoryItem(array $params)
    {
        return new CreateOrReplaceInventoryItemRestRequest([
            'sku' => Arr::get($params, 'item.sku'),
            'locale' => 'en_US',
            'packageWeightAndSize' => $this->preparePackageWeightAndSize(),
            'product' => $this->prepareProduct(),
            'condition' => 'NEW',
            'availability' => $this->prepareAvailability($params),
        ]);
    }

    /**
     * @return PackageWeightAndSize
     */
    protected function preparePackageWeightAndSize()
    {
        return new PackageWeightAndSize([
            'dimensions' => $this->prepareDimensions(),
            'weight' => $this->prepareWeight(),
            'packageType' => 'USPS_LARGE_PACK'
        ]);
    }

    /**
     * @return Dimensions
     */
    protected function prepareDimensions()
    {
        return new Dimensions([
            'height' => 20,
            'length' => 20,
            'width' => 20,
            'unit' => 'CENTIMETER'
        ]);
    }

    /**
     * @return Weight
     */
    protected function prepareWeight()
    {
        return new Weight([
            'unit' => 'GRAM',
            'value' => 200
        ]);
    }

    /**
     * @return Product
     */
    protected function prepareProduct()
    {
        return new Product([
            'title' => 'GoPro Hero4 Helmet Cam',
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
    protected function prepareAvailability(array $params)
    {
        return new Availability([
            'pickupAtLocationAvailability' => $this->preparePickupAtLocationAvailability($params),
            'shipToLocationAvailability' => $this->prepareShipToLocationAvailability($params)
        ]);
    }

    protected function prepareShipToLocationAvailability(array $params)
    {
        return new ShipToLocationAvailability([
            'quantity' => 50
        ]);
    }

    /**
     * @param array $params
     * @return PickupAtLocationAvailability
     */
    protected function preparePickupAtLocationAvailability(array $params)
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
    protected function prepareTimeDuration()
    {
        return new TimeDuration([
            'unit' => 'BUSINESS_DAY',
            'value' => 5
        ]);
    }
}
