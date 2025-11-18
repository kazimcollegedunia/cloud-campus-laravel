<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json([
            'status' => true,
            'message' => 'Departments retrieved successfully',
            'data' => $departments
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|unique:departments,name|max:255',
            'description' => 'nullable|string',
        ]);

        if($request->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $request->errors()
            ], 422);
        }   

        try {
            $department = Department::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Department created successfully',
                'data' => $department
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create department',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Department retrieved successfully',
            'data' => $department
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        // Validation
        $validated = $request->validate([
            'name' => 'required|max:255|unique:departments,name,' . $id,
            'description' => 'nullable|string',
        ]);

        try {
            $department->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Department updated successfully',
                'data' => $department
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update department',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        try {
            $department->delete();

            return response()->json([
                'status' => true,
                'message' => 'Department deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete department',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
