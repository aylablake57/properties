@extends('guest.layouts.guest')
@section('title') Property Agent Detail @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/newagent.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{getAdminAsset('css/slider.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <style>
        .swiper {
            height: auto;
        }

        .swiper-slide {
            background: none;
            WIDTH: 324PX !important;
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
    <div class="bg-white mt-5 pt-5 ad-margin-top">
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-3 mb-3 text-center">
                    <img src="{{ showUserImage($user) }}" alt="Agent Image" class="agent-img mb-3">
                </div>
                <div class="col-sm-5 mb-3 py-2">
                    <div class="profile-details py-2">
                        <h4 class="text-capitalize">{{ $user->name }}</h4>
                        <p>
                            @if ($user->user_type->name == 'Agency')
                                Real Estate Agency
                            @elseif ($user->user_type->name == 'Agent')
                                Property Agent
                            @else
                               Seller
                            @endif
                        </p>
                        <div class="d-flex justify-content-between">
                            <span>
                                <h6><i class="fa-solid fa-calendar me-3"></i>Member Since</h6>
                                <p>{{ date('M Y' , strToTime($user->created_at)) }}</p>
                            </span>

                            <span class="location">
                                <h6><i class="fa-solid fa-location-dot me-3"></i>Location</h6>
                                
                                {{ $user->city?->name }}
                            </span>

                            @if ($propertiesForSale)
                            <span class="counts">
                                <h6><i class="fa-solid fa-list me-3"></i>Properties</h6>
                                {{ $propertiesForSale }} for Sale
                            </span>
                            @endif

                            @if ($propertiesForRent)
                            |
                            <span class="count">{{ $propertiesForRent }} for Rent</span>
                            @endif
                            <br>
                        </div>
                        <div class="agent-profile-actions">
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#emailModal18">
                                <i class="fas fa-envelope" aria-hidden="true"></i> Email
                            </button>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#callModal-18">
                                <i class="fas fa-phone" aria-hidden="true"></i> Call
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 py-2">
                    <div class="agent-card text-center">
                        <span>
                            <h4>Contact Information</h4>
                            <table class="table seller-detail-list-table table-borderless my-3 text-start">
                                <tbody>
                                <tr>
                                    <th class="pb-0">Email</th><td class="pb-0"> {{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th class="pb-0">Mobile</th><td class="pb-0"> {{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <th class="pb-0">Office</th><td class="pb-0"> {{ $user->address }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </span>
                        <!-- New Social Media Links -->
                        <div class="social-sidebar">
                            <a href="https://www.facebook.com/dha360pk/" target="_blank" aria-label="facebook">
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.instagram.com/dha360.pk?igsh=MW1oanptdTJrdnJ6aw==" target="_blank" aria-label="facebook">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/dha360/about/?viewAsMember=true" target="_blank" aria-label="facebook">
                                <i class="fab fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.youtube.com/@DHA360-o2d" target="_blank" aria-label="facebook">
                                <i class="fab fa-youtube" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('guest.partials.call-modal')
            <div id="emailModal{{ $user->id }}" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-center">Contact {{ $pageTitle }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        {{-- <div class="row">
            <div class="col-sm-12 mb-3">
                <div class="p-3"> --}}
                    <div class="section-title mb-5">
                        <h4 class="text-capitalize">Available Properties By {{ $user->name }} - ( {{ $propertiesForSale }} )</h4>
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

<!-- Agent Reviews Section -->
<div class="bg-white">
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
                            <div class="review-rating">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                        </div>
                        <div class="review-comments">
                            <p>Agent was fantastic to work with. Very professional and helpful throughout the process. Highly recommended!</p>
                        </div>
                    </div>
                    <div class="review-item mb-3">
                        <div class="review-header">
                            <div class="reviewer-name">Shahid Ali</div>
                            <div class="review-rating">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="review-comments">
                            <p>Good service but there were some delays in communication. Overall, a decent experience.</p>
                        </div>
                    </div>
                    <div class="review-item mb-3">
                        <div class="review-header">
                            <div class="reviewer-name">Faisal Khan</div>
                            <div class="review-rating">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="review-comments">
                            <p>Average service. there were some delays in communication.</p>
                        </div>
                    </div>
                    <div class="review-item mb-3">
                        <div class="review-header">
                            <div class="reviewer-name">Sohail Khan</div>
                            <div class="review-rating">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="review-comments">
                            <p>Poor service. Not Satisfied!</p>
                        </div>
                    </div>
                </div>
                <p class="mt-3">Loading sales data, please wait...</p>
            </div>
            <!-- Review Form Column -->
            <div class="col-lg-5 review-form-column ms-lg-3">
                <div class="review-form">
                    <h4 class="text-center">Leave a Review</h4>
                    <form class="text-left" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Your Name <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{old('name')}}" required>
                            @error('name')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email">Your Email <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required>
                            @error('email')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating:</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="reviewRating" value="5" required>
                                <label for="star5" class="star">&#9733;</label>
                                <input type="radio" id="star4" name="reviewRating" value="4">
                                <label for="star4" class="star">&#9733;</label>
                                <input type="radio" id="star3" name="reviewRating" value="3">
                                <label for="star3" class="star">&#9733;</label>
                                <input type="radio" id="star2" name="reviewRating" value="2">
                                <label for="star2" class="star">&#9733;</label>
                                <input type="radio" id="star1" name="reviewRating" value="1">
                                <label for="star1" class="star">&#9733;</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message">Your Feedback <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <x-textarea 
                                name="message" 
                                id="message" 
                                placeholder="Message" 
                                maxlength="1500" 
                                required="true"
                                value="{{old('message')}}"
                            />
                        </div>
                        <button type="submit" class="btn btn-accent col-lg-3">Submit Review</button>
                    </form>
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
    <script src="{{getAdminAsset('js/home-slider.js')}}?v={{ config('app.version') }}"></script>
    <script>
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

                requestAnimationFrame(update);
            }

            // Animate each number with a 2-second duration
            animateNumber('last12MonthsValue', numbers.last12Months, 2000);
            animateNumber('totalSalesValue', numbers.totalSales, 2000);
            animateNumber('priceRangeValue', numbers.priceRange, 2000);
            animateNumber('averagePriceValue', numbers.averagePrice, 2000);
        }, 2000); // Simulating a 2-second loading delay
    });
    </script>

    <script>
    // toggle button, switch with city dropdown, and agent name on click of `Location` and `Agent` added by Hamza Amjad
    document.getElementById('toggleNameSearchBox').addEventListener('click', function() {
        document.getElementById('agentNameSearchBox').style.display = 'block';
        document.getElementById('cityDropdownBox').style.display = 'none';
        
        this.classList.add('active');
        document.getElementById('toggleCityDropdown').classList.remove('active');
    });

    document.getElementById('toggleCityDropdown').addEventListener('click', function() {
        document.getElementById('agentNameSearchBox').style.display = 'none';
        document.getElementById('cityDropdownBox').style.display = 'block';
        
        this.classList.add('active');
        document.getElementById('toggleNameSearchBox').classList.remove('active');
    });
    // view button script added by Hamza Amjad
    document.addEventListener("DOMContentLoaded", function() {
    const vendorBoxes = document.querySelectorAll("#verifiedAgents .vendor-boxs");
    const agentBoxes = document.querySelectorAll("#agents .agent-box");
    const viewMoreBtn = document.getElementById("viewMoreBtn");
    const agentBtn = document.getElementById("view-more-agent");
    const pagination = document.querySelector('.pagination-container');

    vendorBoxes.forEach((box, index) => {
        if (index < 8) {
            box.style.display = "block";
        }
    });
    agentBoxes.forEach((box, index) => {
        if (index < 5) {
            box.style.display = "block";
        }
    });

    if (pagination) {
        pagination.style.display = "none";
    }

    if (vendorBoxes.length > 8) {
        viewMoreBtn.classList.remove("d-none");
    }
    if (agentBoxes.length > 5) {
        agentBtn.classList.remove("d-none");
    }

    viewMoreBtn.addEventListener("click", function() {
        if (viewMoreBtn.innerText === "View More") {
            vendorBoxes.forEach(box => {
                box.style.display = "block";
            });
            if (pagination) {
                pagination.style.display = "block";
            }
            viewMoreBtn.innerText = "Hide";
        } else {
            vendorBoxes.forEach((box, index) => {
                if (index >= 8) {
                    box.style.display = "none";
                }
            });
            if (pagination) {
                pagination.style.display = "none";
            }
            viewMoreBtn.innerText = "View More";
        }
    });
    agentBtn.addEventListener("click", function() {
        if (agentBtn.innerText === "View more") {
            agentBoxes.forEach(box => {
                box.style.display = "block";
            });
            if (pagination) {
                pagination.style.display = "block";
            }
            agentBtn.innerText = "Hide";
        } else {
            agentBoxes.forEach((box, index) => {
                if (index >= 8) {
                    box.style.display = "none";
                }
            });
            if (pagination) {
                pagination.style.display = "none";
            }
            agentBtn.innerText = "View More";
        }
    });
});
</script>

@endsection
