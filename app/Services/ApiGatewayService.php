<?php

namespace App\Services;

use PHPUnit\Runner\Baseline\Issue;

class ApiGatewayService
{

   public function prepareDataPass($request){
        $dataPass = [
            "user_id" => "1",
            "tenant_id" => "1",
            "class_id" => isset($request->class_id)  ? $request->class_id : null,
            "from_date" => isset($request->date) ?  $request->date : date('Y-m-d'),
            "to_date" => isset($request->date) ?  $request->date : date('Y-m-d'),
            "section" => isset($request->section) ?  $request->section : null,
            "role" => isset($request->role) ?  $request->role : 'student',
        ];
        return $dataPass;
   }

   public static function success($message = 'Success', $data = [], $status = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    public static function error($message = 'Error', $errors = [], $status = 400)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }
}
