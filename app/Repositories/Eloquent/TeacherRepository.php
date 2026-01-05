<?php

namespace App\Repositories\Eloquent;

use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Repositories\Contracts\TeacherRepositoryInterface;

class TeacherRepository implements TeacherRepositoryInterface
{
    protected $model;
    protected $subjectmodel;

    public function __construct(Teacher $teacher,TeacherSubject $subjectmodel)
    {
        $this->model = $teacher;
        $this->subjectmodel = $subjectmodel;
    }

    public function store(array $data)
    {
        return $this->model::create([
            'user_id'      => $data['user_id'],
            'salary'     => $data['salary'],
            'gender'      => $data['gender'],
            'dob'          => $data['dob'],
            'qualification'       => $data['qualification'],
            'designation'  => $data['designation'],
            'experience_years' => $data['experience_years'],
            'joining_date' => $data['joining_date'],
            'emergency_contact'      => $data['emergency_contact'],
            'tenant_id'      => $data['tenant_id'],
            'status'       => 'active',
            "employee_code" => $data['employee_code']
        ]);
    }

    public function teacherSubject(Array $subjects){
            return $this->subjectmodel::insert($subjects);
    }

    public function all($dataPass)
    {
         return $this->model
            ->with('userDetails', 'teacherSubject.subjects')
            ->when(!empty($dataPass['term']), function ($query) use ($dataPass) {

                $term = trim($dataPass['term']);

                $query->where(function ($q) use ($term) {
                    // Search by teacher name
                    $q->whereHas('userDetails', function ($u) use ($term) {
                        $u->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('phone', 'LIKE', "%{$term}%")
                        ->orWhere('email', 'LIKE', "%{$term}%");
                    });
                });
            })
            ->where('tenant_id', $dataPass['tenant_id'])
            ->when(isset($data['teacher_id']),fn($q) => (
                $q->where('id',$dataPass['teacher_id'])
            ))
            ->get();
    }

    public function statusUpdate(array $dataPass){
        return $this->model->where('id',$dataPass['teacher_id'])->update(['status'=>$dataPass['status']]);
        
    }

    public function teacherDetails($dataPass) 
    {
        return $this->model->with('userDetails')->where('id',$dataPass['teacher_id'])->first();
    }

}
