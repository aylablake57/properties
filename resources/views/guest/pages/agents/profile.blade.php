@extends('guest.layouts.guest')
@section('title')
    Property Agent Detail
@endsection
@section('local-style')
    <link href="{{ getAdminAsset('css/inner.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/newagent.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/slider.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <style>
        .swiper {
            height: auto;
        }

        .swiper-slide {
            background: none;
            WIDTH: 324PX !important;
        }

        #social-box {
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-image {
            object-fit: cover !important;
        }

        .ecommerce-gallery li {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
            cursor: pointer;
        }

        .ecommerce-gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .ecommerce-gallery li:hover img {
            filter: brightness(50%);
        }

        .ecommerce-gallery li::before {
            content: "Click to view ad";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 18px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .ecommerce-gallery li:hover::before {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .ecommerce-gallery li {
                height: 200px;
            }

            .ecommerce-gallery img {
                object-fit: contain;
            }
        }
    </style>
@endsection
@section('page')
    <!-- Header Picture Section -->
    {{-- <div class="header-picture-section">
        <div class="header-picture-container">
        <img src="{{ getAdminAsset('images/banner/13.png') }}" class="img-fluid" alt="Properties">
            <div class="play-button">
                <span>&#9658;</span> <!-- Play icon (right arrow) -->
            </div>
        </div>
    </div> --}}
    <!-- section -->
    <div class="bg-white mt-5 pt-5 ad-margin-top">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-3 col-sm-5 mb-3">
                    <img src="{{ showUserImage($user) }}" alt="Agent Image" class="agent-img mb-3">
                    <div class="d-flex justify-content-between" style="margin-block: 20px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <span>
                                    <h6 class="d-inline"><i class="fa-solid fa-calendar me-2"></i>Member Since</h6>
                                    <span>{{ date('M Y', strToTime($user->created_at)) }}</span>
                                </span>
                            </div>
                            <div class="col-lg-12 pt-3">
                                <span class="location">
                                    <h6 class="d-inline"><i class="fa-solid fa-location-dot me-2"></i>Location</h6>
                                    <span>{{ $user->city?->name }}</span>
                                </span>
                            </div>
                            <div class="col-lg-12 pt-3">
                                @if ($propertiesForSale)
                                    <span class="counts">
                                        <h6 class="d-inline"><i class="fa-solid fa-list me-2"></i>Properties</h6>
                                        <span>{{ $propertiesForSale }} for Sale</span>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-12 pt-3">
                                @if ($propertiesForRent)
                                    |
                                    <span class="count">{{ $propertiesForRent }} for Rent</span>
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="profile-details py-2">
                            <div class="d-flex align-items-center">
                                <h4 class="text-capitalize me-2 mb-0">{{ $user->name }}</h4>
                                <span class="badge bg-warning text-black" style="padding-block: 5px;">
                                    @if ($user->user_type->name == 'Agency')
                                        Real Estate Agency
                                    @elseif ($user->user_type->name == 'Agent')
                                        Property Agent
                                    @else
                                        Seller
                                    @endif
                                </span>
                            </div>
                            <!-- About Yourself -->
                            @if ($user->about)
                                <div class="d-flex justify-content-between" style="margin-block: 20px;">
                                    <p style="text-align: justify; ::first-letter: 200px;">
                                        {{ $user->about }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row d-flex">
                        <div class="col-lg-5 col-sm-12  mb-3 py-2">
                            <div class="agent-card text-center">
                                <span>
                                    <h4>Contact Information</h4>
                                    <table class="table seller-detail-list-table table-borderless my-3 text-start">
                                        <tbody>
                                            <tr>
                                                <th class="pb-0">Email</th>
                                                <td class="pb-0"> {{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pb-0">Mobile</th>
                                                <td class="pb-0">
                                                    {{ $user->phone != '' ? formatPhoneNumber(SmsCellPhoneNumber($user->phone)) : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pb-0">Office</th>
                                                <td class="pb-0"> {{ $user->address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                                <!-- New Social Media Links -->
                                <div class="row">
                                    <div class="col-lg-12 d-flex justify-content-center" id="social-box">
                                        <div class="social-sidebar">
                                            @if ($user->facebook_id)
                                                <a href="{{ $user->facebook_id }}" target="_blank" aria-label="facebook">
                                                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            @if ($user->instagram)
                                                <a href="{{ $user->instagram }}" target="_blank" aria-label="instagram">
                                                    <i class="fab fa-instagram" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            @if ($user->linkedin)
                                                <a href="{{ $user->linkedin }}" target="_blank" aria-label="linkedin">
                                                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            @if ($user->youtube)
                                                <a href="{{ $user->youtube }}" target="_blank" aria-label="youtube">
                                                    <i class="fab fa-youtube" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="agent-profile-actions d-flex justify-content-center">
                                            <button class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#emailModal">
                                                <i class="fas fa-envelope" aria-hidden="true"></i> Email
                                            </button>
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#callModal-{{ $user->id }}">
                                                <i class="fas fa-phone" aria-hidden="true"></i> Call
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 mb-3 " style="background-color:white;">
                            @if ($ads->isEmpty())
                                <div class="container border d-flex justify-content-center align-items-center"
                                    style="height:100%;">
                                    <span class="text-center">Agent has not published any ads yet.</span>
                                </div>
                            @else
                                <div class="vrmedia-gallery">
                                    <ul class="ecommerce-gallery">
                                        @foreach ($ads as $ad)
                                            <li data-fancybox="gallery"
                                                data-src="{{ env('FTP_BASE_URL') . '/' . $ad->file_name }}">
                                                <img class="img-fluid thumbnail-image"
                                                    src="{{ env('FTP_BASE_URL') . '/' . $ad->file_name }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('guest.partials.call-modal')
            {{-- By Asfia --}}
            <div id="emailModal" class="modal {{ $errors->any() ? 'show' : '' }}" tabindex="-1"
                style="{{ $errors->any() ? 'display: block;' : '' }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-center">Contact {{ $pageTitle }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('guest.partials.property-details-contact-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-3">
                <div class="p-3">
                    <div class="section-title mb-5">
                        <h4 class="text-capitalize">Available Properties By {{ $user->name }} -
                            ({{ $propertiesForSale }})</h4>
                    </div>
                    <div class="swiper featured-swiper">
                        <div class="swiper-wrapper">
                            @forelse ($properties as $property)
                                @include('guest.partials.listing')
                            @empty
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6>Sorry! No results are found.</h6>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="swiper-button-wrapper d-flex justify-content-end pt-5">
                            <div class="swiper-button-prev me-4"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sold Properties Section -->
@empty(!$soldProperties)
    <div class="featured-projects bg-gredient ">
        <div class="container my-5">
            <div class="section-title mb-5">
                <h4 class="text-white">Sold Properties By {{ $user->name }} - ( {{ $soldProperties->count() }} )</h4>
            </div>
            <div class="swiper featured-swiper">
                <div class="swiper-wrapper">
                    @foreach ($soldProperties as $property)
                        @include('guest.partials.listing')
                    @endforeach
                </div>

                <div class="swiper-button-wrapper d-flex justify-content-end pt-5">
                    <div class="swiper-button-prev me-4"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
@endempty

<!-- Sales Statistics Section -->
{{-- <div class="section-title text-center mt-3 pt-5 pb-5" style="background-color: rgb(238, 238, 238);">
        <div class="container">
            <h2>Sales of Last 12 Months</h2>
            <p>Below is the detail of sales done by this agent in the last 12 months.</p>
            <div id="loader" class="text-center">
                <div class="spinner-border text-accent" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3">Loading sales data, please wait...</p>
            </div>
            <div id="salesData" class="loader-content sales-data" style="display: none;">
                <div class="sales-item">
                    <h4>Last 12 Months</h4>
                    <p class="number" id="last12MonthsValue">0</p>
                </div>
                <div class="sales-item">
                    <h4>Total Sales</h4>
                    <p class="number" id="totalSalesValue">0</p>
                </div>
                <div class="sales-item">
                    <h4>Price Range</h4>
                    <p class="number" id="priceRangeValue">0</p>
                </div>
                <div class="sales-item">
                    <h4>Average Price</h4>
                    <p class="number" id="averagePriceValue">0</p>
                </div>
            </div>
        </div>
    </div> --}}

<!-- Achievements Section -->
{{-- <div class="bg-white">
        <div class="container mt-5 mb-5 pt-5 pb-5">
            <div class="section-title text-center mb-5">
                <h2>Achievements & Awards</h2>
                <p>Here are some of the notable achievements and awards received by the agent.</p>
            </div>
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="achievement-item">
                        <i style="color: var(--accent) !important;" class="fa-solid fa-trophy fa-3x"></i>
                        <h5>Top Seller Award</h5>
                        <p>Recognized as the top-selling agent in 2023.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="achievement-item">
                        <i style="color: var(--accent) !important;" class="fa-solid fa-star fa-3x"></i>
                        <h5>Five-Star Agent</h5>
                        <p>Consistently rated 5 stars by clients.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="achievement-item">
                        <i style="color: var(--accent) !important;" class="fa-solid fa-medal fa-3x"></i>
                        <h5>Best Customer Service</h5>
                        <p>Awarded for outstanding customer service in 2022.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="achievement-item">
                        <i style="color: var(--accent) !important;" class="fa-solid fa-certificate fa-3x"></i>
                        <h5>Certification</h5>
                        <p>Certified Real Estate Professional with specialized training.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

<!-- New: Agent Team Section -->
{{-- <div class="section-title text-center pt-5 pb-5" style="background-color: rgb(238, 238, 238);">
        <div class="container">
            <h2>Meet Our Team</h2>
            <p>Get to know the dedicated professionals who make up our real estate team.</p>

            <div class="row">
                <div class="col-md-3 d-flex justify-content-center">
                    <div class="team-member-item animate__animated animate__fadeInUp text-center">
                        <img src="{{ getAdminAsset('images/agents/agentpic.jpg') }}" alt="Agent 1" class="img-fluid mb-3">
                        <h5>Zahid Khan</h5>
                        <p>Senior Real Estate Agent</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                    <div class="team-member-item animate__animated animate__fadeInUp text-center">
                        <img src="{{ getAdminAsset('images/agents/agentpic.jpg') }}" alt="Agent 2" class="img-fluid mb-3">
                        <h5>Umer Jamil</h5>
                        <p>Real Estate Consultant</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                    <div class="team-member-item animate__animated animate__fadeInUp text-center">
                        <img src="{{ getAdminAsset('images/agents/agentpic.jpg') }}" alt="Agent 3" class="img-fluid mb-3">
                        <h5>Ali Raza</h5>
                        <p>Property Manager</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                    <div class="team-member-item animate__animated animate__fadeInUp text-center">
                        <img src="{{ getAdminAsset('images/agents/agentpic.jpg') }}" alt="Agent 3" class="img-fluid mb-3">
                        <h5>Iftikhar Ahmed</h5>
                        <p>Property Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

<!-- Agent Reviews Section -->
{{-- <div class="bg-white">
        <div class="container pt-5 pb-5 justify-content-center">
            <div class="section-title text-center mb-5">
                <h2>Agent Reviews</h2>
                <p>Given Below are the reviews given by the different clients related to this agent.</p>
            </div>
            <div class="row">
                <!-- Existing Reviews Column -->
                <div class="col-lg-6 ml-4 review-column me-lg-3">
                    <div id="reviews">
                        <!-- Existing Reviews -->
                        <div class="review-item mb-3">
                            <div class="review-header">
                                <div class="reviewer-name">Umer Ayub</div>
                                <div class="review-rating">★★★★☆</div>
                            </div>
                            <div class="review-comments">
                                <p>Agent was fantastic to work with. Very professional and helpful throughout the process. Highly recommended!</p>
                            </div>
                        </div>
                        <div class="review-item mb-3">
                            <div class="review-header">
                                <div class="reviewer-name">Shahid Ali</div>
                                <div class="review-rating">★★★☆☆</div>
                            </div>
                            <div class="review-comments">
                                <p>Good service but there were some delays in communication. Overall, a decent experience.</p>
                            </div>
                        </div>
                        <div class="review-item mb-3">
                            <div class="review-header">
                                <div class="reviewer-name">Faisal Khan</div>
                                <div class="review-rating">★★☆☆☆</div>
                            </div>
                            <div class="review-comments">
                                <p>Average service. there were some delays in communication.</p>
                            </div>
                        </div>
                        <div class="review-item mb-3">
                            <div class="review-header">
                                <div class="reviewer-name">Sohail Khan</div>
                                <div class="review-rating">★★★☆☆</div>
                            </div>
                            <div class="review-comments">
                                <p>Good service. there were some delays in communication.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Review Form Column -->
                <div class="col-lg-5 review-form-column ms-lg-3">
                    <div class="review-form">
                        <h4 class="text-center">Leave a Review</h4>
                        <form class="text-left">
                            <div class="mb-3">
                                <label for="reviewerName" class="form-label">Name:</label>
                                <input type="text" id="reviewerName" name="reviewerName" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="reviewRating" class="form-label">Rating:</label>
                                <select id="reviewRating" name="reviewRating" class="form-select" required>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reviewDescription" class="form-label">Description:</label>
                                <textarea id="reviewDescription" name="reviewDescription" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-accent col-lg-3">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@section('page_script')
{{-- <script src="{{ getAdminAsset('js/slick-slider.js') }}?v={{ config('app.version') }}"></script> --}}
<script src="{{ getAdminAsset('js/home-slider.js') }}?v={{ config('app.version') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    jQuery(document).ready(function() {
        // By Asfia
        @if ($errors->any())
            var emailModal = new bootstrap.Modal($('#emailModal')[0], {
                backdrop: 'static',
                keyboard: false
            });
            emailModal.show();
        @endif

        var totalAds = {{ $totalads }};
        jQuery(".ecommerce-gallery").lightSlider({
            pager: false,
            item: 1,
            loop: false,
            thumbItem: totalAds,
            thumbMargin: 10
        });
    });
    /* document.addEventListener('DOMContentLoaded', function() {
        // Simulating a loading delay for sales data
        setTimeout(function() {
            // Hide the loader and show the sales data
            document.getElementById('loader').style.display = 'none';
            document.getElementById('salesData').style.display = 'flex';

            // Data to display
            const numbers = {
                last12Months: 10,
                totalSales: 25,
                priceRange: 2000000,
                averagePrice: 1500000
            };

            function animateNumber(id, endValue, duration) {
                const element = document.getElementById(id);
                const startValue = 0;
                const startTime = Date.now();

                function update() {
                    const elapsedTime = Date.now() - startTime;
                    const progress = Math.min(elapsedTime / duration, 1);
                    const currentValue = Math.round(startValue + (endValue - startValue) * progress);

                    // Format numbers with commas for priceRangeValue
                    element.textContent = (id === 'priceRangeValue')
                        ? currentValue.toLocaleString()
                        : currentValue.toString();

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        // Ensure final value is set correctly
                        element.textContent = (id === 'priceRangeValue')
                            ? endValue.toLocaleString()
                            : endValue.toString();
                    }
                }

                requestAnimationFrame(update);
            }

            // Animate each number with a 2-second duration
            animateNumber('last12MonthsValue', numbers.last12Months, 2000);
            animateNumber('totalSalesValue', numbers.totalSales, 2000);
            animateNumber('priceRangeValue', numbers.priceRange, 2000);
            animateNumber('averagePriceValue', numbers.averagePrice, 2000);
        }, 2000); // Simulating a 2-second loading delay
    }); */
</script>
@endsection
