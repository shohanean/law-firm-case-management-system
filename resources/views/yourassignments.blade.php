@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Your Assignments</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Your Assignments</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Your Assignments</h6>
                    </div>
                </div>
                <div class="card-body">
                    @include('parts.caselisttable')
                </div>
            </div>
        </div>
    </div><!--end row-->
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
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = '{{ csrf_token() }}';

            function updateRowColor(select) {
                const row = select.closest('tr');
                const openProject = row.dataset.openProject === '1';
                const projectType = row.dataset.projectType;
                const statusName = select.options[select.selectedIndex].dataset.statusName;
                const colorClasses = ['tr-gray', 'tr-orenge', 'tr-light-blue', 'tr-light-green', 'tr-light-yellow'];
                colorClasses.forEach(cls => row.classList.remove(cls));
                if (!openProject) {
                    row.classList.add('tr-gray');
                } else if (statusName === 'Assigned to Close') {
                    row.classList.add('tr-orenge');
                } else if (projectType === 'Various') {
                    row.classList.add('tr-light-blue');
                } else if (projectType.includes('Trademark') || projectType.includes('Copyright')) {
                    row.classList.add('tr-light-green');
                } else {
                    row.classList.add('tr-light-yellow');
                }
            }

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
                        updateRowColor(select);
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
