<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
{   
    public function index(Request $request){
        $student = Student::query();
        $student->join('users', 'students.user_id', '=', 'users.id')->select('students.*', 'users.name as student_name');
        // dd($request->filled('class'));
        // Filter by class
        if ($request->filled('class_id')) {
            $student->where('class_id', $request->class_id);
        }

        // Filter by section
        if ($request->filled('section')) {
            $student->where('section', $request->section);
        }

        // Search by name, class, roll_no
        if ($request->filled('search')) {
            $search = $request->search;

            $student->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                ->orWhere('class_id', 'LIKE', "%{$search}%");
                // ->orWhere('roll_no', 'LIKE', "%{$search}%");
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
        $class = Student::distinct()->orderBy('class_id')->pluck('class');
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

    public function getStudent(){
        $students = User::getAllStudent();
        return response()->json([
            'status'  => true,
            'message' => 'success',
            'data'    => $students
        ], 200);
    }

    

     public function show($id)
    {
       
    }

   public function store(StudentRequest $request)
    {
            DB::beginTransaction();
        $tenant_id = 1; // Replace with actual tenant ID retrieval logic
        $admission_no = rand(100000, 999999); // Example admission number generation
        // dd($admission_no);
        try {
            // 1️⃣ Create USER
            $user = User::create([
                'tenant_id' => $tenant_id, //auth()->user()->tenant_id, // or $request->tenant_id
                'name'      => $request->name,
                'email'     => $request->parent_email ?? null,
                'phone'     => $request->phone ?? null,
                'password'  => bcrypt('password'),
                // 'tenant_id'  => $tenant_id,

                // role always student
                'role'      => 'student',
            ]);

            // If user not created, log + return
            if (!$user) {
                writeLog(
                    action: 'Student Creation',
                    description: 'User creation failed',
                    request: $request->all(),
                    response: ['message' => 'User creation failed'],
                    status: 'fail'
                );

                DB::rollBack();
                return response()->json([
                    'status'  => false,
                    'message' => 'User creation failed',
                ], 500);
            }

            // 2️⃣ Create STUDENT record using user_id
            $student = Student::create([
                'user_id'       => $user->id,
                'admission_no'  => $admission_no,
                'class_id'      => $request->class_id,
                'section'       => $request->section,
                'dob'           => $request->dob,
                'gender'        => $request->gender,
                'parent_name'   => $request->parent_name,
                'parent_email'  => $request->parent_email,
                'parent_phone'  => $request->parent_phone,
                'address'       => $request->address,
                'status'        => 'active',
            ]);

            if (!$student) {
                writeLog(
                    action: 'Student Creation',
                    description: 'Student creation failed',
                    request: $request->all(),
                    response: ['message' => 'Student create failed'],
                    status: 'fail'
                );

                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Student creation failed',
                ], 500);
            }

            DB::commit();

            // 3️⃣ Log success
            writeLog(
                action: 'Student Creation',
                description: 'Student creation successful',
                request: $request->all(),
                response: ['message' => 'Student created successfully'],
                status: 'success'
            );

            return response()->json([
                'status'  => true,
                'message' => 'Student created successfully',
                'data'    => [
                    'user' => $user,
                    'student' => $student,
                ]
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            writeLog(
                action: 'Student Creation',
                description: $e->getMessage(),
                request: $request->all(),
                response: ['error' => $e->getMessage()],
                status: 'fail'
            );

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(UpdateEmployeeRequest $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}


