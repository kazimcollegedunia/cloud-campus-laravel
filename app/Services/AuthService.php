<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public $userRepo;
    public $apiGateway;

    public function __construct(UserRepositoryInterface $userRepo,ApiGatewayService $apiGateway){
        $this->userRepo = $userRepo;
        $this->apiGateway = $apiGateway;
    }

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
        $userDataArr = $this->me();
        return [
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user'  => $userDataArr,
        ];
    }

    public function registerUsers($request){
        $userDetails = [
            'tenant_id' => $request->tenant_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt($request->password),
            'role'      => $request->role
            ];

        return  $this->userRepo->createUser($userDetails); 
    }
    
    public function me(){
        try{
            $userDetails = auth()->user();
            if($userDetails){
                return $this->apiGateway::success("success",$userDetails,200);
            }
            return $this->apiGateway::error("error",[],401);
        }catch(Exception $e){
            writeLog('Get user data','me Api fail'. $e->getMessage(),'',$e->getMessage(),'failed');
            return $this->apiGateway::error("error",$e->getMessage(),401);
        }
       
        
    }
}
