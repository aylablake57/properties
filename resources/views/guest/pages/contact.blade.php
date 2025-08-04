@extends('guest.layouts.guest')
@section('title')
    Search
@endsection
@section('local-style')
    <link href="{{ getAdminAsset('css/inner.css') }}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
    {{-- header added by Hamza Amjad --}}
    <div class="container-fluid bg-white mt-5 pt-5 position-relative container-part-about border-bottom-1">
        <!-- Particle Animation Container -->
        <div id="particles-js"></div>

        <!-- Content Layer on top of Particles -->
        <div class="row">
            <div class="col-sm-12 d-flex flex-column justify-content-center align-items-center position-relative">
                <h2 class="section-title text-dark mt-4">Contact Us</h2>
                <div class="position-relative">
                    <img src="{{ getAdminAsset('images/hero-image-removebg-preview.png') }}" alt="contact Us Image" class="img-fluid contact-us-image">
                </div>
            </div>
        </div>
    </div>
    <div class="main mb-5" id="sectionContact">
        <div class="container pt-5">
            <div class="row ad-margin-top">
                <!-- Left side: Contact Us Form (col-8) -->
                <div class="col-sm-12 col-lg-9" >
                    <div class="bg-white py-2 px-4 " id="contact-form">
                        <div class="section-title my-5">
                            <h4>Get in Touch with Us</h4>
                        </div>
                        <div class="tab-content p-0" style="float: none;">
                            @include('guest.partials.contact-form')
                        </div>
                    </div>
                </div>

                <!-- Right side: How To Find Us (col-4) -->
                <div class="col-sm-12 col-lg-3 mt-4 mt-lg-0 ">
                    <div class="bg-white p-4 mb-3">
                        <h4 class="my-3">How To Find Us</h4>
                        <div class="d-flex text-dark align-items-start mb-2">
                            <i class="fas fa-phone pe-2"></i>
                            <a href="tel:%2B92+51+111+DHA360">+92 51 111 DHA360</a>
                        </div>
                        <div class="d-flex text-dark align-items-start mb-2">
                            <i class="fas fa-envelope pe-2"></i>
                            <a href="mailto:properties@dha360.pk">properties@dha360.pk</a>
                        </div>
                        <div class="d-flex text-dark align-items-start ">
                            <i class="fas fa-building pe-2"></i>
                            DHA360 Head Office, Avenue Mall, DHA Phase-1, Islamabad
                        </div>
                    </div>
                    <div class="bg-white p-4 mb-3">
                        <h4 class="mt-3">Opening Hours</h4>
                        <table class=" mt-2 table">
                            <tbody>
                                <tr>
                                <td>Monday - Friday</td>
                                <td>09:00 - 16:00</td>
                                </tr>
                                {{-- <tr>
                                <td>Saturday</td>
                                <td>10:00 - 14:00</td>
                                </tr> --}}
                                <tr>
                                <td>Saturday - Sunday</td>
                                <td>Closed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main mb-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mb-3 ">
                    <div class="bg-white py-2 px-4 mb-3">
                        <div class="section-title my-5">
                            <h4>DHA 360</h4>
                            <p>Welcome to DHA 360, your all-encompassing resource for everything related to Defence Housing
                                Authority (DHA) living.</p>
                            <p><strong>Explore DHA</strong><br>
                                Discover the full spectrum of residential options available within DHA communities. From
                                modern apartments to spacious villas, find the perfect home to suit your lifestyle.
                                <br>
                                <strong>Amenities & Facilities</strong><br>
                                Experience the complete range of amenities and facilities offered within DHA. From
                                recreational spaces to educational institutions, DHA provides everything you need for a
                                fulfilling lifestyle.360-Degree ViewsTake a virtual tour of DHA properties with our
                                immersive
                                <br>
                                <strong>360-degree views.</strong><br>
                                Explore homes, parks, and community spaces from every angle before making your decision.
                                <br>
                                <strong>Investment Opportunities</strong><br>
                                Explore investment opportunities within DHA communities. Whether you’re looking for
                                long-term rental income or property appreciation, DHA offers a secure investment
                                environment.
                                <br>
                                <strong>Prime Locations</strong><br>
                                Learn about the prime locations of DHA communities. With convenient access to major
                                thoroughfares and urban amenities, DHA properties offer the perfect blend of accessibility
                                and tranquility.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 mb-3 ">
                    <div class="bg-white p-3 mb-3 ">
                        @include ('guest.partials.latest-properties')
                    </div>
                    {{-- <div class="bg-white p-4 mb-3">
                    <h4 class="widget-title ">Our Listings</h4>
                    <div class="d-flex justify-content-between border-bottom">
                        <p>BUY</p>
                        <span>(64)</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <p>SELL</p>
                        <span>(8)</span>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
<script src="{{getAdminAsset('js/message.js')}}?v={{ config('app.version') }}"></script>
<script src="{{getAdminAsset('js/particle.js')}}?v={{ config('app.version') }}"></script>
@endsection