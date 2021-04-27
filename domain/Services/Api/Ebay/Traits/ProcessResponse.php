<?php

namespace Domain\Services\Api\Ebay\Traits;

use Exception;
use Illuminate\Support\Arr;

/**
 * Trait ProcessResponse
 * @package Domain\Services\Api\Ebay\Traits
 */
trait ProcessResponse
{
    /**
     * @param $resp
     * @return mixed
     * @throws Exception
     */
    protected function processResponse($resp)
    {
        $parseResp = $resp->toArray();
        if (!empty($parseResp['error'])) {
            $message = $parseResp['error'] . ' - ' . $parseResp['error_description'];
        } else if (!empty($parseResp['errors'])) {
            $message = Arr::get($parseResp, 'errors.0.domain') . ' - ' . Arr::get($parseResp, 'errors.0.message') . ' - ' . Arr::get($parseResp, 'errors.0.longMessage');
        }

        if (isset($message)) {
            throw new Exception($message);
        }
        return $resp->toArray();
    }
}
