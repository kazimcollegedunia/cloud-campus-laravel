<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
        'employee_id',
        'address_line',
        'street',
        'city',
        'state',
        'pincode',
        'country',
    ];
}
