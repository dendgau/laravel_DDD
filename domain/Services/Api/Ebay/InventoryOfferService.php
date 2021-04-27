<?php

namespace Domain\Services\Api\Ebay;

use Domain\Services\Api\Ebay\Traits\ProcessResponse;
use DTS\eBaySDK\Inventory\Types\Amount;
use DTS\eBaySDK\Inventory\Types\CreateOfferRestRequest;
use DTS\eBaySDK\Inventory\Types\ListingPolicies;
use DTS\eBaySDK\Inventory\Types\PricingSummary;
use DTS\eBaySDK\Inventory\Types\PublishOfferRestRequest;
use Illuminate\Support\Arr;
use DTS\eBaySDK\Inventory\Services\InventoryService;
use Illuminate\Support\Facades\Config;

/**
 * Class InventoryOfferService
 * @package Domain\Services
 */
class InventoryOfferService
{
    use ProcessResponse;

    protected InventoryService $ebayInventory;

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function createInventoryOffer(array $params): array
    {
        $this->ebayInventory = app('EbayInventory');
        $result = $this->ebayInventory->createOffer(
            $this->prepareCreateInventoryOffer($params)
        );
        return $this->processResponse($result);
    }

    /**
     * @param $offerId
     * @return array
     * @throws \Exception
     */
    public function publishInventoryOffer($offerId): array
    {
        $this->ebayInventory = app('EbayInventory');
        $result = $this->ebayInventory->publishOffer(
            $this->prepareCreateInventoryOffer($offerId)
        );
        return $this->processResponse($result);
    }

    /**
     * @param $offerId
     * @return PublishOfferRestRequest
     */
    protected function preparePublishInventoryOffer($offerId): PublishOfferRestRequest
    {
        return new PublishOfferRestRequest([
            'offerId' => $offerId
        ]);
    }

    /**
     * @param array $params
     * @return CreateOfferRestRequest
     */
    protected function prepareCreateInventoryOffer(array $params): CreateOfferRestRequest
    {
        return new CreateOfferRestRequest([
            'sku' => Arr::get($params, 'item.sku'),
            'merchantLocationKey' => Arr::get($params, 'location.key'),
            'marketplaceId' => Config::get('ebays.header.marketplaceId'),
            'format' => 'FIXED_PRICE',
            'listingDescription' => 'Lumia phone with a stunning 5.7 inch Quad HD display and a powerful octa-core processor.',
            'listingPolicies' => $this->prepareListingPolicies(),
            'pricingSummary' => $this->preparePricingSummary(),
            'quantityLimitPerBuyer' => 100,
            'availableQuantity' => 100
        ]);
    }

    /**
     * @return ListingPolicies
     */
    protected function prepareListingPolicies(): ListingPolicies
    {
        return new ListingPolicies([
            'fulfillmentPolicyId' => '6171732000',
            'paymentPolicyId' => '6171367000',
            'returnPolicyId' => '6171393000',
        ]);
    }

    /**
     * @return PricingSummary
     */
    protected function preparePricingSummary(): PricingSummary
    {
        return new PricingSummary([
            'price' => $this->preparePricing()
        ]);
    }

    /**
     * @return Amount
     */
    protected function preparePricing(): Amount
    {
        return new Amount([
            'currency' => 'USD',
            'value' => '800'
        ]);
    }
}
