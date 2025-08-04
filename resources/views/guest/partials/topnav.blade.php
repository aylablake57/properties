<header class="fixed-top">
    <!-- Ad-Banner, added by Hamza Amjad -->
    {{-- <div id="ad-banner" class="ad-banner position-relative">
        <button type="button" class="close-btn" aria-label="Close" onclick="closeAdBanner()">
            &times;
        </button>
        <img src="{{ asset('assets/images/banner/il0000000549220.webp') }}" alt="Ad Banner" class="img-fluid">
    </div>  --}}
    {{-- ad-banner end here --}}
    <nav class="navbar navbar-expand-lg bg-transparent">
        <div class="container">
            <a class="navbar-brand mt-0" href="{{ route('home') }}">
                <x-application-logo />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div id="navbar" class="collapse navbar-collapse justify-content-between navbar-nav-scroll"
                style="--bs-scroll-height: 500px;">
                <ul id="main-menu" class="navbar-nav justify-content-center p-0 left-side">
                    <li class="nav-item ">
                        <a id="home"
                            class="nav-link {{ strpos(Route::currentRouteName(), 'home') === 0 ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="about"
                            class="nav-link {{ strpos(Route::currentRouteName(), 'about') === 0 ? 'active' : '' }}"
                            href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="propertyList"
                            class="nav-link dropdown-toggle {{ strpos(Route::currentRouteName(), 'search') === 0 ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Properties</a>
                        <ul class="dropdown-menu" aria-labelledby="propertyList">
                            <li><a class="dropdown-item" href="{{ route('search', 'city=1') }}">DHA Islamabad /
                                    Rawalpindi</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=2') }}">DHA Lahore</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=3') }}">DHA Karachi</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=5') }}">DHA Multan</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=4') }}">DHA Peshawar</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=8') }}">DHA Bahawalpur</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=7') }}">DHA Gujranwala</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=6') }}">DHA Quetta</a></li>
                            <li><a class="dropdown-item" href="{{ route('search', 'city=9') }}">DHA City Karachi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="exploreList"
                            class="nav-link dropdown-toggle {{ strpos(Route::currentRouteName(), 'maps') === 0 || strpos(Route::currentRouteName(), 'explore') === 0 ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown">Explore</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('maps') }}">Maps of DHAs</a></li>
                            <li><a class="dropdown-item" href="{{ route('explore') }}">Explore DHA Islamabad</a></li>
                            <li><a class="dropdown-item" href="{{ route('fetchTrends') }}">Trends</a></li>
                            {{-- By Asfia --}}
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id="agentList"
                            class="nav-link {{ strpos(Route::currentRouteName(), 'agent') === 0 ? 'active' : '' }}"
                            href="{{ route('agents.list') }}">Property Agents</a>
                        {{-- <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('authorizees.agents') }}">Property Agents</a></li>
                            <li><a class="dropdown-item" href="{{ route('authorizees.agencies') }}">Real Estate Agencies</a></li>
                            <li><a class="dropdown-item" href="{{ route('authorizees.vendors') }}">Vendors</a></li>
                        </ul> --}}
                    </li>
                    <li class="nav-item">
                        <a id="advertise"
                            class="nav-link {{ strpos(Route::currentRouteName(), 'advertise') === 0 ? 'active' : '' }}"
                            href="{{ route('advertise') }}">Advertise</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="toolsList"
                            class="nav-link dropdown-toggle {{ strpos(Route::currentRouteName(), 'area-unit-converter') === 0 ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown">Tools</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('area-unit-converter') }}">Area Unit
                                    Converter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id="about"
                            class="nav-link {{ strpos(Route::currentRouteName(), 'contact') === 0 ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav justify-content-end pe-3 p-0 right-side">
                    <li class="nav-item me-3">
                        @if (Auth::user())
                            @if (auth()->user()->hasRole('superadmin'))
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-grip-vertical pt-2 me-2"></i> Dashboard
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-grip-vertical pt-2 me-2"></i> Dashboard
                                </a>
                            @endif
                        @else
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-user pt-2 me-2"></i> Login
                            </a>
                        @endif
                    </li>

                    <li class="nav-item">
                        <div class="input-group pt-1 mb-0">
                            <button class="btn btn-accent dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Register With Us</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('register') }}">To sell your Property</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" target="_blank"
                                        href="https://home.dha360.pk/become-jv-partner/">To become JV Partner</a></li>
                            </ul>
                            {{-- <input type="text" class="form-control" aria-label="Text input with dropdown button"> --}}
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>
