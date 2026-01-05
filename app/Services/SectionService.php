<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Services\ApiGatewayService;
use Exception;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Throw_;

class SectionService
{
    protected $repo;
    protected $apiGateway;
    protected $userRepo;

    public function __construct(TeacherRepositoryInterface $repo,ApiGatewayService $apiGateway,UserRepositoryInterface $userRepo)
    {
        $this->repo = $repo;
        $this->apiGateway = $apiGateway;
        $this->userRepo = $userRepo;
    }

   public function index($dataPass){
    
   }

   public function store($request){
        try{
            $storeDbData = SchoolSection::create($request->all());
            if(!$storeDbData){
            throw new \Exception('Section creation failed');
            }
            if($storeDbData){
                return [
                    'status' => false,
                    'message' => "Store successfully",
                    'data' => $storeDbData
                ];
            }
        }catch(Exception $e){
            writeLog(
                    'Section create action',
                    'Section create action ',
                    $request->all(),
                    $e->getMessage(),
                    "fail",
                );

            return [
                        'status' => true,
                        'message' => $e->getMessage(),
                        'data' => []
                    ];
        }
   }

   public function show($dataPass){
    
   }

}
