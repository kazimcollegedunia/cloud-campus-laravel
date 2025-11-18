<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::with('department')->get();

        return response()->json([
            'status' => true,
            'message' => 'Employees retrieved successfully',
            'data' => $employees,
        ], 200);
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $employee = Employee::create($validator->validated());

            return response()->json([
                'status' => true,
                'message' => 'Employee created successfully',
                'data' => $employee,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $employee = Employee::with('department')->find($id);

        if (! $employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Employee retrieved successfully',
            'data' => $employee,
        ], 200);
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, int $id)
    {
        try {
            $employee = Employee::find($id);

            if (! $employee) {
                return response()->json([
                    'status' => false,
                    'message' => 'Employee not found',
                ], 404);
            }

            // Use validator for manual error handling
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email,'.$id,
                'department_id' => 'required|exists:departments,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update employee
            $employee->update($validator->validated());

            return response()->json([
                'status' => true,
                'message' => 'Employee updated successfully',
                'data' => $employee,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified employee.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (! $employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found',
            ], 404);
        }

        try {
            $employee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Employee deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search employees by name or email.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $employees = Employee::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->with('department')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Search results',
            'data' => $employees,
        ], 200);
    }
}
