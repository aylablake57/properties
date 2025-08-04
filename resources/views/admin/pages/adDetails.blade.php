@extends('layouts.app')
{{-- @section('title') Admin Dashboard @endsection --}}
@section('page')
{{-- By ASfia --}}
@php
    $profileImage = $ad->user->profile_image
        ? env('FTP_BASE_URL'). '/' .$ad->user->profile_image
        : asset('assets/images/users/blank.png');
@endphp
<div class="mb-3">
    @if (session('approval_error'))
        <div class="alert alert-danger">
            {{ session('approval_error') }}
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <a class="pt-3" href="{{ route('admin.ads.list') }}"><i class="fas fa-angle-double-left"></i> Back to List</a>

        @if ($ad->status !== 'approved' && $ad->is_approved !== 1)
        <form method="post" action="{{ route('admin.ads.approval') }}" class="d-flex">
            @csrf
            <input type="hidden" value="{{ $ad->id }}" name="ad_id">
            <button class="btn btn-success ms-auto me-2" name="approve" id="approve">Approve</button>
            <button type="button" class="btn btn-danger ms-auto me-0" id="cancelButton">Cancel</button>
        </form>
        @endif
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-8">
            <div class="widget-container bg-white p-3">
                <h5 class="text-capitalize">Ad</h5>
                <img src="{{ env('FTP_BASE_URL') . '/' . $ad->file_name }}" class="img-fluid" alt="Ad Image">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="widget-container bg-white p-3">
                <div class="d-flex justify-start gap-4">
                    <img src="{{ asset($profileImage) }}" class="img-fluid rounded-circle mb-3 text-center" width="100px" height="100px" alt="Profile Image">
                    <div class="pt-4"><h5 class="text-capitalize">{{ $ad->user->name }}</h5>
                        @if ($ad->user->user_type->name == 'Agency')
                            Real Estate Agency
                        @elseif ($ad->user->user_type->name == 'Agent')
                            Property Agent
                        @else
                            Seller
                        @endif
                    </div>
                </div>
                <table class="table table-borderless my-3 text-start">
                    <tbody>
                    <tr>
                        <th>Email</th><td>{{ $ad->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th><td>{{ $ad->user->phone != '' ? SmsCellPhoneNumber($ad->user->phone) : '' }}</td>
                    </tr>
                    <tr>
                        <th>Landline</th><td>{{ $ad->user->landline }}</td>
                    </tr>
                    <tr>
                        <th>Address</th><td>{{ $ad->user->address }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                <div class="swiper-wrapper">
                    @if ($ad->featured_image)
                    <div class="swiper-slide">
                        <img src="{{ env('FTP_BASE_URL'). '/' .$ad->file_name }}" class="img-fluid" alt="Ads"/>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- By Asfia --}}
<!-- Textarea Modal -->
<div class="modal fade @if ($errors->any()) show @endif" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true" @if ($errors->any()) style="display: block;" @endif>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.ads.approval') }}" id="cancelForm">
                    @csrf
                    <input type="hidden" value="{{ $ad->id }}" name="ad_id">
                    <input type="hidden" value="{{ null }}" name="cancel">

                    <label for="cancel_reason" class="my-3">Why do you want to cancel this ad?</label>
                    <x-textarea
                        name="cancel_reason"
                        id="message"
                        placeholder="Message"
                        maxlength="1500"
                        required="true"
                    />

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

        // Handle confirmation of cancel action
        document.getElementById('confirmCancel').addEventListener('click', function() {
            // Show loader before form submission
            document.getElementById('loader').style.display = 'block';

            // Submit the form
            document.getElementById('cancelForm').submit();
        });

        // Reopen modal if there are errors
        @if ($errors->any())
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        @endif
    </script>
@endsection
