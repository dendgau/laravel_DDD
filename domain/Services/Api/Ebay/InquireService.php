<?php

namespace Domain\Services\Api\Ebay;

use Domain\Services\Api\Ebay\Traits\ProcessResponse;
use DTS\eBaySDK\PostOrder\Services\PostOrderService;
use DTS\eBaySDK\PostOrder\Types\GetInquiryRestRequest;

/**
 * Class InquireService
 * @package Domain\Services\Api\Ebay
 */
class InquireService
{
    use ProcessResponse;

    /** @var PostOrderService $ebayPostOrder */
    protected PostOrderService $ebayPostOrder;

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getInquire(array $params = [])
    {
        $this->ebayPostOrder = app('EbayPostOrder');
        $result = $this->ebayPostOrder->getInquiry($this->prepareGetInquire($params));
        return $this->processResponse($result);
    }

    /**
     * @param array $params
     * @return GetInquiryRestRequest
     */
    protected function prepareGetInquire(array $params = []): GetInquiryRestRequest
    {
        return new GetInquiryRestRequest([
            'inquiryId' => '54321'
        ]);
    }
}
