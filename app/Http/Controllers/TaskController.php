<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Business;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['business', 'project', 'assignee'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return view('tasks.index', ['items' => $query->paginate(15)->withQueryString()]);
    }

    public function create()
    {
        return view('tasks.form', [
            'item' => new Task(['status' => 'Pending', 'priority' => 'Medium']),
            'businesses' => Business::orderBy('business_name')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.form', [
            'item' => $task,
            'businesses' => Business::orderBy('business_name')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        if (($validated['status'] ?? null) === 'Completed' && empty($validated['completed_at'])) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
