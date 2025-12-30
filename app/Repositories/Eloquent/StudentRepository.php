<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Models\User;
use App\Repositories\Contracts\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $student)
    {
        $this->model = $student;
    }

    public function all($dataPass)
    {
        $student = Student::query()
            ->join('users', 'students.user_id', '=', 'users.id');

        // Apply select if provided, else fallback to default select
        if (!empty($dataPass['fields'])) {
            $student->select($dataPass['fields']);
        } else {
            $student->select('students.*', 'users.name as student_name');
        }

        // class filter
        if (!empty($dataPass['class_id'])) {
            $student->where('class_id', $dataPass['class_id']);
        }

        // section filter
        if (!empty($dataPass['section'])) {
            $student->where('section', $dataPass['section']);
        }

        $student->where('students.tenant_id', $dataPass['tenant_id']);
        
        // term search
        if (!empty($dataPass['term'])) {
            $term = $dataPass['term'];
            $student->where(function($q) use ($term) {
                $q->where('users.name', 'LIKE', "%{$term}%")
                ->orWhere('students.class_id', 'LIKE', "%{$term}%")
                ->orWhere('students.section', 'LIKE', "%{$term}%")
                ->orWhere('students.admission_no', 'LIKE', "%{$term}%");
            });
        }

        $studentData  = $student->orderBy('students.id', 'DESC')->get();
        $studentCount = $student->count();

        return [
            "studentData"  => $studentData,
            "studentCount" => $studentCount
        ];
    }

    public function createStudent(array $data)
    {
        return Student::create([
            'user_id'      => $data['user_id'],
            'admission_no' => $data['admission_no'],
            'class_id'     => $data['class_id'],
            'section'      => $data['section'],
            'dob'          => $data['dob'],
            'gender'       => $data['gender'],
            'parent_name'  => $data['parent_name'],
            'parent_email' => $data['parent_email'],
            'parent_phone' => $data['parent_phone'],
            'address'      => $data['address'],
            'tenant_id'      => $data['tenant_id'],
            'status'       => 'active',
        ]);
    }

    public function isAdmissionNoExists($admissionNo)
    {
        return $this->model->where('admission_no', $admissionNo)->exists();
    }

     public function getStudentFeeList($dataPass){
        return $this->model
        ->with('user')
         ->select(
                'students.id','students.section','students.user_id','students.class_id',
                'fees.id as fee_id','fees.student_id','fees.receipt_no','fees.receipt_no','fees.amount_inr','fees.paid_amount','fees.due_date','fees.status','fees.month',
                'fee_types.name as fee_type_name','fee_types.id as fee_type_id','fee_types.amount_inr as  fee_type_amount'
                )
                ->leftJoin('fees', function ($join) use ($dataPass) {
                        $join->on('fees.student_id', '=', 'students.id')
                            ->where('fees.tenant_id', $dataPass['tenant_id'])
                            ->where('fees.month', $dataPass['month'])
                            ->when(isset($dataPass['feeType']),fn($q) => $q->where('fees.fee_type_id', $dataPass['feeType']));
                    })
                    ->leftJoin('fee_types', function ($join) use ($dataPass) {
                        $join->on('fee_types.tenant_id', '=', 'students.tenant_id')
                            ->where('fee_types.id', $dataPass['feeType']);
                    })
                ->where('students.tenant_id',$dataPass['tenant_id'])
                ->when(isset($dataPass['section']),fn($q) => $q->where('section',$dataPass['section']))
                ->when(isset($dataPass['class_id']),fn($q) => $q->where('students.class_id',$dataPass['class_id']))
                ->when(isset($dataPass['status']),fn($q) => $q->where('fees.status', $dataPass['status']))
                ->get();
    }


    // public function getStudentFeeList($dataPass){
        
    //     $query =  $this->model
    //     ->with('user')
    //     ->select(
    //             'students.id','students.section','students.user_id','students.class_id',
    //             'fees.id as fee_id','fees.student_id','fees.receipt_no','fees.receipt_no','fees.amount_inr','fees.paid_amount','fees.due_date','fees.status','fees.month',
    //             'fee_types.name as fee_type_name','fee_types.id as fee_type_id','fee_types.amount_inr as  fee_type_amount'
    //             )
    //             ->leftJoin('fees', function ($join) use ($dataPass) {
    //                     $join->on('fees.student_id', '=', 'students.id')
    //                         ->where('fees.tenant_id', $dataPass['tenant_id'])
    //                         ->where('fees.month', $dataPass['month'])
    //                         ->when(isset($dataPass['feeType']),fn($q) => $q->where('fees.fee_type_id', $dataPass['feeType']));
    //                 })
    //                 ->leftJoin('fee_types', function ($join) use ($dataPass) {
    //                     $join->on('fee_types.tenant_id', '=', 'students.tenant_id')
    //                         ->where('fee_types.id', $dataPass['feeType']);
    //                 })
    //             ->where('students.tenant_id',$dataPass['tenant_id'])
    //             ->when(isset($dataPass['section']),fn($q) => $q->where('section',$dataPass['section']))
    //             ->when(isset($dataPass['class_id']),fn($q) => $q->where('students.class_id',$dataPass['class_id']))
    //             ->when(isset($dataPass['status']),fn($q) => $q->where('fees.status', $dataPass['status']));
    //             // ->get();
    //             $sql = $query->toRawSql();
    //             dd($sql);
                
    // }

}
