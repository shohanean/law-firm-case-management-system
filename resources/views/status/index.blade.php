@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Statuses</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Statuses</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"> Add New Status</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('status.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status_name" class="form-label">Status Name</label>
                            <input type="text" name="status_name" id="status_name"
                                class="form-control @error('status_name') is-invalid @enderror"
                                value="{{ old('status_name') }}" placeholder="Enter status name" required>

                            @error('status_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Status List</div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Status Name</th>
                                <th>Added By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $status->status_name }}</td>
                                    <td>{{ $status->addedBy?->name ?? 'N/A' }}</td>
                                    <td>{{ $status->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Status actions">
                                            <a href="{{ route('status.edit', $status->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <form action="{{ route('status.destroy', $status->id) }}" method="POST"
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
                        text: 'This status will be deleted.',
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
