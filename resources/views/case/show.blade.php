@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Cases</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('case.index') }}">Cases</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- Case Details --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Case Details</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('case.edit', $case->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-fill me-1"></i> Edit
                        </a>
                        <a href="{{ route('case.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th class="bg-light w-25">Client Name</th>
                                <td>{{ $case->client_name }}</td>
                                <th class="bg-light w-25">Open Project</th>
                                <td>
                                    @if($case->open_project)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Project Type</th>
                                <td>{{ $case->projectType->project_type_name ?? '-' }}</td>
                                <th class="bg-light">Status</th>
                                <td>{{ $case->status->status_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Assigned To</th>
                                <td>{{ $case->assignedTo->name ?? '-' }}</td>
                                <th class="bg-light">Urgency</th>
                                <td>
                                    @if($case->urgency)
                                        <span class="badge bg-danger">Urgent</span>
                                    @else
                                        <span class="badge bg-secondary">Normal</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Added By</th>
                                <td>{{ $case->addedBy->name ?? '-' }}</td>
                                <th class="bg-light">Created At</th>
                                <td>{{ $case->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Description</th>
                                <td colspan="3">{{ $case->description }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Case Timeline --}}
            <div class="card">
                <div class="card-header">Case Timeline</div>
                <div class="card-body">
                    <ul class="list-unstyled timeline mb-0">
                        <li class="timeline-item">
                            <div class="timeline-icon bg-success text-white">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-semibold">Case Created</p>
                                <small class="text-muted">
                                    By <strong>{{ $case->addedBy->name ?? 'Unknown' }}</strong>
                                    &mdash; {{ $case->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        </li>
                        @if($case->updated_at->ne($case->created_at))
                        <li class="timeline-item">
                            <div class="timeline-icon bg-warning text-white">
                                <i class="bi bi-pencil-fill"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-semibold">Case Last Updated</p>
                                <small class="text-muted">
                                    {{ $case->updated_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<style>
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-icon {
        position: absolute;
        left: -42px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .timeline-content {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px 14px;
    }
</style>
@endsection
