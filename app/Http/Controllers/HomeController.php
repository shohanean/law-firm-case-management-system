<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalCase;
use App\Models\Status;
use App\Models\User;
use App\Models\ProjectType;

class HomeController extends Controller
{
    public function dashboard()
    {
        $cases = LegalCase::with(['projectType', 'status', 'assignedTo'])->latest()->get();
        $projectTypes = ProjectType::all();
        $statuses = Status::all();
        $users = User::all();
        return view('dashboard', compact('cases', 'projectTypes', 'statuses', 'users'));
    }

}
