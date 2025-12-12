<?php
namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ApiGatewayService;

class RegisterController extends Controller
{
    public $auth;
    public $apiGateway;

    public function __construct(AuthService $studentService,ApiGatewayService $apiGateway){
        $this->auth = $studentService;
        $this->apiGateway = $apiGateway;
    }

    
    public function register(RegisterRequest $request)
    {
        $user = $this->auth->registerUsers($request);
        writeLog(
            'New Acount create',
            "Account created successfully",
            $request->all(),
            $user,
        );

        return $this->apiGateway::success("Account created successfully",$user,200);
    }
}


