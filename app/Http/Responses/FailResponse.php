<?php

namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;

class FailResponse extends JsonResponse
{
    public function __construct($status = 400, $headers = [], $options = 0)
    {
        parent::__construct(['status' => 'failure'], $status, $headers, $options);
    }
}