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

                        <button type="submit" class="btn btn-primary">Add Case</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Case List</div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
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
                            @foreach ($cases as $case)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $case->client_name }}</td>
                                    <td>{{ $case->open_project ? 'Yes' : 'No' }}</td>
                                    <td>{{ $case->projectType?->project_type_name ?? 'N/A' }}</td>
                                    <td>{{ $case->status?->status_name ?? 'N/A' }}</td>
                                    <td>{{ $case->assignedTo?->name ?? 'N/A' }}</td>
                                    <td>{{ $case->urgency ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Case actions">
                                            <a href="{{ route('case.edit', $case->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('case.destroy', $case->id) }}" method="POST"
                                                class="delete-form m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger rounded-start-0">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
        });
    </script>
@endsection
