@php
        $profileImage = $user && $user->profile_image
                    ? env('FTP_BASE_URL'). '/' .$user->profile_image
                    : asset('assets/images/users/blank.png');
@endphp

@extends('layouts.app')
@section('title') Create New User @endsection
@section('page')
<div class="main">
    <hr>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <div class="tab-content">
            <form method="post" action="{{ route('admin.users.add') }}" enctype="multipart/form-data">
                @csrf
                @if ($user)
                    <input type="hidden" value="{{ $user->id }}" name="user_id">
                @endif
                <div class="gap-5 mb-3 d-flex flex-column flex-sm-row custom-edit-form-center">
                    <img src="{{ asset($profileImage) }}" class="img-fluid rounded-circle" width="100px" height="100px" alt="Profile Image">
                    <div class="pt-3">
                        <label for="image">Upload Profile Image</label>
                        <input type="file" class="form-control" name="profile_image">
                    </div>
                </div>
                <hr>
                <div class="section-title ms-0">Personal Info</div>

                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label for="name">Full Name <span class="text-danger fs-12">*(Mandatory)</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user ? $user->name : old('name') }}" placeholder="Enter user full name">
                        @error('name')
                            <span class='text-danger fs-12'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="phone">Mobile Number <span class="text-danger fs-12">*(Mandatory)</span></label>
                        <x-phone-input name="phone" />
                    </div>
                    <div class="mb-3 col-sm-6">
                        <x-landline-input name="landline" />

                    </div>

                    <div class="mb-3 col-sm-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $user ? $user->address : old('address') }}" placeholder="Enter Complete Address">
                        @error('address')
                            <span class='text-danger fs-12'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="title">City <span class="text-danger fs-12">*(Mandatory)</span></label>
                        <select class="form-select dropdown" id="city-dropdown" name="city">
                            <option value="" selected disabled>Select City</option>
                            @foreach ($cities as $city)
                                <option
                                    value="{{ $city->id }}"
                                    @selected($user && $user->city_id == $city->id?  : $city->id == old('city'))
                                >
                                {{ $city->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('city')
                            <br/><span class='text-danger fs-12'>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($user) @else
                <hr>
                <div class="section-title ms-0">Account Info</div>
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label for="email">Email <span class="text-danger fs-12">*(Mandatory)</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user ? $user->email : old('email') }}" placeholder="Enter email address">
                        @error('email')
                            <span class='text-danger fs-12'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="password">Password <span class="text-danger fs-12">{{ $user ? '' : '*(Mandatory)'}}</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        @error('email')
                            <span class='text-danger fs-12'>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif
                <hr>
                <div class="row">
                    {{-- button offset issue resolved by Hamza Amjad for small screen and large --}}
                    <div class="col-sm-4 offset-lg-8 text-end">
                        <button class="btn btn-accent">
                            {{ $user ? 'Update User' : 'Submit User' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
