<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials)
    {
        // Check Email + Password
        if (!Auth::attempt($credentials)) {
            return [
                'status' => false,
                'message' => 'Invalid email or password'
            ];
        }

        $user = Auth::user();

        // Create new access token
        $token = $user->createToken('authToken')->accessToken;

        return [
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user'  => $user,
        ];
    }
}
