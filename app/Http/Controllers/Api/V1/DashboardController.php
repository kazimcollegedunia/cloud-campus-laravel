<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiGatewayService;


class DashboardController extends Controller
{
    public $apiGateway;

    public function __construct(ApiGatewayService $apiGateway)
    {
        $this->apiGateway = $apiGateway;
    }

    public function index()
    {
        $data = [
            'total_student' => "3,210",
            "total_teachers" => 150,
            "total_classes" => 25,
            "total_sections" => 75,
            "pending_fees" => "42,100",
        ];

        return $this->apiGateway::success('Dashboard data fetched successfully', $data);
    }
}
