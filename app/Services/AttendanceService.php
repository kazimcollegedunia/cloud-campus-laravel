<?php

namespace App\Services;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use function Laravel\Prompts\form;
use function PHPSTORM_META\map;

class AttendanceService
{
    protected $repo;
    protected $userRepo;

    public function __construct(AttendanceRepositoryInterface $repo, UserRepositoryInterface $userRepo)
    {
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }

    public function fetchAllAttendances($dataPass = [])
    {
        $dataPass["select"] = [
                'users.id as user_id',
                'users.name',
                'a.date',
                'a.status',
                's.class_id',
                's.section',];
        return $this->userRepo->getAllStudent($dataPass);
    }

    public function getTodayAttendanceSummary($dataPass = [])
    {
        $data =  $this->fetchAllAttendances($dataPass);
        $summary["summary"] =  $this->formatAttendanceData($data);
        return $summary;
    }

    protected function formatAttendanceData($attendances)
    {
        $totalStudents = $attendances->count();
        $absentStudents = $attendances->where('status', 'absent')->count();
        $presentStudents = $attendances->where('status', 'present')->count();
        $attendancespercent = ($totalStudents > 0) ? ($presentStudents / $totalStudents) * 100 : 0;
        $summary = [
            'total'    => $totalStudents,
            'present'  =>  $presentStudents,
            'absent'   => $absentStudents,
            'attendancespercent' => round($attendancespercent, 2),
        ];
        return $summary;

    }
}
