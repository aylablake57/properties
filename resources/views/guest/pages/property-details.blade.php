@extends('guest.layouts.guest')
@section('title')
    Property Details
@endsection
@section('local-style')
    <link href="{{ getAdminAsset('css/inner.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/custom-property-detail-image-navbar.css') }}?v={{ config('app.version') }}"
        rel="stylesheet">
    <!-- Library: Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('page')
    <div class="container mt-5 pt-5">
        <div class="row">
            <nav id="property-nav" class="navbar d-none d-sm-none d-lg-flex flex-column px-3 col-lg-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="#media">Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#overview">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#amenities">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#trends">Trends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#price-index">Price Valuation</a>
                    </li>
                    <li class="nav-item mt-3">
                        <button class="btn btn-accent " data-bs-toggle="modal" data-bs-target="#callModal"><i
                                class="fa-solid fa-phone me-2"></i>Call</button>
                    </li>
                </ul>
            </nav>
            <div data-bs-spy="scroll" data-bs-target="#property-nav" data-bs-offset="100" data-bs-smooth-scroll="true"
                class="scrollspy-example col-lg-12" tabindex="0">
                <div class="row ad-margin-top">
                    <div class="col-sm-12 col-md-12 col-lg-8 mb-3">
                        <div class="bg-white p-3">

                            <div id="media" class="title border-bottom">
                                <h4 class="text-capitalize">{{ $property->title }}</h4>
                                <h4 class="text-accent mb-3">{{ toCurrency($property->price, 'PKR') }}</h4>
                                <p class="mb-4">{{ $property->location->name . ', ' . $property->city->name }}</p>
                            </div>

                            {{-- start of image-sale Navbar added by Hamza Amjad --}}
                            <div style="position: relative;">
                                <div class="custom-image-sale-navbar">
                                    <div class="nav">
                                        <a href="#" class="nav-image-sale-link active" data-type="image"><i
                                                class="fas fa-image"></i> <span>Image</span></a>
                                        <a href="#" class="nav-image-sale-link" data-type="video"><i
                                                class="fas fa-video"></i> <span>Video</span></a>
                                        <a href="#" class="nav-image-sale-link" data-type="view-map"><i
                                                class="fas fa-map"></i> <span>Map</span></a>
                                    </div>
                                </div>

                                <!-- Swiper for Images  -->
                                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                    class="swiper mySwiper2">
                                    <div class="swiper-wrapper">
                                        @if ($property->featured_image)
                                            <div class="swiper-slide">
                                                <img src="{{ env('FTP_BASE_URL') . '/' . $property->featured_image }}"
                                                    alt="Properties" />
                                            </div>
                                        @elseif ($property->media->isEmpty())
                                            <div class="swiper-slide">
                                                <p class="text-danger">Image not available</p>
                                            </div>
                                        @endif
                                        @if ($property->media->isNotEmpty())
                                            @foreach ($property->media as $media)
                                                <div class="swiper-slide">
                                                    <img src="{{ env('FTP_BASE_URL') . '/' . $media->file_path }}"
                                                        alt="Properties" />
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>

                                <!-- Swiper for Videos  -->
                                <div class="swiper swiper-video">
                                    <div class="swiper-wrapper">
                                        @php
                                            $embedUrl =
                                                $property->video_link != '' ? getEmbedUrl($property->video_link) : '';
                                        @endphp
                                        @if ($embedUrl != '')
                                            <div class="swiper-slide">
                                                <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen
                                                    style="width: inherit; height: inherit;"></iframe>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <p class="text-danger">Video not available</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>

                                <!-- Swiper for Map  -->
                                <div class="swiper swiper-map">
                                    <div class="swiper-wrapper">
                                        @if ($property->lat && $property->lng)
                                            <div class="swiper-slide">
                                                <div id="view-map" data-lat="{{ $property->lat }}"
                                                    data-lng="{{ $property->lng }}"></div>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <p class="text-danger">Map not available</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="size mt-4 border-bottom">
                                <p>{{ $property->area_size }} {{ $property->area_unit->name }}</p>
                            </div>

                            <div id="overview" class="py-3">
                                <h4>Overview</h4>
                                <h6>Details</h6>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Type</td>
                                                <td class="text-capitalize">{{ $property->subtype->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td class="text-capitalize">{{ toCurrency($property->price, 'PKR') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Location</td>
                                                <td class="text-capitalize">{{ $property->location->name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Area</td>
                                                <td class="text-capitalize">{{ $property->area_size }}
                                                    {{ $property->area_unit->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Purpose</td>
                                                <td class="text-capitalize">{{ $property->purpose }}</td>
                                            </tr>
                                            <tr>
                                                <td>Added</td>
                                                <td class="text-capitalize">{{ $property->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-4 border-bottom">
                                    <h6>Description</h6>
                                    <p>{{ $property->description }}</p>
                                </div>

                            </div>

                            <div id="amenities" class="py-3">
                                @if ($amenities)
                                    <h4>Amenities</h4>
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
                                                                <label class="form-check-label"
                                                                    for="{{ $key . '-' . $data['id'] }}">
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
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div id="seller" class="bg-white p-3 mb-4">
                            <h4>Seller Details</h4>
                            <ul class="ps-0 mb-0" style="list-style: none;">
                                @if ($property?->user?->user_type == 'admin')
                                    <li><i class="fa-solid fa-circle-check text-success"></i> Registered with DHA</li>
                                @endif
                                @if ($property?->user?->is_otp_verified)
                                    @if ($property?->user?->otp_verified_via == 'sms')
                                        <li><i class="fa-solid fa-circle-check text-success"></i> Seller's Phone is
                                            verified</li>
                                    @endif
                                    @if ($property?->user?->otp_verified_via == 'email')
                                        <li><i class="fa-solid fa-circle-check text-success"></i> Seller's Email is
                                            verified</li>
                                    @endif
                                @endif
                            </ul>
                            <table class="table seller-detail-list-table table-borderless my-3 text-start">
                                <tr>
                                    <th>Name</th>
                                    <td class="text-capitalize">{{ $property?->user?->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $property->email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td> {{ formatPhoneNumber($property->phone) }}</td>
                                </tr>
                                @isset($property->landline)
                                    <tr>
                                        <th>Landline</th>
                                        <td> {{ $property->landline }}</td>
                                    </tr>
                                @endisset
                            </table>
                            <div class="d-flex g-2">
                                <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#callModal"><i
                                        class="fa-solid fa-phone me-2"></i>Call</button>
                                <!-- View Profile Button added by Hamza Amjad -->
                                <a href="{{ route('agents.agents-profile', $property->user->id) }}"
                                    class="btn btn-accent ms-1">
                                    <i class="fas fa-user me-2"></i> View Profile
                                </a>
                            </div>
                        </div>
                        <div class="bg-white p-3 ">
                            <div class="contact-container ">
                                @include('guest.partials.property-details-contact-form')
                            </div>
                        </div>
                        <!-- New Properties Summary Box Added by Hamza Amjad -->
                        <div class="properties-summary-card bg-dark text-white p-4 shadow-sm  mt-4">
                            <!-- Dynamic data by Asfia Aiman Starts-->
                            <h4 class="mb-4 text-white text-capitalize">{{ $property?->user?->name }}'s Profile</h4>
                            <div class="p-3 rounded properties-summary-highlight">
                                <h6 class="text-uppercase align-items-center text-accent d-flex justify-content-between">
                                    Properties Added by User <span
                                        class="badge bg-accent text-dark rounded-pill px-3 py-2">{{ $total_properties }}</span>
                                </h6>
                                <ul class="list-unstyled mt-3">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span>Active:</span>
                                        <span
                                            class="badge bg-accent text-dark rounded-pill px-3 py-2">{{ $active_properties }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2">
                                        <span>Sold:</span>
                                        <span
                                            class="badge bg-a6a6a6 text-dark rounded-pill px-3 py-2">{{ $sold_properties }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Inactive:</span>
                                        <span
                                            class="badge bg-light text-dark rounded-pill px-3 py-2">{{ $inactive_properties }}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dynamic data by Asfia Aiman Ends-->
                        </div>
                    </div>
                </div>
                {{-- Swapping done by Hamza Amajad --}}
                <div id="trends" class="bg-white p-3 mb-4">
                    @include ('guest.partials.trends')
                </div>
                <div id="price-index" class="bg-white p-3 border-bottom">
                    @include ('guest.partials.price-index')
                </div>
            </div>
        </div>
    </div>
    {{-- Replace the anchor tag with span, adding Copy, Paste functionality. Done by Hamza Amjad --}}
    <div id="callModal" class="modal fade" tabindex="-1" aria-labelledby="callModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="callModalLabel">Contact Us</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h6 class="text-capitalize mb-2">{{ $property?->user?->name }}</h6>
                        <p class="text-muted mb-4">{{ $property?->user?->user_type->name }}</p>
                        <div class="d-flex flex-column align-items-stretch">
                            <div class="d-flex align-items-center position-relative">
                                <i class="fa-solid fa-mobile-screen fa-lg me-2 text-mute"></i>
                                <div class="flex-grow-1">
                                    <span class="d-block text-muted">Mobile</span>
                                    <p id="mobileNumber" class="mb-0">{{ $property->phone }}</p>
                                </div>
                                <span class="modal-copy-btn ms-3" onclick="copyText('mobileNumber', this)">
                                    <i class="fa-regular fa-copy fa-copy-btn"></i>Copy
                                </span>
                                <div class="call-modal-notification" id="mobileNumberNotification">Copied</div>
                            </div>
                            @isset($property->landline)
                                <div class="d-flex align-items-center position-relative mt-3">
                                    <i class="fa-solid fa-phone fa-lg me-2 text-mute"></i>
                                    <div class="flex-grow-1">
                                        <span class="d-block text-muted">Landline</span>
                                        <p id="landline" class="mb-0">{{ $property->landline }}</p>
                                    </div>
                                    <span class="modal-copy-btn ms-3" onclick="copyText('landline', this)">
                                        <i class="fa-regular fa-copy fa-copy-btn"></i>Copy
                                    </span>
                                    <div class="call-modal-notification" id="landlineNotification">Copied</div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script> --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // window.addEventListener('scroll', function() {
        //     if (window.pageYOffset > 1500) {
        //         $('#property-nav').attr('style' , 'position:absolute;bottom:-900px;');
        //     } else {
        //         $('#property-nav').attr('style' , '');
        //     }
        // });

        // Scroll smooth added by Hamza Amjad
        /* $(window).on('scroll', function() {
            var scrollPos = $(document).scrollTop();
            var sections = ['#media', '#overview', '#amenities', '#trends', '#price-index'];

            sections.forEach(function(section) {
                var refElement = $(section);
                var navLink = $('#property-nav a[href="' + section + '"]');

                if (refElement.length && refElement.offset().top <= scrollPos + 100 && refElement.offset().top + refElement.height() > scrollPos + 100) {
                    $('#property-nav ul li a').removeClass('active');
                    navLink.addClass('active');
                } else {
                    navLink.removeClass('active');
                }
            });
        }); */

        $(document).ready(function() {
            $('body').scrollspy({
                target: '#property-nav',
                offset: 100
            });
        });

        /* document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a.nav-link').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        }); */

        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });

        let currentlyDisplayedRow = null;

        function showChart(index, search_string) {
            const rowId = `chart_row_${index}`;
            const canvasId = `view_chart_${index}`;

            if (currentlyDisplayedRow && currentlyDisplayedRow !== rowId) {
                document.getElementById(currentlyDisplayedRow).classList.add('d-none');
            }

            document.getElementById(rowId).classList.remove('d-none');
            currentlyDisplayedRow = rowId;

            $.ajax({
                url: "{{ url('trend') }}",
                type: 'GET',
                data: {
                    city: search_string
                },
                dataType: 'json',
                success: function(response) {
                    const xValues = response.xValues;
                    const yValues = response.yValues;

                    // Render the chart
                    if (!document.getElementById(canvasId).dataset.chartRendered) {
                        new Chart(canvasId, {
                            type: "line",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    label: search_string,
                                    backgroundColor: "black",
                                    data: yValues,
                                    fill: false, // Disable fill
                                    tension: 0.1 // Set tension for curved lines
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Months' // X-axis label
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Searches' // Y-axis label
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    },
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        color: '#6d6d6d',
                                        font: {
                                            weight: 'bold',
                                            size: 10,
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Search Trends For ' + search_string
                                }
                            }
                        });
                        document.getElementById(canvasId).dataset.chartRendered =
                        true; // Mark chart as rendered
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching chart data:', status, error);
                }
            });
        }

        // call model js code added by Hamza Amjad
        function copyText(elementId, buttonElement) {
            const textElement = document.getElementById(elementId);
            const text = textElement.textContent.trim();

            // Copy text to clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification(buttonElement);
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                });
            } else {
                // Fallback for browsers that do not support Clipboard API
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    showNotification(buttonElement);
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
                document.body.removeChild(textArea);
            }
        }

        function showNotification(buttonElement) {
            const notification = buttonElement.nextElementSibling;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 2000);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewMap = document.getElementById('view-map');
            if (viewMap) {
                // Initialize map with default view
                var map = L.map('view-map').setView([34.054808414624716, 73.09627040783006],
                5); // Default view of Pakistan

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var marker = L.marker([34.054808414624716, 73.09627040783006]).addTo(
                map); // Default marker position
                var circle = L.circle([34.054808414624716, 73.09627040783006], {
                    color: 'blue',
                    fillColor: '#30f',
                    fillOpacity: 0.2,
                    radius: 100
                }).addTo(map);

                // Get latitude and longitude from data attributes
                var lat = parseFloat(document.getElementById('view-map').getAttribute('data-lat'));
                var lng = parseFloat(document.getElementById('view-map').getAttribute('data-lng'));

                if (!isNaN(lat) && !isNaN(lng)) {
                    map.setView([lat, lng], 13); // Zoom to the new location
                    marker.setLatLng([lat, lng]);
                    circle.setLatLng([lat, lng]);
                    $("#view-map").removeClass('d-none');
                } else {
                    toastr.error("Latitude and longitude values are missing or invalid.");
                }
            }
        });
    </script>
@endsection

@section('page_script')
    <script src="{{ getAdminAsset('js/message.js') }}?v={{ config('app.version') }}"></script>
@endsection
