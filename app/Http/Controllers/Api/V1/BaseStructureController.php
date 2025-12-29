<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiGatewayService;

class BaseStructureController extends Controller
{

    public $apiGateway;
    const BASE_STRUCTURE_CONTROLLER_INDEX_API = 'base_structure_controller_index_api';
    public function __construct(ApiGatewayService $apiGateway)
    {
        $this->apiGateway = $apiGateway; 
    }
    
    public function index(Request $request){
        // This is my basic structure of every api  
        // STEP-1
        // this is my api type with the help of this ve acan iddentify the api and give the data nad datapass according to this (if datapass and api validateRequest request modify )
        $apiType = self::BASE_STRUCTURE_CONTROLLER_INDEX_API;
        // STEP-2 
        // validate require param only validate param if extra param then send the error 
        $this->apiGateway->validateRequest($request,$apiType);
        // This is my generic data pass if we need other column(field) the add and merge according (isko app apne hisaab se bana dena main laerge sacl type api product bana raha hu future me zayada modifiction na karna pade ) 
        $dataPass = $this->apiGateway->prepareDataPass($request,$apiType);
        // This is my service functio and i will call model and all form here For now asume This is the service i will be change thi si only for setup 
        $dbDataArr = $this->apiGateway->dbDataArr($dataPass);
        if($dbDataArr['status']){
            return $dbDataArr = $this->apiGateway::success('Message','Data','status');
        }

        if(!$dbDataArr['status']){
            return $dbDataArr = $this->apiGateway::error('Message','Error','status');
        }
        
        
    }
}
