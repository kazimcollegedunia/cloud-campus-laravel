<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepositoryInterface;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    protected $model;

    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }

    public function all()
    {
        return $this->model->with('user')->get();
    }

    // public function find($id)
    // {
    //     return $this->model->with(['department', 'contactNumbers', 'addresses'])->find($id);
    // }

    // public function create(array $data)
    // {
    //     return $this->model->create($data);
    // }

    // public function update($id, array $data)
    // {
    //     $emp = $this->model->findOrFail($id);
    //     $emp->update($data);
    //     return $emp;
    // }

    // public function delete($id)
    // {
    //     $emp = $this->model->findOrFail($id);
    //     return $emp->delete();
    // }

    //  public function search(?string $term = null, int $perPage = 10)
    // {
    //     $query = $this->model->with(['department', 'contactNumbers', 'addresses']);

    //     if ($term) {
    //         $query->where(function ($q) use ($term) {
    //             $q->where('name', 'LIKE', "%{$term}%")
    //               ->orWhere('email', 'LIKE', "%{$term}%")
    //               ->orWhereHas('department', function ($d) use ($term) {
    //                   $d->where('name', 'LIKE', "%{$term}%");
    //               })
    //               ->orWhereHas('contactNumbers', function ($c) use ($term) {
    //                   $c->where('number', 'LIKE', "%{$term}%");
    //               })
    //               ->orWhereHas('addresses', function ($a) use ($term) {
    //                   $a->where('address_line', 'LIKE', "%{$term}%")
    //                     ->orWhere('city', 'LIKE', "%{$term}%")
    //                     ->orWhere('state', 'LIKE', "%{$term}%")
    //                     ->orWhere('country', 'LIKE', "%{$term}%")
    //                     ->orWhere('pincode', 'LIKE', "%{$term}%");
    //               });
    //         });
    //     }

    //     return $query->paginate($perPage);
    // }
}
