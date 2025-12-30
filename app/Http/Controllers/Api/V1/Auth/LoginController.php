<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\ApiGatewayService;

class LoginController extends Controller
{
    protected $auth;
    protected $apiGateway;

    public function __construct(AuthService $auth,ApiGatewayService $apiGateway)
    {
        $this->auth = $auth;
        $this->apiGateway = $apiGateway;
    }

    public function login(LoginRequest $request)
    {
        $data = $this->auth->login($request->only('email', 'password'));

        if (!$data['status']) {
            writeLog(
            action: 'Signin',
            description: 'User Try to sign in but fail',
            request: $request->all(),
            response: ['message' => 'Signin fail'],
            status: 'fail'
            );
            return $this->apiGateway::error($data['message'],[],403);
        }

         writeLog(
            action: 'Signin',
            description: 'User Try to sign in',
            request: $request->all(),
            response: ['message' => 'Signin successful'],
            status: 'success'
        );

        return $this->apiGateway::success($data['message'], $data ,200);
    }



    public function me(){
        return $this->auth->me();
        return $this->apiGateway::success($data['message'],$data,201);
    }
}
