<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignedTo', 'assignedBy'])->latest()->paginate(10);
        $users = User::whereNull('deleted_at')->orderBy('name')->get();
        return view('tasks.index', compact('tasks', 'users'));
    }

    public function myTasks()
    {
        $tasks = Task::with(['assignedBy'])
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();
        return view('tasks.my', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['required', 'date'],
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        $validated['assigned_by'] = auth()->id();
        $validated['status']      = 'pending';

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task assigned successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
