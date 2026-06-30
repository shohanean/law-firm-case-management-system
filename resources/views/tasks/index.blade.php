@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Task Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Assign Task Form --}}
        <div class="col-12 col-xl-4 mb-4">
            <div class="card radius-10">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Assign New Task</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Task title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Task details (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Due Date <span class="text-danger">*</span></label>
                            <input type="date" name="due_date"
                                class="form-control @error('due_date') is-invalid @enderror"
                                value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Assign To <span class="text-danger">*</span></label>
                            <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror" required>
                                <option value="">— Select user —</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send-fill me-1"></i> Assign Task
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Task List --}}
        <div class="col-12 col-xl-8">
            <div class="card radius-10">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">All Tasks</h6>
                    <span class="badge bg-secondary">{{ $tasks->total() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-start">Title</th>
                                    <th>Assigned To</th>
                                    <th>Assigned By</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr class="align-middle">
                                        <td class="text-center text-muted">{{ $tasks->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="fw-medium">{{ $task->title }}</div>
                                            @if ($task->description)
                                                <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10">
                                                {{ $task->assignedTo->name ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="text-center text-muted small">{{ $task->assignedBy->name ?? '—' }}</td>
                                        <td class="text-center">
                                            @php $overdue = $task->status !== 'completed' && $task->due_date->isPast(); @endphp
                                            <span class="{{ $overdue ? 'text-danger fw-medium' : '' }}">
                                                {{ $task->due_date->format('d M Y') }}
                                            </span>
                                            @if ($overdue)
                                                <br><small class="text-danger">Overdue</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($task->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($task->status === 'in_progress')
                                                <span class="badge bg-info text-dark">In Progress</span>
                                            @else
                                                <span class="badge bg-success">Completed</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                class="task-delete-form m-0 d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No tasks assigned yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($tasks->hasPages())
                        <div class="py-3 px-3">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.task-delete-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete this task?',
                    text: 'This cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
@endsection
