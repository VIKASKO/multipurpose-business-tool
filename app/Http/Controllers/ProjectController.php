<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $items = Project::with(['business', 'customer'])->latest()->paginate(15);

        return view('projects.index', compact('items'));
    }

    public function create()
    {
        return view('projects.form', [
            'item' => new Project(['status' => 'Planning']),
            'businesses' => Business::orderBy('business_name')->get(),
            'customers' => Customer::orderBy('customer_name')->get(),
        ]);
    }

    public function store(ProjectRequest $request)
    {
        Project::create($request->validated());

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('projects.form', [
            'item' => $project,
            'businesses' => Business::orderBy('business_name')->get(),
            'customers' => Customer::orderBy('customer_name')->get(),
        ]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
