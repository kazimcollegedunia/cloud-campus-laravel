<?php

namespace App\Services;
use Carbon\Carbon;

use PHPUnit\Runner\Baseline\Issue;

class ApiGatewayService
{

   public function prepareDataPass($request){
        $dataPass = [
            "user_id" => auth()->user()->id,
            "tenant_id" => auth()->user()->tenant_id,
            "class_id" => isset($request->class_id)  ? $request->class_id : null,
            "from_date" => isset($request->date) ?  $request->date : date('Y-m-d'),
            "month" => isset($request->month) ?  $request->month : date('Y-m'),
            "to_date" => isset($request->date) ?  $request->date : date('Y-m-d'),
            "section" => isset($request->section) ?  $request->section : null,
            "role" => isset($request->role) ?  $request->role : 'student',
            "term" => isset($request->search) ?  $request->search : null,
            "student_id" => isset($request->student_id) ?  $request->student_id : null,
            "status" => isset($request->status) ?  strtolower($request->status) : null,
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

    public static function selectFields($fields = [])
    {
        // If no fields passed, return wildcard array
        if (empty($fields)) {
            return ['*'];
        }

        return $fields;
    }

    // protected function generatedRandomToken($tenantDomain){
    //     $randumNumber = $tenantDomain.'-'.rand(100000, 999999);
    //     return $this->repo->isAdmissionNoExists($randumNumber) ? $this->generatedAdmissionToken($tenantDomain): $randumNumber;
    // }
    public function validateParam($request,$apiType){
        switch ($apiType) {
            case "show_teacher_data":
                $acceptedParam = ['name','subject','phone','email'];
                break;
            
            default:
                # code...
                break;
        }
    }

    // public static function paginate($data, $perPage = 15, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $data instanceof Collection ? $data : Collection::make($data);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }


}
