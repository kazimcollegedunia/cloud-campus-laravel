<?php

namespace App\Repositories\Contracts;

interface FeeTypeRepositoryInterface
{
    public function index(array $filters);
    public function store(array $data);
}
