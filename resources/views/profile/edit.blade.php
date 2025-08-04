@php
        $profileImage = $user->profile_image
                    ? env('FTP_BASE_URL') . '/' . $user->profile_image
                    : asset('assets/images/users/blank.png');
@endphp
@extends('layouts.app')
@section('page')
    <header class="pagetitle">
        <div class="d-flex flex-column flex-sm-row custom-edit-form-center justify-start gap-4">
            <img src="{{ asset($profileImage) }}" class="img-fluid rounded-circle" width="100px" height="100px" alt="Profile Image">
            <div class="pt-4">
                <h1 class="text-capitalize">{{ $user->name }}</h1>
                <p>{{ $user->email }}</p>
            </div>
        </div>
    </header>

    <div class="main my-5">
        <div class="container-fluid">
            <div class="tab-content float-none">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="section-title">Update Profile</div>
                <div class="section-content">
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf
                @method('patch')
                    <div class="row">
                        @if (auth()->user()->user_type->name == 'agency')
                            <div class="col-sm-6 mb-3">
                                <label for="title">Company Name <span class="text-danger fs-12">*(Mandatory)</span></label>
                                <input type="text" class="form-control" readonly name="company" value="{{ old('name' , $user->cnic_number) }}">
                                @error('company')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-sm-6 mb-3">
                            <label for="title">{{ (auth()->user()->user_type->name == 'agency') ? 'Name  of CEO' : 'Name' }} <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="title">Email <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="email" class="form-control" readonly disabled name="email" value="{{ $user ? $user->email : old('email') }}">
                            @error('email')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="title">Mobile <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <x-phone-input name="phone" value="{{ $user ? $user->phone : old('phone') }}" />
                        </div>

                        <div class="col-sm-6">
                            <x-landline-input name="landline" value="{{ $user ? $user->landline : old('landline') }}"/>
                        </div>

                        @if (auth()->user()->user_type->name != 'Seller')
                            <div class="col-sm-6 mb-3">
                                {{-- By Asfia --}}
                                <label for="title">{{ (auth()->user()->user_type->name == 'Agency') ? 'CNIC  of CEO' : 'CNIC' }} <span class="text-danger fs-12">*(Mandatory)</span></label>
                                <input type="text" class="form-control" name="cnic" value="{{ $user->cnic_number }}">
                                @error('cnic')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="col-sm-6 mb-3">
                            <label for="title">City <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <select class="form-select dropdown" id="city-dropdown" name="city_id" required>
                                <option value="" selected disabled>Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"<?=(old('city') ? (old('city') == $city->id ? "selected" : "") : ($city->id == $user->city_id ? "selected" : ""))?>>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="title">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $user->address) }}" id="address" placeholder="Your Address">
                        </div>

                        <!-- Facebook -->
                        <div class="col-md-6 mb-3">
                            <label for="facebook_id">Facebook Profile Link</label>
                            <input type="url" class="form-control" name="facebook_id" id="facebook_id" placeholder="https://"
                                   :required="false" value="{{ old('facebook_id', $user->facebook_id) }}">
                            @error('facebook_id')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Instagram -->
                        <div class="col-md-6 mb-3">
                            <label for="instagram">Instagram Profile Link</label>
                            <input type="url" class="form-control" name="instagram" id="instagram" placeholder="https://"
                                   :required="false" value="{{ old('instagram', $user->instagram) }}">
                            @error('instagram')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- LinkedIn -->
                        <div class="col-md-6 mb-3">
                            <label for="linkedin">LinkedIn Profile Link</label>
                            <input type="url" class="form-control" name="linkedin" id="linkedin" placeholder="https://"
                                   :required="false" value="{{ old('linkedin', $user->linkedin) }}">
                            @error('linkedin')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Youtube -->
                        <div class="col-md-6 mb-3">
                            <label for="youtube">Youtube Channel Link</label>
                            <input type="url" class="form-control" name="youtube" id="youtube" placeholder="https://"
                                   :required="false" value="{{ old('youtube', $user->youtube) }}">
                            @error('youtube')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-sm-6 mb-3">
                            <label for="image">Upload Image</label>
                            <input type="file" class="form-control" name="profile_image" accept="image/*">
                            <div>
                                <small>The image should have dimension of 200x200 or more in square form</small>
                            </div>
                            @error('profile_image')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="title">Something About Yourself</label>
                            <x-textarea
                                name="about"
                                id="about"
                                placeholder="Something About Yourself"
                                maxlength="1500"
                                value="{{ old('about', $user->about) }}"
                                :required="false"
                            />
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-accent w-auto">Update</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
