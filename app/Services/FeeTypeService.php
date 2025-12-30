<?php

namespace App\Services;

use App\Repositories\Contracts\FeeRepositoryInterface;
use App\Repositories\Contracts\FeeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Exception;
use Carbon\Carbon;

class FeeTypeService
{
    protected $repo;
    protected $studentRepo;

    public function __construct(FeeTypeRepositoryInterface $rep,StudentRepositoryInterface $studentRepo)
    {
        $this->repo = $rep;
    }

    public function getFeeType($dataPass){

        return $types = $this->repo->index($dataPass);
    }
}
