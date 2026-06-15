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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Case</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('case.update', $case->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" name="client_name" id="client_name"
                                class="form-control @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name', $case->client_name) }}" placeholder="Enter client name"
                                required>

                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="open_project" class="form-label">Open Project?</label>
                            <select name="open_project" id="open_project"
                                class="form-select @error('open_project') is-invalid @enderror" required>
                                <option value="1" @selected((string) old('open_project', (int) $case->open_project) === '1')>Yes</option>
                                <option value="0" @selected((string) old('open_project', (int) $case->open_project) === '0')>No</option>
                            </select>

                            @error('open_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="project_type_id" class="form-label">Project Type</label>
                            <select name="project_type_id" id="project_type_id"
                                class="form-select @error('project_type_id') is-invalid @enderror" required>
                                @foreach ($projectTypes as $projectType)
                                    <option value="{{ $projectType->id }}" @selected((int) old('project_type_id', $case->project_type_id) === $projectType->id)>
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
                            <textarea name="description" id="description" rows="5"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter description" required>{{ old('description', $case->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_id" class="form-label">Status</label>
                            <select name="status_id" id="status_id"
                                class="form-select @error('status_id') is-invalid @enderror" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" @selected((int) old('status_id', $case->status_id) === $status->id)>
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
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected((int) old('assigned_to', $case->assigned_to) === $user->id)>
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
                                <option value="1" @selected((string) old('urgency', (int) $case->urgency) === '1')>Yes</option>
                                <option value="0" @selected((string) old('urgency', (int) $case->urgency) === '0')>No</option>
                            </select>

                            @error('urgency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Case</button>
                            <a href="{{ route('case.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
