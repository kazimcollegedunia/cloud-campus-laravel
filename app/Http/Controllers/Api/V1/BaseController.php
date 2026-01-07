<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiGatewayService;
use App\DTOs\ServiceResult;


class BaseController extends Controller
{
    protected $apiGateway;

    public function __construct(ApiGatewayService $apiGateway)
    {
        $this->apiGateway  = $apiGateway;
    }

    protected function respond(ServiceResult $result)
    {
        return $result->success
            ? $this->apiGateway::success(
                $result->message,
                $result->data,
                $result->status,
            )
            : $this->apiGateway::error(
                $result->message,
                $result->data,
                $result->status
            );
    }
}
