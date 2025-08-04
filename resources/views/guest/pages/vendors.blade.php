@extends('guest.layouts.guest')
@section('title') Property Details @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <style>
        .inner-banner {
            background-image: linear-gradient(to top, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) 56%), url(/assets/images/vendors/banner.jpg);
        }
    </style>
@endsection

@section('page')
    <div class="inner-banner">
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-10 offset-xl-1">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <form method="get" action="{{ route('authorizees.vendors') }}">
                                <div class="row">
                                    <div class="col justify-content-start mb-3">
                                        <select class="form-select" name="type">
                                            <option value="">Company Type</option>
                                            @foreach($companyTypes as $type)
                                                <option class="text-capitalize" value="{{ $type->firm_category }}" {{ (isset($search['type']) && $type->firm_category == $search['type']) ? 'selected' : '' }}>{{strtolower($type->firm_category)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col justify-content-center mb-3">
                                        <select class="form-select" name="city">
                                            <option value="" selected disabled>City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ (isset($search['city']) && $city->id == $search['city']) ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col justify-content-center mb-3">
                                        <select class="form-select" name="area">
                                            <option value="" selected disabled>Area</option>
                                        </select>
                                    </div> --}}
                                    <div class="col justify-content-end">
                                        <button type="submit" class="btn btn-accent">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-9 mb-3">
                @if (session('check_contact_agent'))
                    <div class="alert alert-success">
                        {{ session('check_contact_agent') }}
                    </div>
                @endif
                <div class="featured-agents bg-white mb-5 pb-5">
                    <div class="container">
                        <div class="section-title py-3">
                            <h4>Vendors List</h4>
                        </div>

                        <div class="row">
                            @foreach($vendors as $vendor)
                                <div class="col-lg-6 mb-3">
                                    <div class="vendor-box border-all p-2">
                                        <div class="profile-details py-2">
                                            <h6 class="text-capitalize">{{ $vendor->name_of_firm }}</h6>
                                            @if($vendor->name_of_person)
                                            <span class="counts">{{ $vendor->name_of_person }} </span>
                                            |
                                            @endif
                                            <span class="count">{{ $vendor->dha_name }}</span>
                                            <br>

                                            <h6 class="my-2">Contact Details</h6>
                                            <div class="location mb-3">
                                                @php
                                                    if ($vendor->contact_no) {
                                                        $contactList = explode(' ', $vendor->contact_no);
                                                        foreach($contactList as $contact) {
                                                            echo '<i class="fa-solid fa-phone pt-1 me-3"></i>';
                                                            echo $contact;
                                                            echo '<br>';
                                                        }
                                                    }
                                                @endphp
                                            </div>

                                            @if($vendor->address)
                                            <div class="d-flex justify-content-start">
                                                <i class="fa-solid fa-location-dot pt-1 me-3"></i>
                                                <p class="mb-0">{{ $vendor->address }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {!! $vendors->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-3">
                <div class="bg-white p-3 mb-3">
                    @include ('guest.partials.latest-properties')
                </div>

                <div class="ads-container">
                    @if (file_exists('assets/images/banner/top-banner.jpeg'))
                        <img src="{{ getAdminAsset('images/banner/top-banner.jpeg') }}" class="img-fluid" alt="Properties">
                    @endif
                    <h4>Find out more about DHA Defence</h4>
                    @foreach( getAdsForColumn() as $ad)
                    <img src="{{ env('FTP_BASE_URL'). '/' .$listing->file_name }}" class="img-fluid mb-3" alt="Properties">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
@endsection