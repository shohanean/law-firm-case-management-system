<div class="card mb-4">
    <div class="card-header">Profile Information</div>
    <div class="card-body">
        <p class="text-muted mb-4">Update your account's name and email address.</p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input readonly type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-warning small mb-1">Your email address is unverified.</p>
                            <button form="send-verification" class="btn btn-sm btn-outline-warning">
                                Re-send verification email
                            </button>
                        </div>
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success small mt-1">A new verification link has been sent.</p>
                        @endif
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success small"><i class="bi bi-check-circle me-1"></i>Saved.</span>
                @endif
            </div>
        </form>
    </div>
</div>
