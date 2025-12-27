<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $fillable = ["teacher_id","subject_id"];

    public function subjects(){
        return  $this->belongsTo(Subject::class,'subject_id')->select('id','subject')->where('status','active');
    }
}
