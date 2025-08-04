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
                                    <div class="mb-3 col justify-content-center">
                                        <select class="form-select" name="city">
                                            <option value="" selected disabled>City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" @selected(isset($search['city']) && $search['city'] == $city->id)>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col justify-content-start">
                                        <div class="input-group search-box-index">
                                            <input type="text" class="form-control" placeholder="Agent name" name="agent_name" value="{{ isset($search['agent_name']) ? $search['agent_name'] : '' }}">
                                            <span class="input-group-text search-box-index-text">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col justify-content-end">
                                        <button type="submit" class="btn btn-accent">
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
        <div class="mt-5 row">
            <div class="mb-3 col-lg-12">
                @if (session('check_contact_agent'))
                    <div class="alert alert-success">
                        {{ session('check_contact_agent') }}
                    </div>
                @endif
                <div class="pb-5 mb-5 bg-white">
                    <div class="container">
                        <div class="py-3 section-title d-flex justify-content-between">
                            <h4>{{ 'Property ' . \Str::plural($pageTitle, $users->total()) . ' (' . $users->total() . ')'  }}</h4>
                            <a class="" data-bs-toggle="collapse" href="#agents" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-solid fa-sliders"></i>
                            </a>
                        </div>
                        <div class="row collapse show" id="agents">
                            {{-- make some adjustment and add styling done by Hamza Amjad --}}
                            @foreach($users as $user)
                            <div class="mb-3 col-lg-6 agent-box">
                                <div class="agent-profile-card">
                                    <div class="agent-profile-image-wrapper">
                                        <img src="{{ showUserImage($user) }}" alt="Profile Image" class="agent-profile-image">
                                    </div>
                                    <div class="agent-profile-details">
                                        <div class="d-flex name_star">
                                            <h5 class="agent-profile-name">{{ ucwords(strtolower($user->name)) }}</h5>
                                            <div class="ms-2 d-flex align-items-center">
                                                <span class="mt-1 me-1">0</span>
                                                <i class="fas fa-star text-mute"></i>
                                            </div>
                                        </div>
                                        <p class="agent-profile-listings">
                                            {{ $user->propertiesForSale ? $user->propertiesForSale . ' for Sale' : '0 for Sale' }}
                                            {{ $user->propertiesForRent ? ' | ' . $user->propertiesForRent . ' for Rent' : '' }}
                                            {{ $user->propertiesSold ? ' | ' . $user->propertiesSold . ' Sold' : '' }}
                                        </p>
                                        <div class="agent-profile-location">
                                            @if ($user->city)
                                            <i class="fas fa-map-marker-alt"></i> {{ $user->city?->name }}
                                            @endif
                                        </div>
                                        <div class="agent-profile-actions">
                                            <a href="{{ route('agents.agents-profile', $user->id) }}" class="btn btn-primary">
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
                                            <h6 class="text-center modal-title">Contact {{ $pageTitle }}</h6>
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
                            {{ $users->appends(['dhaAgents' => $dhaAgents->currentPage()])->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5 mb-5 bg-white featured-agents">
            <div class="container">
                <div class="py-3 section-title d-flex justify-content-between">
                    <h4>{{ 'DHA Verified Property ' . \Str::plural('Agent', $dhaAgents->total()) . ' (' . $dhaAgents->total() . ')'}}</h4>
                    <a class="" data-bs-toggle="collapse" href="#verifiedAgents" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-sliders"></i>
                    </a>
                </div>
                <div class="row collapse show" id="verifiedAgents">
                    @foreach($dhaAgents as $vendor)
                        <div class="mb-3 col-lg-6">
                            <div class="p-2 vendor-box border-all">
                                <div class="py-2 profile-details">
                                    <!-- Stars added inside h6 header tag by Hamza Amjad -->
                                    <h6 class="text-capitalize d-flex align-items-center position-relative">
                                        <span>
                                            <img src="{{ getAdminAsset('images/icons/verified.png')}}" class="me-2" width="20px" alt="Verified Agents">{{ $vendor->name_of_firm }}
                                            <span class="position-absolute star" style="right: 0;">
                                                <i class="fas fa-star text-muted"></i>
                                                <i class="fas fa-star text-muted"></i>
                                                <i class="fas fa-star text-muted"></i>
                                                <i class="fas fa-star text-muted"></i>
                                                <i class="fas fa-star text-muted"></i>
                                            </span>
                                        </span>
                                    </h6>
                                    <!-- Stars ended h6 header tag. -->
                                    @if($vendor->name_of_person)
                                    <span class="counts">{{ $vendor->name_of_person }} </span>
                                    |
                                    @endif
                                    <span class="count">{{ $vendor->city?->name }}</span>
                                    <br>

                                    <h6 class="my-2">Contact Details</h6>
                                    <div class="mb-3 location">
                                        @php
                                            if ($vendor->contact_no) {
                                                $contactList = explode(' ', $vendor->contact_no);
                                                foreach($contactList as $contact) {
                                                    echo '<i class="pt-1 fa-solid fa-phone me-3"></i>';
                                                    echo $contact;
                                                    echo '<br>';
                                                }
                                            }
                                        @endphp
                                    </div>

                                    @if($vendor->address)
                                    <div class="d-flex justify-content-start">
                                        <i class="pt-1 fa-solid fa-location-dot me-3"></i>
                                        <p class="mb-0">{{ $vendor->address }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($dhaAgents && $dhaAgents->count() > 0)
                    {{ $dhaAgents->appends(['users' => $users->currentPage()])->links('pagination::bootstrap-5') }}
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-5 row">
            <div class="mb-3 col-lg-9" >
                <div class="py-3 mb-5 bg-white" style="height: 100%;">
                    <div class="container">
                        <div class="section-title ">
                            <h4>Properties in DHA</h4>
                            <p>Discover the exceptional features of DHA properties in Pakistan's most vibrant cities</p>
                        </div>
                        <div class="shadow-none listing-summary" >
                            <div class="flex-wrap pt-4 d-flex justify-content-between">
                            @foreach ($propertiesByCities as $city)
                                @include('guest.partials.listing-summary')
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-3">
                <div class="p-3 bg-white" style="height: 100%;">
                    @include ('guest.partials.latest-properties')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
{{-- Modal should not close if there are errors in the form --}}
@if (count($errors) > 0)
<script type="text/javascript">
    $( document ).ready(function() {
        $('#emailModal{{ $user->id }}').modal('show');
    });
</script>
@endif
@endsection
