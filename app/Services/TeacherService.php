<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Services\ApiGatewayService;
use Exception;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Throw_;

class TeacherService
{
    protected $repo;
    protected $apiGateway;
    protected $userRepo;

    public function __construct(TeacherRepositoryInterface $repo,ApiGatewayService $apiGateway,UserRepositoryInterface $userRepo)
    {
        $this->repo = $repo;
        $this->apiGateway = $apiGateway;
        $this->userRepo = $userRepo;
    }

    public function store($data,$tenantId){
      DB::beginTransaction();

        try {
            // 1) Create USER
            $user = $this->userRepo->createUser([
                'tenant_id'   => $tenantId,
                'name'        => $data['name'],
                'email' => $data['email'],
                'phone'       => $data['phone'] ?? null,
                'role' => 'teacher'
            ]);

            if (!$user) {
                 throw new \Exception('User creation failed');
            }

            // !empty($adminId) ? $this-> api
            // 2) Create STUDENT
            $teacher = $this->repo->store([
                'user_id' => $user->id,
                'tenant_id' => $tenantId,
                'salary' => $data['salary'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'address' => $data['address'],
                'designation' => $data['designation'],
                'employee_code' => Str::random(5),
                'qualification' => $data['qualification'],
                'experience_years' => $data['experience_years'],
                'joining_date' => $data['joining_date'],
                'emergency_contact' => $data['emergency_contact'],
            ]);

            if (!$teacher) {
                throw new \Exception('Teacher creation failed');
                writeLog('failed',"Teacher creation Failed",$data->all(),null,'Failed');
            }

            $teacherSubjectArr = $this->_prepareTeacherSubject($teacher->id,$data['primary_subject']);

            $teacherSubjectDb = $this->repo->teacherSubject($teacherSubjectArr);
            if(!$teacherSubjectDb){
                throw new \Exception('Teacher creation failed');
                writeLog('failed',"Teacher subject creation Failed",$teacherSubjectDb,null,'Failed');
            }

            DB::commit();
            writeLog('success',"Teacher subject creation Successfully",$teacherSubjectDb,["User" => $user,"Teacher" =>$teacher]);
            return [
                'status'  => true,
                'message' => 'Teacher created successfully',
                'user'    => $user,
                'teacher' => $teacher
            ];

        } catch (\Exception $e) {
                DB::rollBack();
                writeLog('failed',"Teacher creation failed (Something went wrong)",$data->all(),$e->getMessage(),"Failed");
                return [
                    'status' => false,
                    'message' => 'Something went wrong',
                    'error'   => $e->getMessage()
                ];
        }
    }

    protected function _prepareTeacherSubject(int $teacher_id, string $subjectStr): array
    {
        $subjectIds = array_filter(
            array_map('intval', explode(',', $subjectStr))
        );

        $teacherSubjectArr = [];

        foreach ($subjectIds as $subjectId) {
            $teacherSubjectArr[] = [
                'teacher_id' => $teacher_id,
                'subject_id' => $subjectId,
            ];
        }
        return $teacherSubjectArr;
    }

    public function index($dataPass){
        // try{
            $dbDataArr = $this->repo->all($dataPass);
            $teacherListArr = $this->_prepareTeacherDataRes($dbDataArr);
            return $teacherListArr;
        // }catch (Exception $e){
        //     return [
        //         'status' => false,
        //         "message" => $e->getMessage()
        //     ];
        // }
        

    }

    protected function _prepareTeacherDataRes($listArr ,$column = [])
    {

        $resultArr = [];
        foreach($listArr as  $key => $list){
            $subjects = [];
            foreach($list->teacherSubject as $key => $subject){
                $subjects[] = [
                    $subject->subject_id => $subject->subjects->subject,
                ];
            }

            $resultArr[] = [
                "user_id" => $list->userDetails->id,
                "tenant_id" => $list->userDetails->tenant_id,
                "name" => $list->userDetails->name,
                "email" => $list->userDetails->email,
                "phone" => $list->userDetails->phone,
                "teacher_id" => $list->id,
                "qualification" => $list->qualification,
                "experience_years" => $list->experience_years,
                "joining_date" => $list->joining_date,
                "gender" => $list->gender,
                "dob" => $list->dob,
                "salary" => $list->salary,
                "address" => $list->address,
                "subject" => $subjects,
                "status" => ucfirst($list->userDetails->status),
            ];
        }
        return $resultArr;
    }

    public function statusUpdate($dataPass){
        try{
            $dbUpdateData = $this->repo->statusUpdate($dataPass);
            if($dbUpdateData) {
                $teacherUpdatedDbData = $this->repo->all($dataPass);
            }
            return [
                    'status' => false,
                     'message' => "status updated successfully",
                     'data' => $teacherUpdatedDbData 
                    ];
        }catch(Exception $e){
            return ['status' => false, 'message' => $e->getMessage() ];
        }
        
        
    }

    public function teacherDetails($dataPass){
        try{
            $teacherDbData =  $this->repo->teacherDetails($dataPass);
            if(!$teacherDbData) {
                throw new \Exception('teacher details getting error');
            }

            $teacherDataArr = $this->_prapareTeacherDetailsData($teacherDbData);

            return [
                    'status' => false,
                     'message' => "teacher details data",
                     'data' => $teacherDataArr
                    ];
        }catch(Exception $e){
            writeLog('teacher-details-api',"getting eror",$dataPass,$e->getMessage(),'failed');
            return [
                'status' => true,
                'message' => $e->getMessage() 
            ];
        }
    }

    protected function _prapareTeacherDetailsData($teacherDbData){
        $teacherDataArr = [];
        if(!empty($teacherDbData)){
            $teacherDataArr = [
                "teacher_id" => $teacherDbData->id,
                "tenant_id" => $teacherDbData->tenant_id,
                "user_id" => $teacherDbData->user_id,
                "name" => $teacherDbData->userDetails->name,
                "email" => $teacherDbData->userDetails->email,
                "phone" => $teacherDbData->userDetails->phone,
                "designation" => $teacherDbData->designation,
                "qualification" => $teacherDbData->qualification,
                "experience_years" => $teacherDbData->experience_years."Years",
                "joining_date" => $teacherDbData->joining_date,
                "gender" => $teacherDbData->gender,
                "dob" => $teacherDbData->dob,
                "address" => $teacherDbData->address,
                "emergency_contact" => $teacherDbData->emergency_contact,
                "status" => ucfirst($teacherDbData->status),
                "recent_ctivity" => [["Assigned to Class 10-A" => "1 week ago"]],
                "assigned_classes" => ["Class 1 - A" ,"Class 2 - C","Class 3 - B","Class 4 - A"],
            ];
        }
        return $teacherDataArr;



    }

}
