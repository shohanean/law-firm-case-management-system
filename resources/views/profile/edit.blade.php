@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Profile Information --}}
            @include('profile.partials.update-profile-information-form')

            {{-- Update Password --}}
            @include('profile.partials.update-password-form')

            {{-- Delete Account --}}
            {{-- @include('profile.partials.delete-user-form') --}}

        </div>
    </div>
@endsection
