<?php

namespace App\Models;
// use App\Models\FeePayment;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'tenant_id',
        'student_id',
        'fee_type_id',
        'amount_inr',
        'due_date',
        'remarks',
        'meta',
        'paid_at',
        'receipt_no',
        'paid_amount',
    ];

    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'fee_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function student()
    {
     
            return $this->belongsTo(Student::class)
                ->select('id', 'class_id', 'section','user_id');
        // return $this->belongsTo(Student::class)->select('students.class_id','section');
    }

}
