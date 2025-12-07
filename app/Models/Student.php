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
        'user_id'
    ];
}
