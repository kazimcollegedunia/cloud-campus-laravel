<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'date',
        'status',
        'in_time',
        'out_time',
        'remarks',
        'meta',
    ];

    protected $casts = [
        'date' => 'date',
        'in_time' => 'datetime:H:i',
        'out_time' => 'datetime:H:i',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
