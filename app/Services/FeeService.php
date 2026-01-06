<?php

namespace App\Services;

use App\Repositories\Contracts\FeeRepositoryInterface;
use App\Repositories\Contracts\FeeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Exception;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\ReturnValueGenerator;

class FeeService
{
    protected $repo;
    protected $studentRepo;

    public function __construct(FeeRepositoryInterface $rep,StudentRepositoryInterface $studentRepo)
    {
        $this->repo = $rep;
        $this->studentRepo = $studentRepo;
    }

    public function index($filters)
    {
        return  $data = $this->repo->index($filters);
        
        return $this->_dataMaping($data);
    }

    public function store($request)
    {
        $tenantId =  auth()->user()->tenant_id;
        $tenantDomain = $tenantDomain = Tenant::find($tenantId)->subdomain ?? null;
        $receiptNo = $this->generatedRandomToken(ucwords($tenantDomain));

        $matchData = [
            "student_id" => $request->student_id,
            "fee_type_id" => $request->fee_type_id,
            'month' => $request->month ?? Carbon::now()->format('Y-m') ,
        ];

        $isfeeExist = $this->repo->isfeeExist($matchData);

        if($isfeeExist){
            return [
                'status' => false,
                'message' => "Fees Already submited",
            ];
        }
        

        $extra = [
            'submitted_by' => auth()->id(),
            'receipt_no' => $receiptNo,
            'paid_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'month' => $request->month ?? Carbon::now()->format('Y-m') ,
            'paid_amount' => $request->paid_amount ?? $request->amount_inr,
            'amount_inr' => $request->paid_amount ?? $request->amount_inr, // auto fetch from fee type
            'status' => 'paid',
            'remarks' =>  $request->remarks ?? null,
            
        ];

        $payload = $this->prepareDbPayload($request,$extra);


        try {
            DB::beginTransaction();

            $fee = $this->repo->store($payload);

            DB::commit();

            writeLog(
                'Fee Submitted',
                'Fee submitted successfully',
                $payload
            );

         return [
                'status' => true,
                'message' => "Fee submited Successfully",
                'data' => $fee,
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            writeLog(
                'Fee Submit Failed',
                'Fee submission failed',
                $payload,
                $e->getMessage()
            );

            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    protected function prepareDbPayload($request, $extra = [], $isTenantId=true)
    {
        $payload = $request->toArray();
         if (!empty($isTenantId)) {
            $payload = array_merge($payload, [
                'tenant_id' => auth()->user()->tenant_id
            ]);
        }

        // merge extra if provided
        if (!empty($extra)) {
            $payload = array_merge($payload, $extra);
        }

        return $payload;
    }

    protected function _dataMaping($data){
        $dataMaping = [];
        foreach($data as $key => $value){
            $dataMaping[$key] = [
                    'id' => $value->id, 
                    'tenant_id' => $value->tenant_id, 
                    'student_id' => $value->student_id, 
                    'user_id' => $value->student->user_id, 
                    'amount_inr' => $value->amount_inr, 
                    'status' => $value->status, 
                    'receipt_no' => $value->receipt_no, 
                    'paid_at' => $value->paid_at, 
                    'remarks' => $value->remarks, 
                    'name' => $value->student->user->name, 
                    'feeType' => $value->feeType->name, 
                    'frequency' => $value->feeType->frequency, 
            ];
        }

        return $dataMaping;
    }

    public function getFeeInvoices($dataPass){
        // dd($dataPass);
         $data = $this->studentRepo->getStudentFeeList($dataPass);
        return $this->_preparedData($data,$dataPass);
    }

    protected function _preparedData($datas,$dataPass){
        $feeInvoiceData = [];
        foreach($datas as $key => $data){
            $status  = $this->getFeesStatus($data['status'],$dataPass);
            $feeInvoiceData[$key] = [
                'user_id' => $data['user_id'],
                'section' => $data['section'],
                'class_id' => $data['class_id'],
                'fee_id' => $data['fee_id'],
                'month' => $data['month'] ?  carbon::parse($data['month'])->format('F') : "NA",
                'student_id' => $data['id'],
                'receipt_no' => $data['receipt_no'],
                'amount_inr' => $data['amount_inr'],
                'paid_amount' => $data['paid_amount'],
                'due_date' => $dataPass['month'] ?  carbon::parse($dataPass['month'])->format('F') : "NA",
                'status' => ucfirst($status) ,
                'action' => $this->getActionButton($status) ,
                'fee_type_name' => $data['fee_type_name'],
                'fee_type_id' => $data['fee_type_id'],
                'fee_type_amount' => $data['fee_type_amount'],
                'user_id' => $data['user']['id'],
                'student_name' => $data['user']['name'],
            ];
        }
        return $feeInvoiceData;
    }

    protected function generatedRandomToken($tenantDomain){
        $data = Carbon::now()->format("Y-F");
        $randumNumber = $tenantDomain.'-'.$data.'-'.rand(100000, 999999);
        return $this->repo->isAdmissionNoExists($randumNumber) ? $this->generatedRandomToken($tenantDomain): $randumNumber;
    }


    public function getFeesStatus($status, $dataPass)
    {
        $currentMonth = Carbon::now()->format('Y-m');

        // Rule 1: status null → pending
        if (empty($status)) {

            // Rule 2: same month OR future month → pending
            // dd($dataPass['month'],$currentMonth);
            if (
                empty($dataPass['month']) ||
                $dataPass['month'] >=  $currentMonth
            ) {
                return 'Pending';
            }

            // Past month → overdue
            return 'Overdue';
        }

        // Rule 5: status already exists → return as is
        return $status;
    }

    public function getActionButton($status){
        $status = strtolower($status);
        $actionBtn = [
                'paid' => ["first_btn"=>'View',"second_btn" => 'Receipt'],
                'pending' => ["first_btn" =>'Reminder',"second_btn" =>'Mark as paid'],
                'overdue' => ["first_btn"=> 'Send Notice',"second_btn" => 'Mark as paid'],
        ];
        return $actionBtn[$status];
    }
 
    



    public function update($payload)
    {
        return $this->repo->update($payload);
    }

    public function view($payload)
    {
        return $this->repo->show($payload);
    }

    public function delete($payload)
    {
        return $this->repo->delete($payload);
    }

    public function summaryForStudent($studentId)
    {
        return $this->repo->summaryForStudent($studentId);
    }

    public function markFeePaid($feeId, $amount)
    {
        $studentFeeData =  $this->repo->markFeePaid($feeId, $amount);
        dd($studentFeeData);
    }

    public function getFeeType($dataType){
        
        $types = $feeTypeRep->index($dataType);
        dd($types);
    }
}
