@extends('guest.layouts.guest')
@section('title')
    Home
@endsection

@section('local-style')
    <link href="{{ getAdminAsset('css/banner.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/slider.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/prop-Iframe.css') }}?v={{ config('app.version') }}" rel="stylesheet">

    <!-- Slick slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <link href="{{ getAdminAsset('css/slick-slider.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        .ld-form {
            max-width: 800px;
            margin: 1em auto;
        }

        .ld-row {
            margin: 0.3em 0;
        }

        .ld-row input {
            line-height: 1.5em;
            padding: 0.375rem 0.75rem;
            border: 1px solid rgba(128, 128, 128, 0.3);
            border-radius: 0.25rem;
            color: #495057;
        }

        .ld-label {
            width: 200px;
            display: inline-block;
        }

        .ld-url-input {
            width: 400px;
            max-width: calc(100% - 2rem);
        }

        .ld-time-input {
            width: 40px;
        }
    </style>
@endsection

@section('page')
    {{-- @if (file_exists('assets/images/banner/top-banner.jpeg'))
        <div class="container-fluid clearfix mt-5 text-center">
            <img src="{{ getAdminAsset('images/banner/top-banner.jpeg') }}" class="img-fluid" style="margin-top:2.3rem" alt="Properties">
        </div>
    @endif --}}

    <div class="hero">
        <div class="hero-caption-wrapper">
            <div class="container" style="margin-top: 10%">
                <div class="hero-caption w-100 text-center">
                    @if (!auth()->check() || !auth()->user()->hasRole('superadmin'))
                        <div class="my-5 text-center">
                            <h4 class="w-auto">
                                <a class="bg-accent text-white p-2 px-4 rounded position-relative" aria-current="page"
                                    href="{{ route('property.form') }}">
                                    Sell Your Property
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        Free
                                        <span class="visually-hidden">For 3 months</span>
                                    </span>
                                </a>
                            </h4>
                        </div>
                    @endif
                    <h6>Buy DHA verified properties through the most reliable Real Estate Platform</h6>
                </div>
                <div class="search-box m-auto">
                    <div class="hero-tabs-wrapper">
                        <ul class="nav nav-tabs">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Buy</a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">Rent</a>
                            </li> --}}
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active">
                            @include('guest.partials.search-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('guest.partials.promotion')

    @include('guest.partials.popular-search')


    <div class="latest-projects my-5 py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Properties in DHA</h2>
                <p>Discover the exceptional features of DHA properties in Pakistan's most vibrant cities</p>
            </div>
            <div class="listing-summary shadow-none text-center">
                <div class="d-flex flex-wrap justify-content-between pt-4">{{-- row --}}
                    @foreach ($propertiesByCities as $city)
                        @include('guest.partials.listing-summary')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="property-types bg-white my-5 py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Property Types in DHA</h2>
                <p>Discover an unparalleled portfolio of real estate opportunities, featuring exquisite residential plots,
                    luxurious homes, modern apartments, and premium commercial buildings.</p>
            </div>
            @empty(!$propertiesByTypes)
                <div class="types-wrapper mx-4">
                    {{-- <div class='row'>
                    <div class='col-lg-4'> --}}
                        <div class="row">
                            @php $total = 0; $plot = 0; $home = 0; $commercial = 0; @endphp
                            @foreach ($propertiesByTypes as $property)
                                @php

                                $total += $property->type_count;
                                if ($property->propertyType?->name == 'Plot') {
                                    $plot =  $property->type_count;
                                } elseif ($property->propertyType?->name == 'Home') {
                                    $home = $property->type_count;
                                } elseif ($property->propertyType?->name == 'Commercial') {
                                    $commercial = $property->type_count;
                                }

                            @endphp
                            @include('guest.partials.property-types')
                        @endforeach
                    </div>
                    {{-- </div> --}}
                    {{-- <div class='col-lg-6 align-items-center justify-content-center' id='pie-chart'></div> --}}
                    {{-- </div> --}}
                </div>
            @endempty
        </div>
    </div>

    @empty(!$newProjects)
        <div class="latest-projects my-5 py-5">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <h2>Recent Properties</h2>
                    <p>Dive into the latest DHA projects and seize your next investment opportunity today</p>
                    {{-- <div class="text-end">
                    <a href="#" class="text-accent">View All (5) Properties</a>
                </div> --}}
                </div>
                <div class="swiper featured-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($newProjects as $project)
                            @include('guest.partials.listing', ['property' => $project])
                        @endforeach
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-wrapper d-flex justify-content-end pt-5">
                        <div class="swiper-button-prev me-4"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    @endempty

    @if ($propertiesByDHA->count() > 0)
        <div class="featured-projects bg-gredient rounded-top rounded-bottom mt-5 py-5">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <h2 class="text-white">Properties By DHA</h2>
                    <p class="text-white">Experience the finest in real estate, from lavish homes to premium commercial
                        properties, all representing the height of excellence.</p>
                </div>

                <div class="swiper featured-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($propertiesByDHA as $property)
                            @include('guest.partials.listing')
                        @endforeach
                    </div>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-wrapper d-flex justify-content-end pt-5">
                    <div class="swiper-button-prev me-4"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    @endif


{{-- Testimonial/Feedback section added by Hamza Amjad --}}
    @include('guest.partials.feedback') {{-- By Asfia --}}
    @include('guest.partials.logos-slider')

@endsection

@section('page_script')
<script>
    // for the subtypes route
    window.routes = {
        subtypes: "{{ route('subtypes') }}"
    };
</script>
    <script src="{{ getAdminAsset('js/home-slider.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ getAdminAsset('js/search.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ getAdminAsset('js/main.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ getAdminAsset('js/slick-slider.js') }}?v={{ config('app.version') }}"></script>
@endsection
