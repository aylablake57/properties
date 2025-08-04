@extends('layouts.app')
@section('page')
    <style>
        /* Main container for dashboard content */
        .dashboard-content {
            position: relative;
            z-index: 1;
        }

        /* Blur effect for dashboard and sidebar */
        .dashboard-blur {
            filter: blur(5px);
            -webkit-filter: blur(5px);
            -moz-filter: blur(5px);
            -ms-filter: blur(5px);
            -o-filter: blur(5px);
            pointer-events: none;
        }

        /* Overlay that will cover the entire dashboard */
        .dashboard-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }
        .dashboard-overlay.show {
            display: block;
        }

        /* Agreement modal container */
        .agreement-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            max-width: 90%;
            max-height: 600px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1002;
            padding: 20px;
            filter: none !important;
            -webkit-filter: none !important;
            -moz-filter: none !important;
            -ms-filter: none !important;
            -o-filter: none !important;
            pointer-events: auto !important;
            transform-style: preserve-3d;
        }
        .agreement-container.show {
            display: block;
        }

        /* Modal header and body */
        .agreement-header {
            margin-bottom: 20px;
        }
        .agreement-body {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }
        .agreement-footer {
            margin-top: 20px;
            padding: 0;
            border-top: none;
        }

        /* Force modal to be completely clear */
        .agreement-container * {
            filter: none !important;
            -webkit-filter: none !important;
            -moz-filter: none !important;
            -ms-filter: none !important;
            -o-filter: none !important;
            pointer-events: auto !important;
        }

        /* Prevent blur inheritance */
        .agreement-container::before,
        .agreement-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        /* Blur sidebar and dashboard content */
        .dashboard-blur .sidebar,
        .dashboard-blur .main-content {
            filter: blur(5px) !important;
        }
    </style>
    @if(!auth()->user()->hasAcceptedAgreement())
        <!-- Dashboard overlay -->
        <div class="dashboard-overlay show"></div>
        
        <!-- Agreement modal -->
        <div class="agreement-container show">
            <div class="agreement-header">
                <h5>User Agreement</h5>
            </div>
            <div class="agreement-body">
                <p>Please read and accept the following agreement to proceed:</p>
                <div class="p-3" style="max-height: 300px; overflow-y: auto; border: 1px solid #a0af50;">
                    <p>
                        Any one is allowed to offer property for sale himself or on behalf
                        If wrongly uploaded than upon complaint and proof of exact ownership provided by complainant the dealer detail is provided to complainant
                        If still an issue than upon proof of non resolution we can block the dealer as punitive action
                        If dealer proves that the property was offered by owner himself than the owner is responsible.
                    </p>
                </div>
                <form action="{{ route('agreement.accept') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="agree" id="agree" required>
                        <label class="form-check-label" for="agree">
                            I have read and agree to the terms and conditions.
                        </label>
                        @error('agree')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="agreement-footer">
                        <button type="submit" class="btn btn-accent">Accept</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add blur class to sidebar and dashboard content
                const sidebar = document.querySelector('.sidebar');
                const mainContent = document.querySelector('.main-content');
                if (sidebar) sidebar.classList.add('dashboard-blur');
                if (mainContent) mainContent.classList.add('dashboard-blur');
                
                // Remove blur class and overlay after form submission
                const form = document.querySelector('.agreement-container form');
                if (form) {
                    form.addEventListener('submit', function() {
                        if (sidebar) sidebar.classList.remove('dashboard-blur');
                        if (mainContent) mainContent.classList.remove('dashboard-blur');
                        document.querySelector('.dashboard-overlay').classList.remove('show');
                        document.querySelector('.agreement-container').classList.remove('show');
                    });
                }
            });
        </script>
    @endif
    <div class="dashboard-content">
        <header class="pagetitle">
    <header class="pagetitle">
        <h2>{{ __('Dashboard') }}</h2>
    </header>

    <div class="my-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="widget-container bg-white p-3">
                    <h6>My Credits</h6>
                    <div id="accordion">
                        <ul id="tabs" class="nav nav-underline nav-fill pb-2 " data-bs-toggle="tab">
                            <li class="nav-item">
                                <a class="nav-link active" href="#listing" data-bs-toggle="tab" data-bs-parent="#collapse">Listing ({{ $myProperties->count() }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#refresh" data-bs-toggle="tab" data-bs-parent="#collapse">Refresh(0)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#hot" data-bs-toggle="tab" data-bs-parent="#collapse">Premium (0)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#superhot" data-bs-toggle="tab" data-bs-parent="#collapse">Featured (0)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel p-3 pt-5">
                        <div id="listing" class="collapse show">
                            <div class="row">
                                <div class="col-sm-4 text-center mb-3">
                                    <div class="bg-shadow py-3 rounded-pill">
                                        <h6>Total</h6>
                                        <h6 class="mb-0" id="totalProperties"><strong>{{ $total }}</strong></h6>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-center mb-3">
                                    <div class="bg-shadow py-3 rounded-pill">
                                        <h6>Consumed</h6>
                                        <h6 class="mb-0" id="consumed"><strong>{{ $myProperties->count() }}</strong></h6>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-center mb-3">
                                    <div class="bg-shadow py-3 rounded-pill">
                                        <h6>Remaining</h6>
                                        <h6 class="mb-0"><strong>{{ $total - $myProperties->count() }}</strong></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="refresh" class="collapse fade">

                        </div>
                        <div id="hot" class="collapse fade">
                        </div>
                        <div id="superhot" class="collapse fade">
                        </div>
                    </div>
                </div>
            </div>
            {{-- Column added by Hamza Amjad --}}
            <div class="col-lg-6 d-flex">
                {{-- Alert box --}}
                @if (auth()->user()->city_id == null)
                    <div class="alert-box bg-warning text-center text-dark p-4 w-50">
                        <h5><i class="fa fa-exclamation-triangle me-1" aria-hidden="true"></i> Complete Your Profile, Location not added</h5>
                        <p>Please ensure that your city location is up-to-date for accurate listings.</p>
                
                        <a href="{{ route('profile.update') }}" class="btn btn-secondary w-100 mt-3 alert-box-button">
                            Update Location
                        </a>
                    </div>
                @endif
                {{-- speedometer graph --}}
                <div id="speedometer-container" class="w-100"></div>
            </div> 
        </div>
    </div>

    <div class="my-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-container bg-white p-3">
                    <h6>My Recent Listings</h6>
                    @include("partials.property-list" , [ 'listings' => $myProperties])
                </div>
            </div>
        </div>
    </div>

    <!-- Ads -->
    @if(isset($listings) && !$listings->isEmpty())
    <div class="my-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-container bg-white p-3">
                    <h6>My Recent Ads</h6>
                    <div class="table-responsive">
                        @include("partials.ad-list" , [ 'listings' => $listings])
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('page_script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

    <script src="{{ getadminasset('js/user-charts.js') }}?v={{ config('app.version') }}"></script>
@endsection