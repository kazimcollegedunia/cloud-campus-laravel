<?php

namespace App\Services;

use App\Repositories\Contracts\FeeRepositoryInterface;
use App\Repositories\Contracts\FeeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Exception;
use Carbon\Carbon;
use App\DTOs\ServiceResult;

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

    //Admin part Fee type 

    public function feeTypeLists($filters){
       $dbData = $this->repo->list($filters);
        if (empty($dbData)) {
            return ServiceResult::error(
                    'No fee types found',
                    [],
                    404
                );
            }

            return ServiceResult::success(
                'Fee types fetched successfully',
                $dbData
            );
    }

    public function feeTypeStore(){
    }

    public function feeTypeUpdate(){
    }

    public function feeTypeStatusUpdate(){

    }
}
