<div class="card mb-4">
    <div class="card-header">Update Password</div>
    <div class="card-body">
        <p class="text-muted mb-4">Use a long, random password to keep your account secure.</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="update_password_current_password" class="form-label">Current Password</label>
                    <input type="password" id="update_password_current_password" name="current_password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="update_password_password" class="form-label">New Password</label>
                    <input type="password" id="update_password_password" name="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">Update Password</button>
                @if (session('status') === 'password-updated')
                    <span class="text-success small"><i class="bi bi-check-circle me-1"></i>Saved.</span>
                @endif
            </div>
        </form>
    </div>
</div>