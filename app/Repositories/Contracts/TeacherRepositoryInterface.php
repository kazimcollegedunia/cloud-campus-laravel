<?php

namespace App\Repositories\Contracts;

interface TeacherRepositoryInterface
{
    public function store(array $request);
    public function teacherSubject(array $subjects);
    public function all(array $dataPass);
    public function statusUpdate(array $data);
    // public function create(array $data);
    // public function update($id, array $data);
    // public function delete($id);
    // public function search(?string $term = null, int $perPage = 10);
}

