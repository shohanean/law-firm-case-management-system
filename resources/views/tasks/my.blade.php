@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">My Tasks</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Tasks</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-3 mb-4">
        <div class="col">
            <div class="card radius-10 border-0 border-start border-warning border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1">Pending</p>
                            <h4 class="mb-0 text-warning">{{ $tasks->where('status', 'pending')->count() }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-warning text-white" style="cursor:default;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-info border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1">In Progress</p>
                            <h4 class="mb-0 text-info">{{ $tasks->where('status', 'in_progress')->count() }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-info text-white" style="cursor:default;">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-success border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1">Completed</p>
                            <h4 class="mb-0 text-success">{{ $tasks->where('status', 'completed')->count() }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-success text-white" style="cursor:default;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card radius-10">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Tasks Assigned to Me</h6>
                    <span class="badge bg-secondary">{{ $tasks->count() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-start">Title</th>
                                    <th>Assigned By</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Update Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr class="align-middle {{ $task->status === 'completed' ? 'table-success' : '' }}">
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-medium {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                {{ $task->title }}
                                            </div>
                                            @if ($task->description)
                                                <small class="text-muted">{{ $task->description }}</small>
                                            @endif
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
                                            <select class="form-select form-select-sm task-status-select"
                                                data-url="{{ route('tasks.status.update', $task->id) }}"
                                                data-current="{{ $task->status }}">
                                                <option value="pending" @selected($task->status === 'pending')>Pending</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No tasks assigned to you.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = '{{ csrf_token() }}';

        document.querySelectorAll('.task-status-select').forEach(function (select) {
            select.addEventListener('change', function () {
                const url    = this.dataset.url;
                const body   = new URLSearchParams({ _method: 'PATCH', status: this.value });
                const row    = this.closest('tr');
                const originalValue = this.dataset.current;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Accept': 'application/json',
                    },
                    body: body.toString(),
                })
                .then(function (res) {
                    if (!res.ok) throw new Error();
                    return res.json();
                })
                .then(function () {
                    select.dataset.current = select.value;

                    // Update badge in status column
                    const badgeCell = row.cells[4];
                    const statusMap = {
                        pending:     '<span class="badge bg-warning text-dark">Pending</span>',
                        in_progress: '<span class="badge bg-info text-dark">In Progress</span>',
                        completed:   '<span class="badge bg-success">Completed</span>',
                    };
                    badgeCell.innerHTML = statusMap[select.value] || '';

                    // Update row highlight & title strikethrough
                    const titleEl = row.querySelector('td:nth-child(2) .fw-medium');
                    if (select.value === 'completed') {
                        row.classList.add('table-success');
                        titleEl.classList.add('text-decoration-line-through', 'text-muted');
                    } else {
                        row.classList.remove('table-success');
                        titleEl.classList.remove('text-decoration-line-through', 'text-muted');
                    }

                    Swal.fire({ toast: true, position: 'top-end', icon: 'success',
                        title: 'Status updated', showConfirmButton: false, timer: 1800 });
                })
                .catch(function () {
                    select.value = originalValue;
                    Swal.fire({ toast: true, position: 'top-end', icon: 'error',
                        title: 'Update failed', showConfirmButton: false, timer: 2000 });
                });
            });
        });
    });
</script>
@endsection
