<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeStoreRequest;
use App\Http\Requests\FeeUpdateRequest;
use App\Services\FeeService;
use App\Services\FeeTypeService;
use App\Services\ApiGatewayService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    protected $feeService;
    protected $apiGateway;
    protected $feeTypeService;

    public function __construct(FeeService $feeService, ApiGatewayService $apiGateway,FeeTypeService $feeType)
    {
        $this->feeService  = $feeService;
        $this->apiGateway  = $apiGateway;
        $this->feeTypeService  = $feeType;
    }

    public function index(Request $request)
    {
        $filter = $this->apiGateway->prepareDataPass($request);

        return response()->json([
            'status' => true,
            'data'   => $this->feeService->index($filter)
        ]);
    }

    public function store(FeeStoreRequest $request)
    {
        $feeStoreDbData = $this->feeService->store($request);
        if(!$feeStoreDbData['status']){
            return $this->apiGateway::error($feeStoreDbData['message'],[]);
        }
        return $this->apiGateway::success($feeStoreDbData['message'],$feeStoreDbData['data']);
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data' => $this->feeService->view(['fee_id' => $id])
        ]);
    }

    public function update(FeeUpdateRequest $request, $id)
    {
        $payload = $this->apiGateway->prepareDataPass($request);
        $payload['fee_id'] = $id;

        return response()->json([
            'status' => true,
            'message' => 'Fee updated successfully',
            'data' => $this->feeService->update($payload),
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'status' => true,
            'message' => $this->feeService->delete(['fee_id' => $id]),
        ]);
    }

    public function getFeeInvoices(Request $request){
        $dataPass = $this->apiGateway->prepareDataPass($request);
        $dataPass['feeType'] = $request->feeType ??  null;
        $feeData =  $this->feeService->getFeeInvoices($dataPass);
        return $this->apiGateway::success('Success',$feeData);

    }

    public function getFeeTypes(Request $request){
        $dataPass = $this->apiGateway->prepareDataPass($request);
        // $eeTypeService = new FeeTypeService;
        $feeTypeData = $this->feeTypeService->getFeeType($dataPass);
        return $this->apiGateway::success('Success',$feeTypeData);

    }

    public function sessionMonthWithYears(){
        return $this->apiGateway::success('Success',sessionMonthWithYears());
    }
}
