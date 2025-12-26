<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FeeRepositoryInterface;
use App\Models\Fee;
use Illuminate\Support\Facades\DB;

class FeeRepository implements FeeRepositoryInterface
{

    protected $model;

    public function __construct(Fee $fee)
    {
        $this->model = $fee;
    }

    public function index(array $filters)
    {
        return Fee::where('tenant_id', $filters['tenant_id'])
            ->with('student.user','feeType')
            ->when(isset($filters['student_id']), fn($q) => $q->where('student_id', $filters['student_id']))
            // ->when(isset($filters['status']), fn($q) => $q->where('student.status', $filters['status']))
            ->orderBy('id', 'desc')
            ->paginate(20);
            // return $abc;
    }

    public function store(array $data)
    {
        return Fee::create([
            'tenant_id'   => $data['tenant_id'],
            'student_id'  => $data['student_id'],
            'fee_type_id' => $data['fee_type_id'],
            'amount_inr'  => $data['amount_inr'],
            'due_date'    => $data['due_date'] ?? null,
            'paid_amount'    => $data['paid_amount'] ?? null,
            'paid_at'    => $data['paid_at'] ?? null,
            'remarks'     => $data['remarks'] ?? null,
            'receipt_no'        => $data['receipt_no'] ?? null,
            'meta'        => $data['meta'] ?? null,
            'status' => $data['status'] ?? "pending",
            'month' => $data['month'] ?? null
        ]);
    }
    

    public function update(array $data)
    {
        $fee = Fee::findOrFail($data['fee_id']);
        $fee->update($data);
        return $fee;
    }

    public function show(array $data)
    {
        return Fee::with('payments', 'student', 'feeType')
            ->where('id', $data['fee_id'])
            ->firstOrFail();
    }

    public function delete(array $data)
    {
        $fee = Fee::findOrFail($data['fee_id']);
        $fee->delete();

        return "Fee deleted successfully";
    }

    public function summaryForStudent($studentId)
    {
        return [
            'total_fees'   => Fee::where('student_id', $studentId)->sum('amount_inr'),
            'total_paid'   => Fee::where('student_id', $studentId)->sum('paid_amount'),
            'total_due'    => Fee::where('student_id', $studentId)->where('status', '!=', 'paid')->sum('amount_inr'),
        ];
    }

    public function markFeePaid($feeId, $amount)
    {
        $fee = Fee::findOrFail($feeId);

        $fee->paid_amount += $amount;
        $fee->status = ($fee->paid_amount >= $fee->amount_inr) ? 'paid' : 'partial';
        $fee->paid_at = now();
        $fee->save();

        return $fee;
    }
    public function isAdmissionNoExists(string $randumNumber){
        return $this->model->where('receipt_no', $randumNumber)->exists();
    }
}
