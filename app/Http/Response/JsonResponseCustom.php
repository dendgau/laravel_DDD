<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse as Response;

/**
 * Class JsonResponseDefault
 * @package App\Http\Response
 */
class JsonResponseCustom
{
    /**
     * @param $success
     * @param $data
     * @param $message
     * @param $code
     * @param int $httpCode
     * @return mixed
     */
    public static function create($success, $data, $message, $httpCode = 200)
    {
        $response = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
            'code' => $httpCode
        ];
        $header = [$httpCode => $response['message']];
        return Response::create($response, $httpCode, $header);
    }
}
