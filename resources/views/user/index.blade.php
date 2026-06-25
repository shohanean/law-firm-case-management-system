@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add New User</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Enter email address" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Confirm password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User List</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Sl. No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                                @if (auth()->id() == 1)
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="{{ $user->trashed() ? 'table-danger' : '' }}">
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold {{ $user->trashed() ? 'bg-secondary' : 'bg-primary' }}"
                                                style="width:32px;height:32px;font-size:13px;flex-shrink:0;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="{{ $user->trashed() ? 'text-decoration-line-through text-muted' : '' }}">
                                                {{ $user->name }}
                                            </span>
                                            @if ($user->id === auth()->id())
                                                <span class="badge bg-primary ms-1">You</span>
                                            @endif
                                            @if ($user->trashed())
                                                <span class="badge bg-danger ms-1">Deleted</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="{{ $user->trashed() ? 'text-muted text-decoration-line-through' : '' }}">
                                        {{ $user->email }}
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    @if (auth()->id() == 1)
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ($user->trashed())
                                                        <li>
                                                            <form action="{{ route('user.restore', $user->id) }}" method="POST"
                                                                class="restore-form m-0">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item text-success"
                                                                    data-name="{{ $user->name }}">
                                                                    <i class="bi bi-arrow-counterclockwise me-2"></i> Restore
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('user.edit', $user->id) }}">
                                                                <i class="bi bi-pencil-fill me-2 text-warning"></i> Edit
                                                            </a>
                                                        </li>
                                                        @if ($user->id !== auth()->id())
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                                    class="delete-form m-0">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger"
                                                                        data-name="{{ $user->name }}">
                                                                        <i class="bi bi-trash-fill me-2"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
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

            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    var name = form.querySelector('button[type="submit"]').dataset.name;
                    Swal.fire({
                        title: 'Delete user?',
                        html: '<strong>' + name + '</strong> will be soft-deleted and can be restored later.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel'
                    }).then(function (result) {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Restore confirmation
            document.querySelectorAll('.restore-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    var name = form.querySelector('button[type="submit"]').dataset.name;
                    Swal.fire({
                        title: 'Restore user?',
                        html: '<strong>' + name + '</strong> will be restored and can log in again.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, restore!',
                        cancelButtonText: 'Cancel'
                    }).then(function (result) {
                        if (result.isConfirmed) form.submit();
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

            @if (session('restored'))
                Swal.fire({
                    title: 'Restored!',
                    text: @json(session('restored')),
                    icon: 'success',
                    confirmButtonColor: '#198754'
                });
            @endif
        });
    </script>
@endsection
