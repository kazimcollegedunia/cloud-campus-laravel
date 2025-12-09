<?php

namespace App\Services;

use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StudentService
{
    protected $repo;

    public function __construct(StudentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }


    // ============ LIST / FILTER ============
    public function getStudents($request)
    {
        return $this->repo->all($request);
    }


    // ============ CLASS LIST ============
    public function getClasses()
    {
        return $this->repo->getClasses();
    }

    // ============ SECTION LIST ============
    public function getSections()
    {
        return $this->repo->getSections();
    }

    // ============ USERS who are STUDENTS ============
    public function getStudentUsers()
    {
        return $this->repo->getStudentUsers();
    }


    // ============ CREATE STUDENT ============
    public function createStudent(array $data)
    {
        DB::beginTransaction();

        try {
            $tenant_id = 1;  
            $admission_no = rand(100000, 999999);

            // Create User
            $user = User::create([
                'tenant_id' => $tenant_id,
                'name'      => $data['name'],
                'email'     => $data['parent_email'] ?? null,
                'phone'     => $data['phone'] ?? null,
                'role'      => 'student',
                'password'  => bcrypt('password'),
            ]);

            // Create Student
            $student = $this->repo->create([
                'user_id'       => $user->id,
                'admission_no'  => $admission_no,
                'class_id'      => $data['class_id'],
                'section'       => $data['section'],
                'dob'           => $data['dob'],
                'gender'        => $data['gender'],
                'parent_name'   => $data['parent_name'],
                'parent_email'  => $data['parent_email'],
                'parent_phone'  => $data['parent_phone'],
                'address'       => $data['address'],
                'status'        => 'active',
            ]);

            DB::commit();
            return [
                'user'    => $user,
                'student' => $student
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    // ============ UPDATE ============
    public function updateStudent($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    // ============ DELETE ============
    public function deleteStudent($id)
    {
        return $this->repo->delete($id);
    }
}
