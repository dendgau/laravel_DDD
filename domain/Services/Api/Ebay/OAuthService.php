<?php

namespace Domain\Services\Api\Ebay;

use Domain\Services\Api\Ebay\Traits\ProcessResponse;
use DTS\eBaySDK\OAuth\Types\RefreshUserTokenRestRequest;
use DTS\eBaySDK\OAuth\Types\RefreshUserTokenRestResponse;
use \Hkonnet\LaravelEbay\EbayServices;

/**
 * Class OAuthService
 * @package Domain\Services
 */
class OAuthService
{
    use ProcessResponse;

    /** @var $ebayOAuth EbayServices */
    protected $ebayOAuth;

    /**
     * InventoryLocationService constructor.
     */
    public function __construct()
    {
        $this->ebayOAuth = app('EbayOAuth');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function refreshToken(): array
    {
        $result = $this->ebayOAuth->refreshUserToken(
            $this->prepareRefreshUserTokenRequest()
        );
        return $this->processResponse($result);
    }

    /**
     * @return RefreshUserTokenRestRequest
     */
    protected function prepareRefreshUserTokenRequest(): RefreshUserTokenRestRequest
    {
        return new RefreshUserTokenRestRequest([
            'grant_type' => 'refresh_token',
            'refresh_token' => config('ebays.refreshToken'),
            'scope' => [
                'https://api.ebay.com/oauth/api_scope',
                'https://api.ebay.com/oauth/api_scope/buy.order.readonly',
                'https://api.ebay.com/oauth/api_scope/buy.guest.order',
                'https://api.ebay.com/oauth/api_scope/sell.marketing.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.marketing',
                'https://api.ebay.com/oauth/api_scope/sell.inventory.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.inventory',
                'https://api.ebay.com/oauth/api_scope/sell.account.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.account',
                'https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.fulfillment',
                'https://api.ebay.com/oauth/api_scope/sell.analytics.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly',
                'https://api.ebay.com/oauth/api_scope/buy.shopping.cart',
                'https://api.ebay.com/oauth/api_scope/buy.offer.auction',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly',
                'https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly',
                'https://api.ebay.com/oauth/api_scope/sell.finances',
                'https://api.ebay.com/oauth/api_scope/sell.item.draft',
                'https://api.ebay.com/oauth/api_scope/sell.payment.dispute',
                'https://api.ebay.com/oauth/api_scope/sell.item',
                'https://api.ebay.com/oauth/api_scope/sell.reputation',
                'https://api.ebay.com/oauth/api_scope/sell.reputation.readonly'
            ]
        ]);
    }
}
