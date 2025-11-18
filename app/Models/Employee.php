<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'email', 'department_id'];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function contactNumbers()
    {
        return $this->hasMany(ContactNumber::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

}
