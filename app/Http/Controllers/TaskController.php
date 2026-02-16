<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Task::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:függőben,folyamatban,befejezve',
        ]);

        $task = Task::create($validated);
        return response()->json($task,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:függőben,folyamatban,befejezve',
        ]);

        $task -> update($validated);
        return response()->json($task,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(['message' => 'Task törölve'],200);
    }
}
