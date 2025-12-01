<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        "name",
        'class',
        'section',
        'roll_no',
        'contact_no',
        'status'];
}
