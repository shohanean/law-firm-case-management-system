@extends('layouts.admin')

@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
        <div class="col">
        <div class="card radius-10 border-0 border-start border-pink border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Cases</p>
                <h4 class="mb-0 text-pink">{{ $cases->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-pink text-white">
                <i class="bi bi-folder-fill"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-danger border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Urgent Cases</p>
                <h4 class="mb-0 text-danger">{{ $cases->where('urgency', true)->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-danger text-white">
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
                <p class="mb-1">Total Active Users</p>
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
                        <h6 class="mb-0">All Cases</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <select class="form-select" name="sort" onchange="this.form.submit()">
                                    <option @if(isset($_GET['sort']) && $_GET['sort'] === 'az') selected @endif value="az">Sort By: Client Name (A-Z)</option>
                                    <option @if(isset($_GET['sort']) && $_GET['sort'] === 'za') selected @endif value="za">Sort By: Client Name (Z-A)</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    @include('parts.caselisttable')
                </div>
            </div>
        </div>
    </div><!--end row-->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Opev vs. Closed Cases</h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Project Type Wise Count</h6>
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
        @php
            $grouped = $cases->where('open_project', true)
                ->groupBy('project_type_id')
                ->map(fn($group) => [
                    'label' => $group->first()->projectType?->project_type_name ?? 'Unknown',
                    'count' => $group->count(),
                ]);
            $chart2Labels = $grouped->pluck('label')->values();
            $chart2Data   = $grouped->pluck('count')->values();
        @endphp
        const ctx2 = document.getElementById('myChart2');

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($chart2Labels),
                datasets: [{
                    label: 'Open Cases',
                    data: @json($chart2Data),
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.parsed.y + ' case' + (ctx.parsed.y !== 1 ? 's' : '')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
        // myChart2 end
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
