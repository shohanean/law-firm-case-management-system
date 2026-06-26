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
        if($request->get('sort') == 'za'){
            $cases = LegalCase::with(['projectType', 'status', 'assignedTo'])->orderBy('client_name', 'desc')->get();
        }else{
            $cases = LegalCase::with(['projectType', 'status', 'assignedTo'])->orderBy('client_name')->get();
        }
        $projectTypes = ProjectType::all();
        $statuses = Status::all();
        $users = User::all();
        return view('dashboard', compact('cases', 'projectTypes', 'statuses', 'users'));
    }
    public function yourAssignments()
    {
        $cases = LegalCase::with(['projectType', 'status', 'assignedTo'])->orderBy('client_name')->where('assigned_to', auth()->id())->get();
        $statuses = Status::all();
        return view('yourassignments', compact('cases', 'statuses'));
    }
}
