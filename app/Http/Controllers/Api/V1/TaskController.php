<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::where('user_id',auth()->id());
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->get();
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
    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Task::where('user_id',auth()->id())->findOrFail($id);
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
        $task = Task::where('user_id',auth()->id())->findOrFail($id);
        $task->update($request->all());
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('user_id',auth()->id())->findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
