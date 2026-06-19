@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Cases</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Cases</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"> Add New Case</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('case.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" name="client_name" id="client_name"
                                class="form-control @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name') }}" placeholder="Enter client name" required>

                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="open_project" class="form-label">Open Project?</label>
                                    <select name="open_project" id="open_project"
                                        class="form-select @error('open_project') is-invalid @enderror" required>
                                        <option value="">Select option</option>
                                        <option value="1" @selected(old('open_project') === '1')>Yes</option>
                                        <option value="0" @selected(old('open_project') === '0')>No</option>
                                    </select>

                                    @error('open_project')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="urgency" class="form-label">Urgency</label>
                                    <select name="urgency" id="urgency" class="form-select @error('urgency') is-invalid @enderror"
                                        required>
                                        <option value="">Select option</option>
                                        <option value="1" @selected(old('urgency') === '1')>Yes</option>
                                        <option value="0" @selected(old('urgency') === '0')>No</option>
                                    </select>

                                    @error('urgency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="project_type_id" class="form-label">Project Type</label>
                            <select name="project_type_id" id="project_type_id"
                                class="form-select @error('project_type_id') is-invalid @enderror" required>
                                <option value="">Select project type</option>
                                @foreach ($projectTypes as $projectType)
                                    <option value="{{ $projectType->id }}" @selected((int) old('project_type_id') === $projectType->id)>
                                        {{ $projectType->project_type_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('project_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter description" required>{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_id" class="form-label">Status</label>
                            <select name="status_id" id="status_id"
                                class="form-select @error('status_id') is-invalid @enderror" required>
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" @selected((int) old('status_id') === $status->id)>
                                        {{ $status->status_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <select name="assigned_to" id="assigned_to"
                                class="form-select @error('assigned_to') is-invalid @enderror" required>
                                <option value="">Select user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected((int) old('assigned_to') === $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Case</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Case List</div>

                <div class="card-body table-responsive">
                    @if (session('remark_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('remark_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <table class="table table-bordered" id="caseListTable">
                        <thead>
                            <tr class="text-center">
                                <th>Sl. No.</th>
                                <th>Client Name</th>
                                <th>Open Project?</th>
                                <th>Project Type</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Urgency</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cases as $case)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="text-wrap" style="max-width: 150px;">{{ $case->client_name }}</td>
                                    <td class="text-center">{{ $case->open_project ? 'Yes' : 'No' }}</td>
                                    <td class="text-wrap" style="max-width: 150px;">{{ $case->projectType?->project_type_name ?? 'N/A' }}</td>
                                    <td class="text-wrap" style="max-width: 150px;">{{ $case->status?->status_name ?? 'N/A' }}</td>
                                    <td>{{ $case->assignedTo?->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $case->urgency ? 'Yes' : 'No' }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('case.show', $case->id) }}">
                                                        <i class="bi bi-eye-fill me-2 text-primary"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('case.edit', $case->id) }}">
                                                        <i class="bi bi-pencil-fill me-2 text-warning"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addRemarkModal"
                                                        data-case-id="{{ $case->id }}"
                                                        data-client="{{ $case->client_name }}">
                                                        <i class="bi bi-chat-left-text-fill me-2 text-success"></i> Add Remark
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('case.destroy', $case->id) }}" method="POST"
                                                        class="delete-form m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash-fill me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="50" class="text-center">No cases found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Remark Modal --}}
    <div class="modal fade" id="addRemarkModal" tabindex="-1" aria-labelledby="addRemarkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRemarkModalLabel">Add Remark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="remarkForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-3">Case: <strong id="remarkClientName"></strong></p>
                        <div class="mb-0">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="5"
                                class="form-control" placeholder="Write your remark here..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Remark</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // caseListTable start
        let table = new DataTable('#caseListTable', {
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
        });

        table.on('draw.dt', function () {
            let pageInfo = table.page.info();

            table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                cell.innerHTML = pageInfo.start + i + 1;
            });
        });
        // caseListTable end
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This case will be deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if (session('deleted'))
                Swal.fire({
                    title: 'Deleted!',
                    text: @json(session('deleted')),
                    icon: 'success',
                    confirmButtonColor: '#0d6efd'
                });
            @endif

            // Set remark modal form action & client name dynamically
            document.getElementById('addRemarkModal').addEventListener('show.bs.modal', function (event) {
                var trigger = event.relatedTarget;
                var caseId = trigger.getAttribute('data-case-id');
                var client = trigger.getAttribute('data-client');
                document.getElementById('remarkForm').action = '/case/' + caseId + '/remark';
                document.getElementById('remarkClientName').textContent = client;
                document.getElementById('remarks').value = '';
            });
        });
    </script>
@endsection
