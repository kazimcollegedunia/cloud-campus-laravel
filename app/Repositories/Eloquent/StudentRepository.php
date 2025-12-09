<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $student)
    {
        $this->model = $student;
    }

    public function all($request)
    {
        dd($request->all());
        // return $this->model->with(['department', 'contactNumbers', 'addresses'])->get();


        $student = $this->model->newQuery();
        $student->join('users', 'students.user_id', '=', 'users.id')->select('students.*', 'users.name as student_name');
        // dd($request->filled('class'));
        // Filter by class
        if ($request->filled('class')) {
            $student->where('class', $request->class);
        }

        // Filter by section
        if ($request->filled('section')) {
            $student->where('section', $request->section);
        }

        // Search by name, class, roll_no
        if ($request->filled('search')) {
            $search = $request->search;

            $student->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                ->orWhere('class_id', 'LIKE', "%{$search}%");
                // ->orWhere('roll_no', 'LIKE', "%{$search}%");
            });
        }

        $sutdentData = $student->orderBy('id', 'DESC')->get();
        $sutdentCount = $student->count();
        $data = [ "studentData" => $sutdentData, "studentCount" => $sutdentCount];

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
