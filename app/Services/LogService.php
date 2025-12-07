<?php
namespace App\Services;

use App\Models\SystemLog;

class LogService
{
    public static function write($action, $description = null, $requestData = null, $responseData = null, $status = 'success')
    {
        return SystemLog::create([
            'user_id'      => auth()->check() ? auth()->id() : null,
            'action'       => $action,
            'description'  => $description,
            'request_data' => $requestData,
            'response_data'=> $responseData,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
            'status'       => $status,
        ]);
    }
}
