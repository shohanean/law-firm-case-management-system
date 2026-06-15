<div class="card border-danger mb-4">
    <div class="card-header text-danger">Delete Account</div>
    <div class="card-body">
        <p class="text-muted mb-4">
            Once your account is deleted, all of its data will be permanently removed.
            Please download any information you wish to retain beforehand.
        </p>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            <i class="bi bi-trash-fill me-1"></i> Delete Account
        </button>
    </div>
</div>

{{-- Confirm Delete Modal --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action <strong>cannot be undone</strong>.</p>
                    <div class="mb-0">
                        <label for="delete_password" class="form-label">Enter your password to confirm</label>
                        <input type="password" id="delete_password" name="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            placeholder="Your current password">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
    });
</script>
@endif