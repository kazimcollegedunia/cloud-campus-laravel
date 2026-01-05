<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Requests\TeacherRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TeacherService;
use App\Services\ApiGatewayService;

class TeacherController extends Controller
{

    public $teacherService;
    public $apiGateway;
    public $tenantId;
    const SHOW_TEACHER_DATA = "show_teacher_data";

    public function __construct(TeacherService $teacherService,ApiGatewayService $apiGateway)
    {
        $this->teacherService = $teacherService;
        $this->apiGateway = $apiGateway;
        $this->tenantId = auth()->user()->tenant_id;
    }

    public function index(Request $request){
        // $request->role = 'admin';
        $dataPass = $this->apiGateway->prepareDataPass($request);
        $serviceData =   $this->teacherService->index($dataPass);
        return $this->apiGateway::success('Success',$serviceData);
        
    }

    public function store(TeacherRequest $request){
        $serviceData =   $this->teacherService->store($request,$this->tenantId);
        if(!$serviceData['status']){
            return $this->apiGateway::error($serviceData['message'],$serviceData['status'],205);
        }
        return $this->apiGateway::success($serviceData);
        

        
    }

    public function update(Request $request){
        
    }

    public function show(Request $request){
        $apiType = self::SHOW_TEACHER_DATA;
        $validate = $this->apiGateway->validateParam($request,$apiType);
        
    }

    public function statusUpdate(Request $request){
        // $request->role = 'admin';
        $dataPass = $this->apiGateway->prepareDataPass($request);
        $serviceData =   $this->teacherService->statusUpdate($dataPass);
        return $this->apiGateway::success('Success',$serviceData);
    }

    public function teacherDetails(Request $request){
        $dataPass = $this->apiGateway->prepareDataPass($request);
        $serviceData =   $this->teacherService->teacherDetails($dataPass);
        // dd($serviceData);
        if($serviceData['status']){
            return $this->apiGateway::error($serviceData['message'],[],403);
            
        }
        return $this->apiGateway::success($serviceData['message'],$serviceData['data']);
        

    }

    public function assigneClassSection(Request $request){
        dd($request->all());
    }
}
