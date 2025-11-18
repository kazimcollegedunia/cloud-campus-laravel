<?php

namespace App\Services;

use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Models\ContactNumber;
use App\Models\Address;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeService
{
    protected $repo;

    public function __construct(EmployeeRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function get($id)
    {
        $employee = $this->repo->find($id);
        if (!$employee) throw new ModelNotFoundException("Employee not found");
        return $employee;
    }

    public function create(array $payload)
    {
        return DB::transaction(function () use ($payload) {
            $employeeData = collect($payload)->only(['name','email','department_id'])->toArray();
            $employee = $this->repo->create($employeeData);
            if(isset($payload['contact_numbers']) && is_array($payload['contact_numbers'])) {
                foreach ($payload['contact_numbers'] as $c) {
                    $c['employee_id'] = $employee->id;
                    ContactNumber::create($c);
                }
            }
            if(isset($payload['addresses']) && is_array($payload['addresses'])) {
                foreach ($payload['addresses'] as $a) {
                    $a['employee_id'] = $employee->id;
                    Address::create($a);
                }
            }

            return $this->repo->find($employee->id);
        });
    }

    public function update($id, array $payload)
    {
        return DB::transaction(function () use ($id, $payload) {
            $this->repo->update($id, collect($payload)->only(['name','email','department_id'])->toArray());

            $employee = $this->repo->find($id);
            $employee->contactNumbers()->delete();
            $employee->addresses()->delete();

            foreach ($payload['contact_numbers'] as $c) {
                $c['employee_id'] = $id;
                ContactNumber::create($c);
            }

            foreach ($payload['addresses'] as $a) {
                $a['employee_id'] = $id;
                Address::create($a);
            }

            return $this->repo->find($id);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->repo->delete($id);
        });
    }

    public function search($term = null, $perPage = 10)
    {
        $query = Employee::with(['department', 'contactNumbers', 'addresses']);

        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('email', 'LIKE', "%{$term}%")
                    ->orWhereHas('department', function ($d) use ($term) {
                        $d->where('name', 'LIKE', "%{$term}%");
                    })
                    ->orWhereHas('contactNumbers', function ($d) use ($term) {
                        $d->where('number', 'LIKE', "%{$term}%");
                    });
            });
        }

        return $query->paginate($perPage);
    }

}
