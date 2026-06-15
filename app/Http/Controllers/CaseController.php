<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Remark;
use App\Models\ProjectType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cases = LegalCase::with(['projectType', 'status', 'assignedTo', 'addedBy'])->latest()->get();
        $projectTypes = ProjectType::orderBy('project_type_name')->get();
        $statuses = Status::orderBy('status_name')->get();
        $users = User::orderBy('name')->get();

        return view('case.index', compact('cases', 'projectTypes', 'statuses', 'users'));
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
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'open_project' => ['required', 'boolean'],
            'project_type_id' => ['required', 'exists:project_types,id'],
            'description' => ['required', 'string'],
            'status_id' => ['required', 'exists:statuses,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'urgency' => ['required', 'boolean'],
        ]);

        LegalCase::create($validated + [
            'added_by' => auth()->id(),
        ]);

        return redirect()
            ->route('case.index')
            ->with('success', 'Case added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LegalCase $case)
    {
        $case->load(['projectType', 'status', 'assignedTo', 'addedBy']);

        $remarks = $case->remarks()->with('addedBy')->latest()->paginate(5);

        return view('case.show', compact('case', 'remarks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LegalCase $case)
    {
        $projectTypes = ProjectType::orderBy('project_type_name')->get();
        $statuses = Status::orderBy('status_name')->get();
        $users = User::orderBy('name')->get();

        return view('case.edit', compact('case', 'projectTypes', 'statuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalCase $case)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'open_project' => ['required', 'boolean'],
            'project_type_id' => ['required', 'exists:project_types,id'],
            'description' => ['required', 'string'],
            'status_id' => ['required', 'exists:statuses,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'urgency' => ['required', 'boolean'],
        ]);

        $case->update($validated);

        return back()->with('success', 'Case updated successfully.');
    }

    public function remarkStore(Request $request, LegalCase $case)
    {
        $request->validate([
            'remarks' => ['required', 'string'],
        ]);

        Remark::create([
            'legal_case_id' => $case->id,
            'remarks'       => $request->remarks,
            'added_by'      => auth()->id(),
        ]);

        return back()->with('remark_success', 'Remark added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalCase $case)
    {
        $case->delete();

        return redirect()
            ->route('case.index')
            ->with('deleted', 'Case deleted successfully.');
    }
}
