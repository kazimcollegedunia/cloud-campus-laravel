<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Services\ApiGatewayService;
use App\Services\ClassService;
use App\Http\Requests\ClassRequest;

class ClassController extends Controller
{

    public $classService;
    public $apiGateway;
    public function __construct(ClassService $classService,ApiGatewayService $apiGateway){
        $this->classService = $classService;
        $this->apiGateway = $apiGateway;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataPass = $this->apiGateway->prepareDataPass($request);
        $classDbData = $this->classService->index($dataPass);
        // dd($classDbData);
        if($classDbData['status']){
            return $this->apiGateway::success($classDbData['message'],$classDbData['data']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRequest $request)
    {
        $storeDbData = $this->classService->store($request);
        if($storeDbData['status']){
            return $this->apiGateway::error($storeDbData['message'],$storeDbData['status']);
        }
        return $this->apiGateway::success($storeDbData['message'],$storeDbData['data']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd(23456);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function autoCreateClasses(Request $request){
        $storeDbData = $this->classService->autoCreateClasses($request);
        if($storeDbData['status']){
            return $this->apiGateway::error($storeDbData['message'],$storeDbData['status']);
        }
        return $this->apiGateway::success($storeDbData['message'],$storeDbData['data']);
    }

    public function getClassesWithSections(){
        $tenantId = auth()->user()->tenant_id;
        $classSectionDbData = $this->classService->getClassesWithSections($tenantId);
        return $this->apiGateway::success("success",$classSectionDbData['data']);
    }
      
}













