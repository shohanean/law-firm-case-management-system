@extends('layouts.admin')

@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
        <div class="col">
        <div class="card radius-10 border-0 border-start border-pink border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Open Cases</p>
                <h4 class="mb-0 text-pink">{{ $cases->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-pink text-white">
                <i class="bi bi-folder-fill"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                <div class="">
                    <p class="mb-1">Total Project Types</p>
                    <h4 class="mb-0 text-tiffany">{{ $projectTypes->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-tiffany text-white">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-success border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Statuses</p>
                <h4 class="mb-0 text-success">{{ $statuses->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-success text-white">
                <i class="bi bi-check2-circle"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-orange border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Users</p>
                <h4 class="mb-0 text-orange">{{ $users->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-orange text-white">
                <i class="bi bi-person-plus-fill"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0">Open Cases</h6>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SL. No.</th>
                            <th>Client Name</th>
                            <th>Project Type</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Urgency</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cases as $case)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td>{{ $case->projectType->project_type_name ?? '-' }}</td>
                            <td>{{ $case->status->status_name ?? '-' }}</td>
                            <td>{{ $case->assignedTo->name ?? '-' }}</td>
                            <td>
                                @if($case->urgency)
                                    <span class="badge bg-danger">Urgent</span>
                                @else
                                    <span class="badge bg-secondary">Normal</span>
                                @endif
                            </td>
                            <td>{{ $case->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">No open cases found.</td></tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

@endsection
