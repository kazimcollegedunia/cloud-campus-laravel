<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $employees = $this->service->list();
        return EmployeeResource::collection($employees);
    }

    public function show($id)
    {
        try {
            $employee = $this->service->get($id);
            return new EmployeeResource($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Employee not found'], 404);
        }
    }

    public function store(StoreEmployeeRequest $request)
    {   
            $employee = $this->service->create($request->validated());
            return (new EmployeeResource($employee))->response()->setStatusCode(201);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $employee = $this->service->update($id, $request->validated());
            return new EmployeeResource($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Employee not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['status' => true, 'message' => 'Employee deleted'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Employee not found'], 404);
        }
    }

   public function search(Request $request)
    {
        $term = $request->query('term');
        $perPage = 10;

        $employees = $this->service->search($term, $perPage);

        return response()->json([
            'status' => true,
            'message' => $term ? 'Filtered employee list' : 'Employee list',

            'pagination' => [
                'current_page' => $employees->currentPage(),
                'total_pages'  => $employees->lastPage(),
                'per_page'     => $employees->perPage(),
                'total_records'=> $employees->total(),
            ],

            'data' => EmployeeResource::collection($employees),
        ]);
    }



}
