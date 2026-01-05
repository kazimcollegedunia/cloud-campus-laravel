<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SectionService;
use App\Services\ApiGatewayService;
use App\Http\Requests\SectionRequest;

class SectionController extends Controller
{

    public $sectionService;
    public $apiGateway;
    public function __construct(SectionService $sectionService,ApiGatewayService $apiGateway){
        $this->sectionService = $sectionService;
        $this->apiGateway = $apiGateway;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storeDbData = $this->sectionService->index();
       
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
    public function store(SectionRequest $request)
    {
        $storeDbData = $this->sectionService->store($request);
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
        //
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
}
