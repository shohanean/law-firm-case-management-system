@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Project Types</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Project Types</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" style=""> <a class="dropdown-item"
                        href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"> Add New Project Type</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('projecttype.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="project_type_name" class="form-label">Project Type Name</label>
                            <input type="text" name="project_type_name" id="project_type_name"
                                class="form-control @error('project_type_name') is-invalid @enderror"
                                value="{{ old('project_type_name') }}" placeholder="Enter project type name" required>

                            @error('project_type_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add Project Type</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Project Type List</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Project Type Name</th>
                                <th>Added By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projecttypes as $projecttype)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $projecttype->project_type_name }}</td>
                                    <td>{{ $projecttype->addedBy?->name ?? 'N/A' }}</td>
                                    <td>{{ $projecttype->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('projecttype.edit', $projecttype->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('projecttype.destroy', $projecttype->id) }}" method="POST"
                                            class="delete-form" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This project type will be deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
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
