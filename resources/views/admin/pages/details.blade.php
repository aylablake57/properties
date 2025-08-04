@extends('layouts.app')
{{-- @section('title') Admin Dashboard @endsection --}}
@section('page')
    @php
        $profileImage = $user?->profile_image
            ? env('FTP_BASE_URL') . '/' . $user->profile_image
            : asset('assets/images/users/blank.png');

    @endphp
    <div class="mb-3">
        @if (session('approval_error'))
            <div class="alert alert-danger">
                {{ session('approval_error') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <a class="pt-3" href="{{ route('admin.requests.list') }}"><i class="fas fa-angle-double-left"></i> Back to
                List</a>

            <!-- new if condition code added by Yousaf to display approve and cancel button on only approved properties -->
            {{-- Conditionally display the approve and cancel buttons --}}
            @if ($property->publish_status !== 'Approved')
                <form method="post" action="{{ route('admin.requests.approval') }}">
                    @csrf
                    <input type="hidden" value="{{ $property->id }}" name="property_id">
                    <button class="btn btn-success ms-auto me-0" name="approve">Approve</button>
                    <button type="button" class="btn btn-danger ms-auto me-0" id="cancelButton">Cancel</button>
                    {{-- <button class="btn btn-danger ms-auto me-0" name="cancel">Cancel</button> --}}
                </form>
            @endif
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-8">
                <div class="widget-container bg-white p-3">
                    <h5 class="text-capitalize">{{ $property->title }}</h5>
                    <p>{{ $property->location?->name . ', ' . $property->city?->name }}</p>
                    <p>{{ toCurrency($property->price, 'PKR') }}</p>
                </div>
                {{-- <div class="row my-3">
                @if ($property->featured_image)
                <div class="col-sm-3 ">
                    <img src="{{ env('FTP_BASE_URL'). '/' .$property->featured_image }}" width="150px"/>
                </div>
                @endif
                @if ($property->media->isNotEmpty())
                @foreach ($property->media as $media)
                    <div class="col-sm-3">
                        <img src="{{ env('FTP_BASE_URL'). '/' .$media->file_path }}" width="150px"/>
                    </div>
                @endforeach
                @endif
            </div> --}}

                <div class="widget-container bg-white p-3">
                    <h4>Overview</h4>
                    <h6>Details</h6>

                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Type</td>
                                    <td class="text-capitalize">{{ $property->subtype?->name }}
                                        {{ $property->propertyType?->name }}</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td class="text-capitalize">{{ toCurrency($property->price, 'PKR') }}</td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td class="text-capitalize">{{ $property->location?->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Area</td>
                                    <td class="text-capitalize">{{ $property->area_size }}
                                        {{ $property->area_unit?->name }}</td>
                                </tr>
                                <tr>
                                    <td>Purpose</td>
                                    <td class="text-capitalize">{{ $property->purpose }}</td>
                                </tr>
                                <tr>
                                    <td>Added</td>
                                    <td class="text-capitalize">{{ $property->created_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 border-bottom">
                        <h6>Description</h6>
                        <p>{{ $property->description }}</p>
                    </div>

                </div>

                <div class="widget-container bg-white p-3">
                    <h4>Amenities</h4>
                    @if ($amenities)
                        @foreach ($amenities as $title => $amenityGroup)
                            <div class="row mt-3">
                                <div class="col-sm-3 mb-3 border-right">
                                    <label for="title" class="form-label">{{ $title }}</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        @foreach ($amenityGroup as $key => $data)
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-check d-flex">
                                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                                    <label class="form-check-label" for="{{ $key . '-' . $data['id'] }}">
                                                        @if ($data['amenity_value'] === 'true')
                                                            {{ $data['value'] }}
                                                        @elseif (is_numeric($data['amenity_value']))
                                                            {{ $data['amenity_value'] . ' ' . $data['value'] }}
                                                        @else
                                                            {{ $data['amenity_value'] }}
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-sm-4">
                <div class="widget-container bg-white p-3">
                    <div class="d-flex justify-start gap-4">
                        <img src="{{ asset($profileImage) }}" class="img-fluid rounded-circle mb-3 text-center"
                            width="100px" height="100px" alt="Profile Image">
                        <div class="pt-4">
                            <h5 class="text-capitalize"> <strong>{{ $property->user?->name }}</strong></h5>
                            @if ($property->user?->user_type?->name == 'Agency')
                                Real Estate Agency
                            @elseif ($property->user?->user_type?->name == 'Agent')
                                Property Agent
                            @else
                                Seller
                            @endif
                        </div>

                    </div>
                    <table class="table table-borderless my-3 text-start">
                        <tbody>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $user->phone != '' ? SmsCellPhoneNumber($user->phone) : '' }}</td>
                            </tr>
                            <tr>
                                <th>Landline</th>
                                <td>{{ $user->landline }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $user->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        @if ($property->featured_image)
                            <div class="swiper-slide">
                                <img src="{{ env('FTP_BASE_URL') . '/' . $property?->featured_image }}" class="img-fluid"
                                    alt="Properties" />
                            </div>
                        @endif
                        @if ($property->media->isNotEmpty())
                            @foreach ($property->media as $media)
                                <div class="swiper-slide">
                                    <img src="{{ env('FTP_BASE_URL') . '/' . $media?->file_path }}" class="img-fluid"
                                        alt="Properties" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade @if ($errors->any()) show @endif" id="cancelModal" tabindex="-1"
        aria-labelledby="cancelModalLabel" aria-hidden="true"
        @if ($errors->any()) style="display: block;" @endif>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.requests.approval') }}" id="cancelForm">
                        @csrf
                        <input type="hidden" value="{{ $property->id }}" name="property_id">
                        <input type="hidden" value="{{ null }}" name="cancel">

                        <label for="cancel_reason" class="my-3">Why do you want to cancel this Property?</label>
                        <x-textarea name="cancel_reason" id="message" placeholder="Message" maxlength="1500"
                            required="true" />

                        <!-- Display validation errors -->
                        @if ($errors->has('cancel_reason'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('cancel_reason') }}
                            </div>
                        @endif

                        <!-- Loader -->
                        <div id="loader" class="text-center mt-3" style="display: none;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="confirmCancel">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script>
        // Show modal on cancel button click
        document.getElementById('cancelButton').addEventListener('click', function() {
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        });
        document.getElementById('confirmCancel').addEventListener('click', function() {
            document.getElementById('loader').style.display = 'block';

            document.getElementById('cancelForm').submit();
        });
        @if ($errors->any())
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        @endif
    </script>


    <script>
        /* var swiper = new Swiper(".mySwiper", {
                        spaceBetween: 10,

                        slidesPerView: 4,
                        freeMode: true,
                        watchSlidesProgress: true,
                    }); */
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            slidesPerView: 1,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            /* thumbs: {
                swiper: swiper,
            }, */
        });
    </script>
@endsection
