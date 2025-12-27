<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Services\ApiGatewayService;
use Exception;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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


}
