<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;


class AttendanceController extends Controller
{
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

        return response()->json([
            'status' => true,
            'message' => 'Attendance marked successfully',
            'data' => $attendance,
        ]);
    }

    public function getAttendance(Request $request)
    {
        $tenantId = 1;//auth()->user()->tenant_id;

        $studentAttendances = Attendance::with('user')
            ->forTenant($tenantId)
            ->whereHas('user', fn($q) => $q->where('role', 'student'))
            // ->whereDate('date', today())
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Attendance fetched successfully',
            'data' => $studentAttendances,
        ]);     
    }

}
