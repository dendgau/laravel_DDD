<?php

namespace Domain\Services\Api\Ebay;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\EbayServiceContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

/**
 * Class SimpleService
 * @package Domain\Services
 */
class SimpleService extends BaseService implements EbayServiceContract
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
     * @return Response
     */
    public function refreshToken(): Response
    {
        return Http::asForm()
            ->withBasicAuth(
                config('ebay.sandbox.credentials.appId'),
                config('ebay.sandbox.credentials.certId')
            )
             ->post('https://api.sandbox.ebay.com/identity/v1/oauth2/token',
                 $this->prepareBodyRefreshToken()
             );
    }

    /**
     * @param $token
     * @return Response
     */
    public function createLocation($token): Response
    {
        return Http::asJson()
            ->withToken($token)
            ->withHeaders([
                'X-EBAY-C-MARKETPLACE-ID' => 'EBAY_US'
            ])
            ->post('https://api.sandbox.ebay.com/sell/inventory/v1/location/ILDT_11111112',
                $this->prepareBodyCreateLocation()
            );
    }

    /**
     * @return array
     */
    protected function prepareBodyCreateLocation()
    {
        return [
            'location' => [
                'address' => [
                    'addressLine2' => 'Vista Ave S',
                    'city' => 'Seattle',
                    'stateOrProvince' => 'Washington',
                    'postalCode' => '98108',
                    'country' => 'US',
                ]
            ],
            'name' => 'ILDT_11111112',
            'merchantLocationStatus' => 'ENABLED',
            'locationTypes' => [
                'STORE', 'WAREHOUSE'
            ]
        ];
    }

    /**
     * @return array
     */
    protected function prepareBodyRefreshToken()
    {
        return [
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
        ];
    }
}
