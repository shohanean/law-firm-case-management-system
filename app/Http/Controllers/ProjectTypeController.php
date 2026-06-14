<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projecttypes = ProjectType::with('addedBy')->latest()->get();
        return view('projecttype.index', compact('projecttypes'));
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
        $request->validate([
            'project_type_name' => ['required', 'string', 'max:255', 'unique:project_types,project_type_name'],
        ]);

        ProjectType::create([
            'project_type_name' => $request->project_type_name,
            'added_by' => auth()->id(),
        ]);

        return redirect()
            ->route('projecttype.index')
            ->with('success', 'Project type added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectType $projectType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectType $projecttype)
    {
        return view('projecttype.edit', compact('projecttype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectType $projecttype)
    {
        $request->validate([
            'project_type_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('project_types', 'project_type_name')->ignore($projecttype->id),
            ],
        ]);

        $projecttype->update([
            'project_type_name' => $request->project_type_name,
        ]);

        return back()->with('success', 'Project type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectType $projecttype)
    {
        $projecttype->delete();

        return redirect()
            ->route('projecttype.index')
            ->with('deleted', 'Project type deleted successfully.');
    }
}
