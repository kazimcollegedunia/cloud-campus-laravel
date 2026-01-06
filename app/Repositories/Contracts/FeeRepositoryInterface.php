<?php

namespace App\Repositories\Contracts;

interface FeeRepositoryInterface
{
     public function index(array $filters);
    public function store(array $data);
    public function update(array $data);
    public function show(array $data);
    public function delete(array $data);
    public function isAdmissionNoExists(string $randumNumber);
    public function isfeeExist(array $data);
    

    // Extra required functions
    public function summaryForStudent($studentId);
    public function markFeePaid($feeId, $amount);
}
