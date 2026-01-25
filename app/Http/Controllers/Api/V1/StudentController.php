<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StudentRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StudentListRequest;


class StudentController extends BaseController
{   
    public $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function studentLists(StudentListRequest $request){
        $studentData = $this->studentService->getStudents($request);
        return $this->respond($studentData);
    }

    public function store(StudentRequest $request)
    {
        $result = $this->studentService->createStudent($request->all());
        return $this->respond($result);
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


