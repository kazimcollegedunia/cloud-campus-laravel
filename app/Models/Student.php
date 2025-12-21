<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        "name",
        'class_id',
        'section',
        'roll_no',
        'admission_no',
        'dob',
        'gender',
        'parent_name',
        'parent_phone',
        'address',
        'user_id',
        'tenant_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)
                    ->select('id', 'name');
    }

    public function Fee(){
        return $this->HasOne(Fee::class,'student_id','id')->select('id','student_id');
    }

    public function StudentFeeS(){
        return $this->HasMany(Fee::class,'student_id','id');
    }

}
