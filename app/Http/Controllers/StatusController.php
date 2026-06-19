<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::with('addedBy')->latest()->get();
        return view('status.index', compact('statuses'));
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
            'status_name' => ['required', 'string', 'max:255', 'unique:statuses,status_name'],
        ]);

        Status::create([
            'status_name' => $request->status_name,
            'added_by' => auth()->id(),
        ]);

        return redirect()
            ->route('status.index')
            ->with('success', 'Status added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        $request->validate([
            'status_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('statuses', 'status_name')->ignore($status->id),
            ],
        ]);

        $status->update([
            'status_name' => $request->status_name,
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()
            ->route('status.index')
            ->with('deleted', 'Status deleted successfully.');
    }
}
