<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectType;

class HomeController extends Controller
{
    public function dashboard()
    {
        $projectTypes = ProjectType::all();
        return view('dashboard', compact('projectTypes'));
    }
}
