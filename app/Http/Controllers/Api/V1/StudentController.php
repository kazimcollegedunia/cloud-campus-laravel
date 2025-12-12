<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Services\StudentService;
use App\Services\ApiGatewayService;
use Illuminate\Http\Request;
use Exception;


class StudentController extends Controller
{   
    public $studentService;
    public $apiGateway;

    public function __construct(StudentService $studentService,ApiGatewayService $apiGateway)
    {
        $this->studentService = $studentService;
        $this->apiGateway = $apiGateway;
    }

    public function studentLists(Request $request){
        try{
            $dataPass = $this->apiGateway->prepareDataPass($request);
            $studentData = $this->studentService->getStudents($dataPass);
            return $this->apiGateway::success('Student fetched successfully', $studentData);    
        }catch(Exception $e ){
             writeLog(
                action: 'studentLists Api fail',
                description: 'Student list get successfully',
                request: $request->all(),
                response: $e->getMessage(),
                status: 'fail'
            );
            return $this->apiGateway::error('Something went wrong', ['error' => $e->getMessage()], 500);
        } 
    }

    public function store(StudentRequest $request)
    {
      $response = $this->studentService->createStudent($request->all());
        if (!$response['status']) {
            writeLog(
                action: 'Student Creation',
                description: $response['message'],
                request: $request->all(),
                response: $response,
                status: 'fail'
            );
            return $this->apiGateway::error('Student creation failed', ['error' => $response['message']], 500);
        }

        writeLog(
            action: 'Student Creation',
            description: 'Student created successfully',
            request: $request->all(),
            response: $response,
            status: 'success'
        );

        return $this->apiGateway::success('Student created successfully', [
            'user'    => $response['user'],
            'student' => $response['student'],
        ], 201);
    }

    public function index(Request $request){

    }
    public function show($id)
    {
       
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}


