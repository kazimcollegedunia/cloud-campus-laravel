<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use  App\Services\AttendanceService;
use App\Services\ApiGatewayService;



class AttendanceController extends Controller
{

    public $attendanceService;
    public $apiGateway;
    public function __construct(AttendanceService $attendanceService, ApiGatewayService $apiGateway)
    {
        $this->attendanceService = $attendanceService;
        $this->apiGateway = $apiGateway;
    }
    public function markAttendance(Request $request)
    {
        $tenantId = 1; //auth()->user()->tenant_id;    // current school

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date'    => 'required|date',
            'status'  => 'required|in:present,absent,leave,half_day',
            'in_time' => 'nullable|date_format:H:i',
            'out_time'=> 'nullable|date_format:H:i',
            'remarks' => 'nullable|string|max:255',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'tenant_id' => $tenantId,
                'user_id'   => $data['user_id'],
                'date'      => $data['date'],
            ],
            [
                'status'   => $data['status'],
                'in_time'  => $data['in_time'] ?? null,
                'out_time' => $data['out_time'] ?? null,
                'remarks'  => $data['remarks'] ?? null,
            ]
        );
        return $this->apiGateway::success('Attendance marked successfully', $attendance);
    }

    public function getAttendance(Request $request)
    {
        $dataPass = $this->apiGateway->prepareDataPass($request);
       $studentAttendances =  $this->attendanceService->fetchAllAttendances($dataPass);
        return $this->apiGateway::success('Attendance fetched successfully', $studentAttendances);   
    }

    public function getTodayAttendanceSummary(Request $request){
        $dataPass = $this->apiGateway->prepareDataPass($request); 
        $studentAttendances =  $this->attendanceService->getTodayAttendanceSummary($dataPass);
        return $this->apiGateway::success('Attendance fetched successfully', $studentAttendances);
    }

}
