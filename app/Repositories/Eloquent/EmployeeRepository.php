<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    protected $model;

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function all()
    {
        return $this->model->with(['department', 'contactNumbers', 'addresses'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['department', 'contactNumbers', 'addresses'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $emp = $this->model->findOrFail($id);
        $emp->update($data);
        return $emp;
    }

    public function delete($id)
    {
        $emp = $this->model->findOrFail($id);
        return $emp->delete();
    }

    public function search(array $dataPass)
    {
        $query = $dataPass['query'] ?? [];
        dd($query);
        return $this->model->with('department')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();
    }
}
