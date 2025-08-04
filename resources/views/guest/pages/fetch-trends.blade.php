{{-- By Asfia --}}
@extends('guest.layouts.guest')
@section('title') Trends @endsection
@section('local-style')
{{-- Trends --}}
<link href="{{getAdminAsset('css/trend.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
<!-- Header -->
<header class="trend-header position-relative">
    <div class="overlay"></div>
    <img src="{{ asset('assets/images/houston.jpeg') }}" alt="Trendy Real Estate" class="img-fluid header-image">
    <div class="container-fluid header-container-trend-page position-absolute top-50 start-50 translate-middle text-center text-md-start">
        <div class="row align-items-center header-row flex-column">
            <div class="col-md-12 text-center mb-5">
                <h1 class="header-title">DHA360 Search Trends</h1>
                <p class="header-subtitle">
                    Stay updated with the latest trends in the real estate market. Find insights, analysis, and updates to make informed decisions.
                </p>
                <!-- <div class="btn-group" role="group" aria-label="Buy or Rent">
                    <button type="button" class="btn btn-outline-success active" id="buyButton">Buy</button>
                    <button type="button" class="btn btn-outline-success" id="rentButton">Rent</button>
                </div> -->
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <form action="{{ route('search') }}" method="GET">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="city" class="form-label text-white">City</label>
                                    <select class="form-select" id="city" required name="city">
                                        <option selected disabled value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="location" class="form-label text-white">Location</label>
                                    <select class="form-select" id="location" required name="location">
                                        <option selected disabled value="">Select Location</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="propertyType" class="form-label text-white">Property Type</label>
                                    <select class="form-select" id="propertyType" required name="type">
                                        <option selected disabled value="">Select Property Type</option>
                                        @foreach($types as $name => $id)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success"><i class="fa fa-line-chart" aria-hidden="true"></i> View</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Recent Searches -->
<div class="recent-searches py-5 bg-white">
    <div class="container recent-searches-container">
        <h2 class="text-center mb-4">Recent Searches</h2>
        <div class="slider-container bg-white">
            <button class="slider-button left" id="leftButton" onclick="scrollSlider(-1)">&#10094;</button>
            <div class="card-slider" id="cardSlider">
                <div class="custom-card">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Property in DHA</h5>
                        <p class="custom-card-location"><i class="fas fa-map-marker-alt"></i> DHA</p>
                    </div>
                </div>
                <div class="custom-card">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Apartment in Gulshan</h5>
                        <p class="custom-card-location"><i class="fas fa-map-marker-alt"></i> Gulshan</p>
                    </div>
                </div>
                <div class="custom-card">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Villa in Bahria Town</h5>
                        <p class="custom-card-location"><i class="fas fa-map-marker-alt"></i> Bahria Town</p>
                    </div>
                </div>
                <div class="custom-card">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">House in Model Town</h5>
                        <p class="custom-card-location"><i class="fas fa-map-marker-alt"></i> Model Town</p>
                    </div>
                </div>
            </div>
            <button class="slider-button right" id="rightButton" onclick="scrollSlider(1)">&#10095;</button>
        </div>
    </div>
</div>


<!-- Search Trend by cities -->
<div class="container mt-5 bg-light">
    <h2 class="text-center mb-4">Search Trends By City</h2>
    <div class="row g-md-5 ml-2">
        <!-- Trend City Card -->
        @foreach ($search_log as $log)
            <div class="col-md-6 col-lg-4 col-sm-12 mb-4">
                <div class="trend-city-card shadow-sm border-0 rounded d-flex align-items-center">
                    <div class="trend-city-image">
                        <img src="{{ asset('assets/images/logos/' . strtolower(str_replace(['DHA', ' ', ''], ['', '', ''], $log->search_query)) . '.png') }}" alt="{{ $log->search_query }}" class="rounded-circle shadow">
                    </div>
                    <div class="trend-city-info p-3">
                        <span class="card-title">{{ $log->search_query }}</span>
                        <p class="card-text text-muted mb-1">{{ Number::abbreviate($log->search_count) }} searches</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                    <div class="watermark-image">
                        <img src="{{ asset('assets/images/logos/' . strtolower(str_replace(['DHA', ' ', ''], ['', '', ''], $log->search_query)) . '.png') }}" alt="{{ $log->search_query }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Top Trending Locations -->
<div class="py-5 bg-white">
    <h2 class="text-center">Top Trending Locations</h2>
    <div class="container slider-container-trend-location mt-5">
        <div class="wrapper-Top-Trending-Locations">
            <i id="left" class="fa-solid fas fa-angle-left"></i>
            <ul class="carousel-Top-Trending-Locations">
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Islamabad</div>
                    <div class="chart-container" id="chart1"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">8.18%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Karachi</div>
                    <div class="chart-container" id="chart2"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">45.87%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Lahore</div>
                    <div class="chart-container" id="chart3"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">31.25%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA City Karachi</div>
                    <div class="chart-container" id="chart4"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">9.76%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Gujranwala</div>
                    <div class="chart-container" id="chart5"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">0.5%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Bahawalpur</div>
                    <div class="chart-container" id="chart6"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">1.12%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Peshawar</div>
                    <div class="chart-container" id="chart7"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">7.10%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Quetta</div>
                    <div class="chart-container" id="chart8"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">4.32%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
                <li class="card-Top-Trending-Locations">
                    <div class="tag-Top-Trending-Locations">DHA Multan</div>
                    <div class="chart-container" id="chart9"></div>
                    <div class="details-Top-Trending-Locations">
                        <h2 style="color: #545454; font-weight: bold;">38.28%</h2>
                        <span>of total searches</span>
                    </div>
                </li>
            </ul>
            <i id="right" class="fa-solid fas fa-angle-right"></i>
        </div>
    </div>
</div>
@endsection

@section('page_script')
{{-- Trends --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="{{getAdminAsset('js/trend.js')}}?v={{ config('app.version') }}"></script>

<script>
    $(document).ready(function() {
        var locations = @json($cities);
        $('#city').change(function() {
            var cityId = $(this).val();
            var $locationSelect = $('#location');
            $locationSelect.empty().append('<option selected disabled value="">Select Location</option>');
            $.each(locations, function(index, city) {
                if (city.city_id == cityId) {
                    $.each(city.locations, function(i, location) {
                        $locationSelect.append($('<option>', {
                            value: location.id,
                            text: location.name
                        }));
                    });
                }
            });
        });
    });
</script>
@endsection
