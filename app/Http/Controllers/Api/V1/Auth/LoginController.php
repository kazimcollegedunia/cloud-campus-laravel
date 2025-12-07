<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class LoginController extends Controller
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
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
            return response()->json($data, 401);
        }

         writeLog(
            action: 'Signin',
            description: 'User Try to sign in',
            request: $request->all(),
            response: ['message' => 'Signin successful'],
            status: 'success'
        );

        return response()->json($data, 200);
    }
}
