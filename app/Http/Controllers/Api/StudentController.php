<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request){
        $student = Student::query();
        // dd($request->filled('class'));
        // Filter by class
        if ($request->filled('class')) {
            $student->where('class', $request->class);
        }

        // Filter by section
        if ($request->filled('section')) {
            $student->where('section', $request->section);
        }

        // Search by name, class, roll_no
        if ($request->filled('search')) {
            $search = $request->search;

            $student->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('class', 'LIKE', "%{$search}%")
                ->orWhere('roll_no', 'LIKE', "%{$search}%");
            });
        }

        $sutdentData = $student->orderBy('id', 'DESC')->get();
        $sutdentCount = $student->count();
        $data = [ "studentData" => $sutdentData, "studentCount" => $sutdentCount];

        return response()->json([
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ], 200);
    }

    public function getClass(){
        $class = Student::distinct()->orderBy('class')->pluck('class');
        // $class = sort($class);
        return response()->json([
            'status'  => true,
            'message' => 'success',
            'data'    => $class
        ], 200);
    }
    public function getSection(){
        $section = Student::distinct()->orderBy('section')->pluck('section');
        return response()->json([
            'status'  => true,
            'message' => 'success',
            'data'    => $section
        ], 200);
    }

    

     public function show($id)
    {
       
    }

    public function store(StoreEmployeeRequest $request)
    {   
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}


