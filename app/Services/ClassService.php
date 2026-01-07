<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Services\ApiGatewayService;
use Exception;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;

class ClassService
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
        $storeDbData = SchoolClass::where('tenant_id',auth()->user()->tenant_id)->get();
        if($storeDbData){
            return [
                "status"=> true,
                "message"=> "Class fetch successfully",
                "data"=> $storeDbData,
            ];
        }
        
   }

   public function store($request){
        try{
            $storeDbData = SchoolClass::create($request->all());
            if(!$storeDbData){
            throw new \Exception('Class creation failed');
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
                    'Class create action',
                    'Class create action ',
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

   public function autoCreateClasses($request){
        $tenantId = $request->tenant_id;
        $class    = $request->class;
        $section  = $request->section ?? 'A';

        if (!$tenantId) {
            return response()->json([
                'status'  => false,
                'message' => 'tenant_id is required'
            ], 422);
        }

        $created = [];

        // CASE 1: class provided → create single
        if ($class) {
            $exists = SchoolClass::where([
                'tenant_id' => $tenantId,
                'class'     => $class,
                'section'   => $section,
            ])->exists();

            if (!$exists) {
                $created[] = SchoolClass::create([
                    'tenant_id' => $tenantId,
                    'class'     => $class,
                    'section'   => $section,
                    'status'    => 'active',
                ]);
            }
        }
        // CASE 2: no class provided → auto create 1–12
        else {
            for ($i = 1; $i <= 12; $i++) {
                $exists = SchoolClass::where([
                    'tenant_id' => $tenantId,
                    'class'     => $i,
                    'section'   => 'A',
                ])->exists();

                if (!$exists) {
                    $created[] = SchoolClass::create([
                        'tenant_id' => $tenantId,
                        'class'     => $i,
                        'section'   => 'A',
                        'status'    => 'active',
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Classes created successfully',
            'data'    => $created
        ]);

   }

    public function getClassesWithSections(int $tenantId)
    {
        $records = DB::table('school_classes')
            ->select('class', 'section')
            ->where('tenant_id', $tenantId)
            ->orderBy('class')
            ->orderBy('section')
            ->get()
            ->groupBy('class');

        $result = $records->map(function ($items, $class) {
            return [
                'class'    => $class,
                'sections' => $items->pluck('section')->values(),
            ];
        })->values();

        return [
            "status"=>false,
            "data"=>$result
            ];
        }

}

