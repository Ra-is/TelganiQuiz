<?php

namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
    public function __construct($data, $status = 200, $headers = [], $options = 0)
    {
        parent::__construct(['status' => 'success', 'token' => $data], $status, $headers, $options);
    }
}