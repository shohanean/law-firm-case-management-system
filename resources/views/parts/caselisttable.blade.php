@if (session('remark_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('remark_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="table-responsive mt-2">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr class="text-center">
                <th>SL. No.</th>
                <th>Client Name</th>
                <th>Open Project?</th>
                <th>Project Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Urgency</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <style>
                .tr-gray {
                    background-color: #D9D9D9;
                }
                .tr-orenge {
                    background-color: #FCE4D6;
                }
                .tr-light-blue {
                    background-color: #DDEBF7;
                }
                .tr-light-green {
                    background-color: #E2F0D9;
                }
                .tr-light-yellow {
                    background-color: #FFFFCC;
                }
            </style>
            @forelse ($cases as $case)
            <tr class="
            @php
                if(!$case->updated_at){
                    echo '';
                }
                else{
                    if(!$case->open_project){
                        echo 'tr-gray';
                    }
                    else{
                        if($case->status){
                            if($case->status->status_name == 'Assigned to Close'){
                                echo 'tr-orenge';
                            }
                            else{
                                if($case->projectType->project_type_name == 'Various'){
                                    echo 'tr-light-blue';
                                }
                                else{
                                    if (str_contains($case->projectType->project_type_name, 'Trademark') || str_contains($case->projectType->project_type_name, 'Copyright')) {
                                        echo 'tr-light-green';
                                    }
                                    else{
                                        echo 'tr-light-yellow';
                                    }
                                }
                            }
                        }
                    }
                }
            @endphp
            ">
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td class="text-wrap" style="max-width: 150px;">
                    {{ $case->client_name }}
                </td>
                @if ($case->updated_at)
                <td class="text-wrap" style="max-width: 150px;">
                    @if ($case->open_project)
                    <i class="bx bx-check-circle"></i> Yes
                    @else
                    <i class="bx bx-x"></i> No
                    @endif
                </td>
                <td class="text-wrap" style="max-width: 150px;">{{ $case->projectType->project_type_name ?? '-' }}</td>
                <td class="text-wrap" style="max-width: 150px;">
                    {{ $case->description }}
                </td>
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
                @else
                <td colspan="6" class="text-center">
                    <span class="badge bg-success">New</span>
                </td>
                @endif
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
            <tr><td colspan="8" class="text-center text-danger">No cases found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
