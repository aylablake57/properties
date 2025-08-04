@extends('layouts.app')
@section('title')
    Admin Dashboard
@endsection
@section('page')
    <div class="my-3">
        <section class="section dashboard">
            <div class="row">


                <div class="col-lg-8">
                    <div class="row">
                        <h3>Properties</h3>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card sales-card" id="section-total">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterTotalToday">Today</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterTotalMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterTotalYear">This Year</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Total <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-building-user"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="totalProperties">{{ $totalMonth }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#7171fc;">{{ $total }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card customers-card" id="section-approved">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterApprovedToday">Today</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterApprovedMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterApprovedYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Approved <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="approvedProperties">{{ $approvedMonth }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#18d26e;">{{ $approved }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card revenue-card" id="section-cancel">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="javascript:;" id="filterCancelToday">Today</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterCancelMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterCancelYear">This Year</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Cancel <span>| This Month</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-ban"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="cancelledProperties">{{ $cancelMonth }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#ff771d;">{{ $cancel }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card sold-card" id="section-sold">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="javascript:;" id="filterSoldToday">Today</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterSoldMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="filterSoldYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Sold <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="soldProperties">{{ $soldMonth }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#48c6ef;">{{ $sold }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- start ads counts by status --}}
                        <h3>Ads</h3>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card sales-card" id="ad-section-total">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;"
                                                id="adFilterTotalToday">Today</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterTotalMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterTotalYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Total <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-building-user"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="totalProperties">{{ $adsCounts['totalMonth'] }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#7171fc;">{{ $adsCounts['total'] }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card customers-card" id="ad-section-approved">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;"
                                                id="adFilterApprovedToday">Today</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterApprovedMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterApprovedYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Approved <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="approvedProperties">{{ $adsCounts['approvedMonth'] }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#18d26e;">{{ $adsCounts['approved'] }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card revenue-card" id="ad-section-cancel">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="javascript:;"
                                                id="adFilterCancelToday">Today</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterCancelMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterCancelYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Cancel <span>| This Month</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-ban"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="cancelledProperties">{{ $adsCounts['cancelMonth'] }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#ff771d;">{{ $adsCounts['cancel'] }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-5">
                            <div class="card info-card sold-card" id="ad-section-expired">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="javascript:;"
                                                id="adFilterExpiredToday">Today</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterExpiredMonth">Last
                                                Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;" id="adFilterExpiredYear">This
                                                Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Expired <span>| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="soldProperties">{{ $adsCounts['expiredAdsMonth'] }}</h6>
                                            <span class="small pt-1 fw-bold"
                                                style="color:#48c6ef;">{{ $adsCounts['expiredAds'] }}</span> <span
                                                class="text-muted small pt-2 ps-1">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end ads counts by status --}}
                        <div class="col-12">
                            <div class="card">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="javascript:;"
                                                onclick="drawLineChart('this month');">This Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;"
                                                onclick="drawLineChart('last month');">Last Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:;"
                                                onclick="drawLineChart('year');">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" id="linChart">Properties <span>/This Month</span></h5>

                                    <div id="reportsChart"></div>
                                </div>
                            </div>
                        </div>
                        {{-- chart added by Hamza Amjad --}}
                        <div class="col-12">
                            <div class="card">
                                <div class="filter">
                                    <a class="icon" href="javascript:;" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:;"
                                                onclick="showChart('this month');">Month</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:;"
                                                onclick="showChart('year');">Year's</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" id="linChart">
                                        Properties <span id="timePeriod">/This Month</span>
                                    </h5>

                                    <!-- Chart containers -->
                                    <div id="container"></div>
                                    <div id="containerHighChart" style="display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Registrations <span>| Complete</span></h5>
                                    <div class="filter">
                                        <a class="icon" href="javascript:;" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Filter</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:;" id="plain">Plain</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:;" id="inverted">Inverted</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:;" id="polar">Polar</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div id="registrationChart" style="min-height: 400px;" class="echart"></div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Complaints <span>| Recent</span></h5>

                                <table id="recentComplaints" class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Follow Up</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                        {{-- <div class="col-12">
                        <div class="card overflow-auto">
                            <div class="card-body pb-0">
                                <h5 class="card-title">News &amp; Updates <span>| Recent</span></h5>
                                <div class="news mb-2"></div>
                            </div>
                        </div>
                    </div> --}}
                    </div>
                </div>


                <div class="col-lg-4">
                    {{-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Activity <span>| Recent</span></h5>
                        <div class="activity"></div>
                    </div>
                </div> --}}
                    <h3>Users</h3>
                    <div class="card">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Registrations <span>| All</span></h5>
                            <div id="signupChart" style="min-height: 400px;" class="echart"></div>
                        </div>
                    </div>



                </div>

            </div>
        </section>
    </div>
@endsection

@section('page_script')
    <script src="{{ getadminasset('js/dashboard.js') }}?v={{ config('app.version') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
@endsection
