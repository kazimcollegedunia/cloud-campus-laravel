<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FeeTypeRepositoryInterface;
use App\Models\FeeTypes;
use Illuminate\Support\Facades\DB;

class FeeTypeRepository implements FeeTypeRepositoryInterface
{

    protected $model;

    public function __construct(FeeTypes $feeType)
    {
        $this->model = $feeType;
    }

    public function index(array $filters)
    {
       return $this->model
            ->where('tenant_id', $filters['tenant_id'])
            ->when(
                !empty($filters['class_id']),
                fn ($q) => $q->where(function ($q) use ($filters) {
                    $q->whereNull('class_id')
                    ->orWhere('class_id', $filters['class_id']);
                })
            )
            ->orderBy('id', 'desc')
            ->get();
    }

    public function store(array $data)
    {
        return Fee::create([
            'tenant_id'   => $data['tenant_id'],
            'student_id'  => $data['student_id'],
            'fee_type_id' => $data['fee_type_id'],
            'amount_inr'  => $data['amount_inr'],
            'due_date'    => $data['due_date'] ?? null,
            'remarks'     => $data['remarks'] ?? null,
            'meta'        => $data['meta'] ?? null,
        ]);
    }
}
