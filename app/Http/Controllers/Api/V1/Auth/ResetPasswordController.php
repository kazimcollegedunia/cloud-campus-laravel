<?php
namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'token'                 => 'required',
            'password'              => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user) use ($request){
                $user->password = Hash::make($request->password);
                $user->save();
            }
        );

        return response()->json([
            "message" => $status === Password::PASSWORD_RESET
                ? "Password reset successfully"
                : "Invalid token"
        ]);
    }
}
