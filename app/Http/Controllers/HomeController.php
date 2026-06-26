<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalCase;
use App\Models\Status;
use App\Models\User;
use App\Models\ProjectType;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = LegalCase::with(['projectType', 'status', 'assignedTo']);

        // Sort
        if ($request->get('sort') === 'za') {
            $query->orderBy('client_name', 'desc');
        } else {
            $query->orderBy('client_name');
        }

        // Filters
        if ($request->filled('open_project')) {
            $query->where('open_project', (bool) $request->get('open_project'));
        }
        if ($request->filled('project_type_id')) {
            $query->where('project_type_id', $request->get('project_type_id'));
        }
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }
        if ($request->filled('urgency')) {
            $query->where('urgency', (bool) $request->get('urgency'));
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->get('assigned_to'));
        }

        $cases        = $query->get();
        $projectTypes = ProjectType::all();
        $statuses     = Status::all();
        $users        = User::all();

        return view('dashboard', compact('cases', 'projectTypes', 'statuses', 'users'));
    }
    public function yourAssignments()
    {
        $cases = LegalCase::with(['projectType', 'status', 'assignedTo'])->orderBy('client_name')->where('assigned_to', auth()->id())->get();
        $statuses = Status::all();
        return view('yourassignments', compact('cases', 'statuses'));
    }
}
