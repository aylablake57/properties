@extends('guest.layouts.guest')
@section('title') Advertisement @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{getAdminAsset('css/advertise.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
		<!-- Done by Hamza Amjad -->
		<!-- Start Header -->
		<div class="adv-header-container">
			<div class="overlay"></div>
			<img src="{{ asset('assets/images/Untitled-design.jpg') }}" alt="Properties" class="adv-header-image">
			<div class="adv-header-content container ad-margin-top mb-5">
				<div class="row justify-content-center mt-5">
					<div class="col-md-10 col-lg-8 mt-5">
						<h2 class="mb-3 text-center">Advertise on<b> DHA36O</b></h2>
						<p class="adv-header-subtitle text-center">Book the premium spots on dha360 to advertise your brand. It will help your business to boosts its visibility, attracting more visitors and potential customers who might not have discovered it otherwise!</p>
					</div>
				</div>
			</div>
			<!-- <div class="scroll-indicator">
				<span></span>
			</div> -->
		</div>
		<!-- End Header -->

	<!-- Done by Hamza Amjad -->
	<!-- Start Why Advertise with Us -->
	<section class="why-advertise text-center py-5">
	<div class="container">
		<h2 class="mb-5 section-title">Why Advertise with Us</h2>
		<div class="row g-3">
			<div class="col-md-6 col-lg-3">
				<div class="why-advertise-item">
					<div class="icon-container">
						<i class="fa-solid fa-chart-bar fa-3x mb-2"></i>
					</div>
					<h4>Detailed Analytics</h4>
					<p>Track your ad's performance in real-time.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-advertise-item">
					<div class="icon-container">
						<i class="fa-solid fa-bullseye fa-3x mb-2"></i>
					</div>
					<h4>Targeted Audience</h4>
					<p>Connect with the right buyers and sellers.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-advertise-item">
					<div class="icon-container">
						<i class="fa-solid fa-eye fa-3x mb-2"></i>
					</div>
					<h4>High Visibility</h4>
					<p>Reach a broad audience with our platform.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-advertise-item">
					<div class="icon-container">
						<i class="fa-solid fa-dollar-sign fa-3x mb-2"></i>
					</div>
					<h4>Cost-Effective Plans</h4>
					<p>Get the best ROI with our flexible packages.</p>
				</div>
			</div>
		</div>
	</div>
	</section>
	<!-- End Why Advertise with Us -->

    <!-- Advertisement Main -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3">
                <nav id="ads-nav" class="navbar d-none d-sm-none d-lg-flex flex-column px-3 mb-3">
                    <ul class="nav nav-pills">
                        <li class="nav-item text-left">
                            <a class="nav-link active" href="#sellers">Packages For Sellers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#agents">Packages For Property Agents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#amenities">Packages For Real Estate Agencies</a>
                        </li>
                        {{--
                        <li class="nav-item mt-3">
                            <button class="btn btn-accent "><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Call</button>
                        </li> --}}
                    </ul>
                </nav>

				<div id="ads-col" class="bg-white border-rounded my-3 p-3 pt-4">
					<h3 class="mb-4">Why Advertise With <b class="text-accent">DHA360</b>?</h3>

					<div class="wrapper">
						<div class="d-flex justify-content-start">
							<img src="{{ getAdminAsset('images/icons/chart.png') }}" alt="Satisfied Client">
							<h2 class="pt-3">Satisfied Client</h2>
						</div>
						<p>95% of our customers are satisfied with our service, and more than 80% would recommend us.</p>
					</div>

					<div class="wrapper">
						<div class="d-flex justify-content-start">
							<img src="{{ getAdminAsset('images/icons/analysis.png') }}" alt="Ad image">
							<h2 class="pt-3">Ad image</h2>
						</div>
						<p>Get unlimited insights with our Property Reports and Data Analysis Tools.</p>
					</div>

					<div class="wrapper">
						<div class="d-flex justify-content-start">
							<img src="{{ getAdminAsset('images/icons/pricing.png') }}" alt="Affordable Packages">
							<h2 class="pt-3">Affordable Packages</h2>
						</div>
						<p>A variety of packages are available to suit your needs.</p>
					</div>
            	</div>
			</div>
            <div class="col-lg-9">
				{{-- Counter + scrolling text added by hazma amjad --}}
				<div class="ad-countdown-container">
					<div class="ad-countdown" id="ad-countdown">
						<p class="text-color-grey">
							<span id="days">00</span>D :
							<span id="hours">00</span>h :
							<span id="minutes">00</span>m :
							<span id="seconds">00</span>s
						</p>
					</div>
				</div>
				<div class="scrolling-text-container">
					<hr class="divider-top">
					<div class="scrolling-text">
						<p class="text-white">Packages are <span class="free-span p-1 rounded">Free</span> from <strong>September 1, 2024</strong> to <strong>October 31, 2024</strong></p>
					</div>
					<hr class="divider-bottom">
				</div>
                <div class="sub-title">
                    <h4>Packages For Sellers</h4>
                </div>
                <hr>

                <div id="sellers" class="row g-3">
                    @foreach($sellerPackages as $package)
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-6 col-xxl-3">
                        <div class="card">
                          {!! $package->icon !!}
                            <div class="card-body">
                                <h5 class="mb-3">{{ $package->name }}</h5>
                                <p class="card-text">{{ $package->description }}</p>
								{{-- badge line through added by Hamza Amjad --}}
                                <div class="card-price">
									<span class="badge badge-free">Free</span>
									<span class="old-price">{{ toCurrency($package->price , 'PKR')}} / month</span>
								</div>

                                <a href="{{ auth()->check() && !auth()->user()->hasRole('superadmin') ? route('login') : 'javascript:;' }}" class="btn btn-accent w-100 fs-6">Buy Now</a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

				<div class="sub-title mt-5">
                    <h4>Packages For Property Agents</h4>
                </div>
                <hr>
				<!-- Done by Hamza Amjad -->
				<!-- make or chnage some elements or add or remove some animations -->
				<div id="agents" class="row g-3">
					@foreach($agentsPackages as $package)
					<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
						<div class="plan-card pricing-table {{ $package->name === 'Business Package' ? 'premium-plan' : '' }}">
							<div class="icon-containers {{ $package->name === 'Business Package' ? 'animated-icons' : '' }}"></div>
							<h4 class="card-header {{ $package->name === 'Business Package' ? 'text-center' : 'text-center text-white bg-accent text-custom-color' }}">
								{{ $package->name }}
							</h4>
							<div class="p-3">
								{{-- badge line through added by Hamza Amjad --}}
								<div class="plan-price-container">
									<span class="badge pa-badge-free">Free</span>
									<p><span class="plan-price">{{ toCurrency($package->price, 'PKR') }} / month</span></p>
								</div>
								<div class="plan-desc">
									<p>What’s included</p>
									{!! $package->description !!}
								</div>
								{{-- package button alignment in center set by Hamza Amjad --}}
								<div class="d-flex justify-content-center">
                                    <a href="{{ auth()->user() && !auth()->user()->hasRole('superadmin') ? route('login') : 'javascript:;' }}"
                                        class="btn btn-accent w-100 fs-6"
                                        {{ auth()->user() && !auth()->user()->hasRole('superadmin') ? 'disabled' : '' }}>
                                        Buy Now
                                     </a>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
        </div>
			   <!-- Ads placement section by Asim / Follows previously created ads structure by Hamza-->
		<div class="container-fluid pt-5 mt-0 mt-md-5 pb-5 " >
            <div class="row g-5 " >
                <div class="col-lg-3 col-md-3 ads-left-side border-end">
					<h3 class="mb-4">Discover our advertisement <b class="text-accent">Placements</b></h3>
                    <div class="list-group pt-3" id="adsTabs" role="tablist">
                        <a class="ads-tab pb-3 list-group-item list-group-item-action active animate__animated animate__fadeInLeft" id="tabOne" data-bs-toggle="list" href="#collapseOne" role="tab" aria-controls="collapseOne">Leaderboard</a>
                        <a class="ads-tab pb-3 list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabTwo" data-bs-toggle="list" href="#collapseTwo" role="tab" aria-controls="collapseTwo">Site Wide Right Banner</a>
                        <a class="ads-tab pb-3 list-group-item list-group-item-action animate__animated animate__fadeInLeft" id="tabThree" data-bs-toggle="list" href="#collapseThree" role="tab" aria-controls="collapseThree">Splash Banner</a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 ads-right-side">
                    <div class="tab-content ads-right-side animate__animated animate__fadeInRight" id="adsTabsContent">
                        <div class="tab-pane fade show active" id="collapseOne" role="tabpanel" aria-labelledby="tabOne">
                            <div class="row">
                                <div class="col-lg-5">
								<h4 class='pb-3 ad-right-title'>Leaderboard</h4>
                                    <ol>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Placement:</strong> Top header of the site.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Available Spots:</strong> 2 spots.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Main Advantage:</strong>
										<ul class="pt-2">
											<li>Competitive advantage.</li>
											<li>Excellent brand awareness and recall.</li>
											<li>Ad appears on individual pages of other properties and developments.</li>
										</ol>
									</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Banner size:</strong> 728W x 90H pixels.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-7 ads-img-box">
									<img  class='img-fluid shadow-lg' src="{{ asset('assets/images/dummy-ads/leaderboard_ad_placement.png') }}" alt="Ad image" >
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseTwo" role="tabpanel" aria-labelledby="tabTwo">
                        <div class="row">
                                <div class="col-lg-5">
								<h4 class='pb-3 ad-right-title'>Site Wide Right Banner</h4>
                                    <ol>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Placement:</strong> Right vertical panel.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Available Spots:</strong> 15 spots.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Main Advantage:</strong>
										<ul class="pt-2">
											<li>Excellent brand awareness and branding.</li>
										</ul>
									</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Banner size:</strong> 140W x 140H pixels.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-7 ads-img-box">
								<img  class='img-fluid' src="{{ asset('assets/images/dummy-ads/rightbanner_ad.png') }}" alt="Ad image" >
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseThree" role="tabpanel" aria-labelledby="tabThree">
                        <div class="row">
                                <div class="col-lg-5">
								<h4 class='pb-3 ad-right-title'>Splash Banner</h4>
                                    <ol>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Placement:</strong> Appears in front of all landing pages when site opens and has to be closed for further browsing.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Available Spots:</strong> 1 spot.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Main Advantage:</strong>
											 <ul class="pt-2">
												<li>Advertisement cannot be ignored.</li>
												<li>No competition (ONLY ONE SPOT).</li>
												<li>Guaranteed observation by all visitors.</li>
												<li>Maximum brand awareness, recognition & recall.</li>
						 					</ul>
										 </li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Banner size:</strong> Not specified.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-7 ads-img-box">
								<img  class='img-fluid' src="{{ asset('assets/images/dummy-ads/splash_banner_ad.png') }}" alt="Ad image" >
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="collapseFour" role="tabpanel" aria-labelledby="tabFour">
                        <div class="row">
                                <div class="col-lg-5">
								<h4 class='pb-3 ad-right-title'>Middle Banner Home</h4>
                                    <ol>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Placement:</strong> In the center of home page and other main tab home pages which include Homes, Plots, Commercial, Rentals, Wanted, Agents and Developments.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Available Spots:</strong> 3 spots.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Main Advantage:</strong> Excellent brand recognition and large ad space which is difficult to ignore.</li>
                                        <li class='pb-3 ad-feature'><strong class='ad-feature-point'>Banner size:</strong> 250W x 70H pixels.</li>
                                    </ol>
                                </div>
                                <div class="col-lg-7 ads-img-box">
								<img  class='img-fluid' src="{{ asset('assets/images/dummy-ads/Leaderboard-ad.png') }}" alt="Ad image" >
                                </div>
                            </div>
                        </div>
               		 </div>
            	</div>
        	</div>
		</div>
	</div>
@endsection

@section('page_script')
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const elements = document.querySelectorAll('.wrapper');

		function checkVisibility() {
			const windowHeight = window.innerHeight;

			elements.forEach(element => {
				const { top, bottom } = element.getBoundingClientRect();
				if (top < windowHeight && bottom >= 0) {
					element.classList.add('in-view');
				}
			});
		}

		window.addEventListener('scroll', checkVisibility);
		window.addEventListener('resize', checkVisibility);
		checkVisibility(); // Initial check
	});


	document.addEventListener("DOMContentLoaded", () => {
		const marquee = document.querySelector(".marquee-inner");
		const speed = 1; // Scrolling Speed
		let scrollAmount = 0;
		let isHovered = false;

		// Duplicates the content
		const marqueeContent = marquee.innerHTML;
		marquee.innerHTML += marqueeContent;

		const startScrolling = () => {
			if (!isHovered) {
				scrollAmount -= speed;
				if (Math.abs(scrollAmount) >= marquee.scrollWidth / 2) {
					scrollAmount = 0;
				}
				marquee.style.transform = `translateX(${scrollAmount}px)`;
			}
			requestAnimationFrame(startScrolling);
		};

		marquee.addEventListener("mouseover", () => {
			isHovered = true;
		});

		marquee.addEventListener("mouseout", () => {
			isHovered = false;
		});

		startScrolling();
	});

    document.addEventListener("DOMContentLoaded", function() {
        const tabLinks = document.querySelectorAll(".tab-link");
        const tabContents = document.querySelectorAll(".tab-content");
        const listItems = document.querySelectorAll(".list-group-item");

        tabLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                const target = link.getAttribute("data-target");

                tabLinks.forEach(link => link.classList.remove("active-tab"));
                tabContents.forEach(content => content.classList.remove("active"));

                link.classList.add("active-tab");
                document.getElementById(target).classList.add("active");
            });
        });

        listItems.forEach(item => {
            item.addEventListener("click", function(event) {
                listItems.forEach(i => i.classList.remove("active-item"));
                item.classList.add("active-item");
            });
        });

        // Activate Banner Advertising by default
        document.querySelector('[data-target="banner-advertising"]').classList.add("active-tab");
        document.getElementById("banner-advertising").classList.add("active");
    });

	// update counter script added by hamza amjad
	let endDate = new Date("2024-10-31");

	// Update the countdown every second
	const countdownTimer = setInterval(() => {
		const now = new Date().getTime();
		const distance = endDate - now;

		if (distance < 0) {
			clearInterval(countdownTimer);
			document.getElementById("ad-countdown").innerHTML = "EXPIRED";
			localStorage.removeItem('endDate'); // Clear the end date from local storage
			return;
		}

		const days = Math.floor(distance / (1000 * 60 * 60 * 24));
		const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		const seconds = Math.floor((distance % (1000 * 60)) / 1000);

		document.getElementById("days").innerHTML = days;
		document.getElementById("hours").innerHTML = ("0" + hours).slice(-2);
		document.getElementById("minutes").innerHTML = ("0" + minutes).slice(-2);
		document.getElementById("seconds").innerHTML = ("0" + seconds).slice(-2);
	}, 1000);
</script>
@endsection
