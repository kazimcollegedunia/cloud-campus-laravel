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
            return response()->json($data, 401);
        }

        return response()->json($data, 200);
    }
}
