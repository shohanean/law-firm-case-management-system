@extends('layouts.admin')

@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
        <div class="col">
        <div class="card radius-10 border-0 border-start border-pink border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Open Cases</p>
                <h4 class="mb-0 text-pink">{{ $cases->where('open_project', true)->count() }}</h4>
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
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Open Cases</h6>
                        <a href="{{ route('case.index') }}" class="btn btn-sm btn-outline-primary">All Cases</a>
                    </div>
                </div>
                <div class="card-body">
                @if (session('remark_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('remark_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive mt-2" >
                    <table class="table table-bordered" id="dashboardCaseListTable">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>SL. No.</th>
                            <th>Client Name</th>
                            <th>Project Type</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Urgency</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cases->where('open_project', true) as $case)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td class="text-wrap" style="max-width: 150px;">{{ $case->client_name }}</td>
                            <td class="text-wrap" style="max-width: 150px;">{{ $case->projectType->project_type_name ?? '-' }}</td>
                            <td>
                                <select class="form-select form-select-sm status-select"
                                    data-case-id="{{ $case->id }}"
                                    data-url="{{ route('case.status.update', $case->id) }}">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            @selected($case->status_id === $status->id)>
                                            {{ $status->status_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-wrap" style="max-width: 150px;"><i class="bi bi-person-circle me-2"></i>{{ $case->assignedTo->name ?? '-' }}</td>
                            <td class="text-center">
                                @if($case->urgency)
                                    <span class="badge bg-danger">Urgent</span>
                                @else
                                    <span class="badge bg-secondary">Normal</span>
                                @endif
                            </td>
                            <td>
                                {{ $case->created_at->format('d M Y') }}
                                <br>
                                <small class="text-muted">{{ $case->created_at->diffForHumans() }}</small>
                            </td>
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
                        <tr><td colspan="8" class="text-center">No open cases found.</td></tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Case Distribution 1</h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Case Distribution 2</h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
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
        // myChart1 start
        const ctx1 = document.getElementById('myChart1');

        new Chart(ctx1, {
            type: 'doughnut',
            data: {
            labels: ['Open Cases', 'Closed Cases'],
            datasets: [{
                label: '# of Cases',
                data: [{{ $cases->where('open_project', true)->count() }}, {{ $cases->where('open_project', false)->count() }}],
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        // myChart1 end
        // myChart2 start
        const ctx2 = document.getElementById('myChart2');

        new Chart(ctx2, {
            type: 'line',
            data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        // myChart2 end

        // caseListTable start
        let table = new DataTable('#dashboardCaseListTable', {
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
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = '{{ csrf_token() }}';

            document.querySelectorAll('.status-select').forEach(function (select) {
                const originalValue = select.value;
                select.dataset.original = originalValue;

                select.addEventListener('change', function () {
                    const url    = this.dataset.url;
                    const body   = new URLSearchParams({ _method: 'PATCH', status_id: this.value });

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
                        if (!res.ok) throw new Error('Server error');
                        return res.json();
                    })
                    .then(function () {
                        select.dataset.original = select.value;
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success',
                            title: 'Status updated', showConfirmButton: false, timer: 1800 });
                    })
                    .catch(function () {
                        select.value = select.dataset.original;
                        Swal.fire({ toast: true, position: 'top-end', icon: 'error',
                            title: 'Update failed', showConfirmButton: false, timer: 2000 });
                    });
                });
            });

            document.getElementById('addRemarkModal').addEventListener('show.bs.modal', function (event) {
                var trigger = event.relatedTarget;
                var caseId = trigger.getAttribute('data-case-id');
                var client = trigger.getAttribute('data-client');
                document.getElementById('remarkForm').action = '/case/' + caseId + '/remark';
                document.getElementById('remarkClientName').textContent = client;
                document.getElementById('remarks').value = '';
            });

            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This case will be deleted.',
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
