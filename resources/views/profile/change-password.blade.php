@extends('layouts.app')
@section('page')
    <header class="pagetitle">
        <h1>{{ __('Profile Information') }}</h1>
    </header>

    <div class="main my-5">
        <div class="container-fluid">
            <div class="tab-content">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="section-title">Change Password</div>
                <div class="section-content">
                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')
                    <div class="row">
                        <div class="col-sm-8 mb-2">
                            <label for="password">Current Password <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="password" class="form-control mb-1" name="current_password">
                            @error('current_password')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-8 mb-2">
                            <label for="password">New Password <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="password" class="form-control mb-1" name="password">
                            @error('password')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-8 mb-2">
                            <label for="password_confirmation">Confirm Password <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="password" class="form-control mb-1" name="password_confirmation">
                            @error('password_confirmation')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-end">
                            <button class="btn btn-md btn-accent w-auto">Update</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
