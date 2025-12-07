<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
            'user_id',
            'action',
            'description',
            'request_data',
            'response_data',
            'ip_address',
            'user_agent',
            'status'
        ];

        protected $casts = [
            'request_data' => 'array',
            'response_data' => 'array',
        ];
}
