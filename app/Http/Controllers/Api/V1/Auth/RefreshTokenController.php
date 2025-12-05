<?php
namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function refresh(Request $request)
    {
        return response()->json([
            "access_token" => $request->user()->createToken('authToken')->accessToken
        ]);
    }
}
