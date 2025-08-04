@extends('guest.layouts.guest')
@section('title') Property Details @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
    <div class="inner-banner">
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-10 offset-xl-1">
                    <div class="tab-content ad-margin-top">
                        <div class="tab-pane active">
                            <form method="get" action="{{ route('agents.list') }}">
                                <div class="row">
                                    <!-- h5 tag and 2 anchor tag `Name`, `Loctaion` + input search-box added by Hamza Amjad -->
                                    <h5 class="mb-3">Find a real-estate agent</h5>
                                    <!-- Button to toggle search boxes added by Hamza Amjad -->
                                    <a href="#" id="toggleNameSearchBox" class="btn btn-accent btn-a btn-sha w-100 {{ isset($search['agent_name']) ? 'active' : '' }}">Name</a>
                                    
                                    <!-- Button to toggle city dropdown added by Hamza Amjad -->
                                    <a href="#" id="toggleCityDropdown" class="btn btn-accent btn-sha btn-b w-100 mb-3 {{ isset($search['city']) ? 'active' : '' }}">Location</a>
    
                                    <div class="col justify-content-center mb-3" id="cityDropdownBox" style="{{ isset($search['city']) ? 'display: block;' : 'display:none' }}">
                                        <select class="form-select" name="city">
                                            <option value="" selected disabled>City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" @selected(isset($search['city']) && $search['city'] == $city->id)>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Agent Name Search Box (Initially visible) added by Hamza Amjad -->
                                    <div class="col mb-3" id="agentNameSearchBox" style="{{ isset($search['agent_name']) ? 'display: block;' : 'display:none' }}">
                                        <div class="input-group search-box-index">
                                            <input type="text" class="form-control" placeholder="Agent name" name="agent_name">
                                            <span class="input-group-text search-box-index-text">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col justify-content-end">
                                        <button type="submit" class="btn btn-accent h-35">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- Bubbles added by Hamza Amjad -->
        <div class="bubble bubble-left-1"></div>
        <div class="bubble bubble-left-2"></div>
        <div class="bubble bubble-left-3"></div>
        <div class="bubble bubble-right-1"></div>
        <div class="bubble bubble-right-2"></div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="row mb-3 mt-5">
                @if (session('check_contact_agent'))
                    <div class="alert alert-success">
                        {{ session('check_contact_agent') }}
                    </div>
                @endif
                <div class="row">
                <div class="col-lg-7 mb-5">
                    <div class="container bg-white pb-5 rounded h-100">
                        <div class="section-title py-3 d-flex justify-content-between">
                            <h4>{{ 'DHA Verified Property ' . \Str::plural('Agent', $dhaAgents->total()) . ' (' . $dhaAgents->total() . ')'}}</h4>
                        </div>
                        <div class="row collapse show" id="verifiedAgents">
                            @foreach($dhaAgents as $vendor)
                                <div class="col-lg-6 mb-3 vendor-boxs" style="display: none;">
                                    <div class="vendor-box border-all p-2">
                                        <div class="profile-details py-2">
                                            <!-- Stars added inside h6 header tag by Hamza Amjad -->
                                            <h6 class="text-capitalize d-flex align-items-center position-relative">
                                                <span>
                                                    <img src="{{ getAdminAsset('images/icons/verified.png')}}" class="me-2" width="20px" alt="Verified Agents">{{ $vendor->name_of_firm }}
                                                    <span class="position-absolute star" style="right: 0;">
                                                       0 <i class="fas fa-star text-muted"></i>
                                                    </span>
                                                </span>
                                            </h6>
                                            <!-- Stars ended h6 header tag. -->
                                            @if($vendor->name_of_person)
                                            <span class="counts">{{ $vendor->name_of_person }} </span>
                                            |
                                            @endif
                                            <span class="count">{{ $vendor->city->name }}</span>
                                            <br>

                                            <h6 class="my-2">Contact Details</h6>
                                            <div class="location mb-3">
                                                @php
                                                    if ($vendor->contact_no) {
                                                        $contactList = explode(' ', $vendor->contact_no);
                                                        foreach($contactList as $contact) {
                                                            if ($contact != '') {
                                                                echo '<i class="fa-solid fa-phone pt-1 me-3"></i>';
                                                                echo $contact;
                                                                echo '<br>';
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            </div>

                                            @if($vendor->address)
                                            <div class="d-flex justify-content-start">
                                                <i class="fa-solid fa-location-dot pt-1 me-3"></i>
                                                <p class="mb-0">{{ $vendor->address }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($dhaAgents && $dhaAgents->count() > 0)
                            {{-- <div class="pagination-container"></div> added by Hamza Amjad --}}
                            <div class="pagination-container">{!! $dhaAgents->withQueryString()->links('pagination::bootstrap-5') !!}</div>
                            @endif
                        </div>
                        {{-- View button added by Hamza Amjad --}}
                        <div class="text-center">
                            <button class="btn btn-accent mt-3 d-none col-sm-5" id="viewMoreBtn">View More</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-5">
                    <div class="container bg-gredient pb-5 rounded h-100">
                        <div class="section-title py-3 d-flex justify-content-between">
                            <h4 class="text-white">{{ 'Property ' . \Str::plural($pageTitle, $users->total()) . ' (' . $users->total() . ')'  }}</h4>
                            {{-- <a class="" data-bs-toggle="collapse" href="#agents" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-solid fa-sliders"></i>
                            </a> --}}
                        </div>
                        <div class="row collapse show" id="agents">
                            {{-- make some adjustment and add styling done by Hamza Amjad --}}
                            @foreach($users as $user)
                                <div class="col-lg-12 mb-3 agent-box">
                                    <div class="agent-profile-card">
                                        <div class="agent-profile-image-wrapper">
                                            <img src="{{ showUserImage($user) }}" alt="Profile Image" class="agent-profile-image">
                                        </div>
                                        <div class="agent-profile-details">
                                            <div class="d-flex name_star">
                                                <h5 class="agent-profile-name">{{ $user->name }}</h5>
                                                <div class="ms-2 d-flex align-items-center">
                                                    <span class="mt-1 me-1">0</span>
                                                    <i class="fas fa-star text-mute"></i>
                                                </div>
                                            </div>
                                            <p class="agent-profile-listings">
                                                {{ $user->propertiesForSale ? $user->propertiesForSale . ' for Sale' : '' }}
                                                {{ $user->propertiesForRent ? ' | ' . $user->propertiesForRent . ' for Rent' : '' }}
                                            </p>
                                            <div class="agent-profile-location">
                                                <i class="fas fa-map-marker-alt"></i> {{ $user->city?->name }}
                                            </div>
                                            <div class="agent-profile-actions">
                                                <a href="{{ route('agents-profile', 'id=' . $user->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-user"></i> View Profile
                                                </a>
                                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#emailModal{{ $user->id }}">
                                                    <i class="fas fa-envelope"></i> Email
                                                </button>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#callModal-{{ $user->id }}">
                                                    <i class="fas fa-phone"></i> Call
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Include Modals -->
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
                            @endforeach
                            @if ($users->count() > 0)
                               <div class="pagination-container"> {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}</div>
                            @endif
                        </div>
                        <div class="text-center">
                            <button class="btn btn-accent mt-5 d-none col-sm-5" id="view-more-agent">View more</button>
                        </div>
                    </div>
                </div>                
                </div>
                <div class="bg-white my-5 py-3">
                    <div class="container">
                        <div class="section-title ">
                            <h4>Properties in DHA</h4>
                            <p>Discover the exceptional features of DHA properties in Pakistan's most vibrant cities</p>
                        </div>
                        <div class="listing-summary shadow-none">
                            <div class="row pt-4">
                            @foreach ($propertiesByCities as $city)
                                @if($city->name != 'DHA City Karachi')
                                @include('guest.partials.listing-summary')
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- comment this section --}}
            {{-- <div class="col-lg-3 mb-3">
                <div class="bg-white p-3">
                    @include ('guest.partials.latest-properties')
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('page_script')
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