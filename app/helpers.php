<?php
use App\Services\LogService;
use Carbon\Carbon;

if (!function_exists('writeLog')) {
    function writeLog($action, $description = null, $request = null, $response = null, $status = 'success') {
        return LogService::write($action, $description, $request, $response, $status);
    }
}

if (!function_exists('sessionMonthWithYears')) {
    /**
     * Get academic session months (March → February)
     *
     * @param int|null $year  Academic start year (e.g. 2024)
     * @return array
     */
   function sessionMonthWithYears(?int $year = null): array
    {
        $now = now();

        // Determine academic start year (March → Feb)
        $startYear = $year ?? ($now->month >= 3 ? $now->year : $now->year - 1);

        $result = [];
        $index  = 1;

        // March → December (start year)
        for ($month = 3; $month <= 12; $month++, $index++) {
            $result[Carbon::create($startYear, $month)
                ->format('Y-m')] = Carbon::create($startYear, $month)
                ->format('Y F');
        }

        // January → February (next year)
        for ($month = 1; $month <= 2; $month++, $index++) {
            $result[Carbon::create($startYear + 1, $month)
                ->format('Y-m')] = Carbon::create($startYear + 1, $month)
                ->format('Y F');
        }
        $finalMonths = [];
        foreach($result as $key =>$month){
            $finalMonths[] = [
               "value"  => $key,
               "label"  => $month,
            ];
        }
        return $finalMonths;
    }
}

if (!function_exists('FeeFrequency')) {
    /**
     * Get academic session months (March → February)
     *
     * @param int|null $year  Academic start year (e.g. 2024)
     * @return array
     */
   function FeeFrequency(?int $year = null): array
    {
        $frequencies = [
            ['lable' => 'monthly',    'value' => 'Monthly'],
            ['lable' => 'quarterly' , 'value' => 'Quarterly'],
            ['lable' => 'halfyearly', 'value' => 'Half Yearly'],
            ['lable' => 'yearly', 'value' => 'Yearly']
        ];
        
        return $frequencies;
    }
}
