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

        writeLog("Attendance marked","Attendance marked for user_id: {$data['user_id']}",$request->all(),$attendance);  


        return $this->apiGateway::success('Attendance marked successfully', $attendance);
    }

    public function markAttendanceBulk(Request $request)
    {
        try{
            $tenantId = 1; // auth()->user()->tenant_id;

            // 1) Validate base fields
            $validated = $request->validate([
                'date' => 'required|date',
                'attendances' => 'required|array|min:1',
                'attendances.*.user_id' => 'required|exists:users,id',
                'attendances.*.status'  => 'required|in:present,absent,leave,half_day',
                'attendances.*.in_time' => 'nullable|date_format:H:i',
                'attendances.*.out_time'=> 'nullable|date_format:H:i',
                'attendances.*.remarks' => 'nullable|string|max:255',
            ]);

            $date = $validated['date'];
            $entries = $validated['attendances'];

            $results = [];
            foreach ($entries as $entry) {

                $attendance = Attendance::updateOrCreate(
                    [
                        'tenant_id' => $tenantId,
                        'user_id'   => $entry['user_id'],
                        'date'      => $date,
                    ],
                    [
                        'status'   => $entry['status'],
                        'in_time'  => $entry['in_time'] ?? null,
                        'out_time' => $entry['out_time'] ?? null,
                        'remarks'  => $entry['remarks'] ?? null,
                    ]
                );

                $results[] = $attendance;
            }

            writeLog(
                action: "Bulk Attendance",
                description: "Bulk attendance updated",
                request: $request->all(),
                response: $results,
                status: "success"
            );

            return $this->apiGateway::success("Bulk attendance marked successfully", [
                'count' => count($results),
                'records' => $results
            ]);
        } catch (\Exception $e) {
            writeLog(
                action: "Bulk Attendance",
                description: "Bulk attendance update failed: " . $e->getMessage(),
                request: $request->all(),
                response: null,
                status: "error"
            );

            return $this->apiGateway::error("Failed to mark bulk attendance: " . $e->getMessage());
        }
    }


    public function getAttendance(Request $request)
    {
        $dataPass = $this->apiGateway->prepareDataPass($request);
       $studentAttendances =  $this->attendanceService->fetchAllAttendances($dataPass);
        return $this->apiGateway::success('Attendance fetched successfully', $studentAttendances);   
    }

    public function getTodayAttendanceSummary(Request $request){
        $dataPass = $this->apiGateway->prepareDataPass($request); 
        // dd($dataPass);
        $studentAttendances =  $this->attendanceService->getTodayAttendanceSummary($dataPass);
        return $this->apiGateway::success('Attendance fetched successfully', $studentAttendances);
    }

}
