<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
         'user_id','tenant_id','salary','gender','dob','qualification','designation','experience_years','joining_date','emergency_contact','status','employee_code'
    ];

    public function activeTeacherData(){

    }

    public function teacherSubject(){
        return $this->hasMany(TeacherSubject::class,'teacher_id')->select('teacher_id','subject_id');
    }

    public function userDetails(){
        return $this->hasOne(User::class,'id','user_id')->select('id','tenant_id','name','email','phone');
    }
}
