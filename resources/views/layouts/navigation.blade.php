<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ getadminasset('images/logo.png') }}" alt="Properties">
        </a>
        <i class="fa-solid fa-sliders toggle-sidebar-btn"></i>
    </div>

    {{-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div> --}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link nav-icon" href="{{ route('home') }}">
                    <i class="fa-solid fa-rotate-left"></i> <span class="nav-text">Back to website</span>
                </a>
            </li>

            @if (!auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a class="nav-link nav-icon" href="{{ url('shop/cart') }}">
                        <i class="fa-solid fa-cart-shopping"></i> <span
                            class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger ">{{ count((array) session('cart')) }}</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ auth()->user()->unreadNotifications->count() === 0 ? 'd-none' : '' }}"
                        id="badge">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" id="notification-list">
                    <div class="notification-header text-end p-2">
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <a href="javascript:void(0);" id="clear-all-notifications"
                                data-route="{{ route('notifications.clearAll') }}"
                                class="text-decoration-none fs-12">Mark all as read</a>
                        @endif
                    </div>
                    <div class="notification-scroll">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="dropdown-item {{ $notification->read_at ? 'read' : 'unread' }}"
                                id="notification-{{ $notification->id }}">
                                @if (!$notification->read_at)
                                    <span class="unread-indicator"></span>
                                @endif
                                <a href="javascript:void(0);" class="mark-as-read-user"
                                    data-id="{{ $notification->id }}"
                                    data-route="{{ route('notifications.markAsRead', $notification->id) }}">
                                    {{ $notification->data['message'] }}
                                </a>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </li>
                        @empty
                            <li class="dropdown-item" id="no-notification">
                                No notifications to show
                            </li>
                        @endforelse
                    </div>
                </ul>
            </li>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- <img src="{{ getAdminAsset('images/users/blank.png') }}" alt="{{ Auth::user()->name }}'s Photo" class="rounded-circle"> --}}
                    <i class="fa-solid fa-user-tie d-none d-md-block"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span>{{ auth()->user()->user_type->name }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    {{--  By Asfia --}}
                    @if (!auth()->user()->hasRole('superadmin'))
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="fa-regular fa-user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf</form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">User</li>
        <li class="nav-item">
            @if (auth()->user()->hasRole('superadmin'))
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.dashboard') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-grip-vertical"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'dashboard') === 0 ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-grip-vertical"></i>
                    <span>Dashboard</span>
                </a>
            @endif
        </li>
        <li class="nav-heading">Listings</li>
        @if (auth()->user()->hasRole('superadmin'))
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.requests.list') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.requests.list') }}">
                    <i class="fa-solid fa-list-check"></i><span>New Properties</span>
                </a>
            </li>

            <!-- new code added by Yousaf starts here -->
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.requests.properties') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.requests.properties') }}">
                    <i class="fa-brands fa-adversal"></i><span>All Properties</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.ads.list') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.ads.list') }}">
                    <i class="fa-solid fa-file-circle-plus"></i><span>New Ads</span>
                </a>
            </li>
            {{-- By Asfia --}}
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.requests.ads') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.requests.ads') }}">
                    <i class="fa-solid fa-file-circle-check"></i><span>All Ads</span>
                </a>
            </li>

            {{-- By Asfia --}}
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.requests.feedbacks') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.requests.feedbacks') }}">
                    <i class="fa fa-star"></i><span>Feedback</span>
                </a>
            </li>

            {{-- By Asfia --}}
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.requests.generalFeedbacks') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.requests.generalFeedbacks') }}">
                    <i class="fa-solid fa-star"></i><span>General Feedback</span>
                </a>
           </li>

            <li class="nav-heading">USERS</li>

            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.users.form') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.users.form') }}">
                    <i class="fa-solid fa-plus"></i><span>Add User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.users.list') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.users.list') }}">
                    <i class="fa-solid fa-list"></i><span>User List</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'property.form') === 0 ? 'active' : '' }}"
                    href="{{ route('property.form') }}">
                    <i class="fa-solid fa-plus"></i><span>Add Property</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'property.list') === 0 ? 'active' : '' }}"
                    href="{{ route('property.list') }}">
                    <i class="fa-solid fa-list"></i><span>My Properties</span>
                </a>
            </li>

            @if (!auth()->user()->hasRole('seller'))
                <li class="nav-heading">Advertisement</li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'ad.form') === 0 ? 'active' : '' }}"
                        href="{{ route('ad.form') }}">
                        <i class="fa-solid fa-plus"></i><span>Create Ad</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'ad.list') === 0 ? 'active' : '' }}"
                        href="{{ route('ad.list') }}">
                        <i class="fa-solid fa-list"></i><span>My Ads</span>
                    </a>
                </li>
            @endif

            @if (in_array(auth()->user()->user_type->value, ['agent', 'agency']))
                {{-- By Asfia --}}
                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'submitFeedback') === 0 ? 'active' : '' }}"
                        href="{{ route('submitFeedback') }}">
                        <i class="fa-solid fa-star"></i><span>My Feedback</span>
                    </a>
                </li>
                <li class="nav-heading">SHOP</li>

                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'shop.index') === 0 ? 'active' : '' }}"
                        href="{{ route('shop.index') }}">
                        <i class="fa-solid fa-user"></i><span>Buy Packages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'history') === 0 ? 'active' : '' }}"
                        href="#">
                        <i class="fa-solid fa-xmarks-lines"></i><span>Order History</span>
                    </a>
                </li>
            @endif
        @endif
        <li class="nav-heading">SETTINGS</li>
        @if (!auth()->user()->hasRole('superadmin'))
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'profile') === 0 ? 'active' : '' }}"
                    href="{{ route('profile.edit') }}">
                    <i class="fa-solid fa-user"></i><span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'change') === 0 ? 'active' : '' }}"
                    href="{{ route('change.password') }}">
                    <i class="fa fa-refresh" aria-hidden="true"></i><span>Change Password</span>
                </a>
            </li>
        @endif
        {{-- List added by Hamza Amjad --}}
        @if (auth()->user()->hasRole('superadmin'))
            {{-- By Asfia --}}
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'change') === 0 ? 'active' : '' }}"
                    href="{{ route('change.password') }}">
                    <i class="fa fa-refresh" aria-hidden="true"></i><span>Change Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ strpos(Route::currentRouteName(), 'reset') === 0 ? 'active' : '' }}"
                    href="{{ route('admin.userPassReset') }}">
                    <i class="fa fa-retweet" aria-hidden="true"></i><span>Manage User Password</span>
                </a>
            </li>
        @endif
    </ul>

</aside>
