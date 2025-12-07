<?php
use App\Services\LogService;

if (!function_exists('writeLog')) {
    function writeLog($action, $description = null, $request = null, $response = null, $status = 'success') {
        return LogService::write($action, $description, $request, $response, $status);
    }
}
