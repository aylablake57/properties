<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DHA 360 | Authentic Properties</title>

        <!-- Favicons -->
        <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="36x36">
        <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="192x192">
        <link rel="apple-touch-icon" href="{{getAdminAsset('images/logo-1.png')}}">
        <meta name="msapplication-TileImage" content="{{getAdminAsset('images/logo-1.png')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        {{-- Library: Fontawsome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Library: Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Library: swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <!-- Library: Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

        <!-- Library: Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        
        @if (auth()->user()->hasRole('superadmin'))
        {{-- Data Tables --}}
        <link href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        @endif

        <!-- Jquery Confirm Box -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">

        <!-- Custome CSS -->
        <link href="{{getAdminAsset('css/app.css')}}?v={{ config('app.version') }}" rel="stylesheet">
        <link href="{{getAdminAsset('css/custom.css')}}?v={{ config('app.version') }}" rel="stylesheet">
        <link href="{{getAdminAsset('css/media.css')}}?v={{ config('app.version') }}" rel="stylesheet">

        @yield('local-style')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-QG0JEY44XC"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-QG0JEY44XC');
        </script>
        <!-- Meta Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1231505058097423');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1231505058097423&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->
    </head>
    <body class="main-dashboard-user">
        <div id="particles-js"></div>
        @include('layouts.navigation')
        <!-- Page Content -->
        <main id="main" class="main">
            <!-- Page Heading -->
            @hasSection('title')
                <header class="pagetitle">
                    <h4>@yield('title')</h4>
                </header>
            @endif
            @yield('page')
            {{-- {{ $slot }} --}}

            @if (!auth()->user()->hasRole('superadmin'))
            <div class="wrapper-footer">
                {{-- Footer Disclaimer added by Hamza Amjad --}}
                <footer class="text-justify disclaimer-footer mt-2 pt-1 bg-light">
                    <p class="text-small">
                        <strong>Disclaimer*</strong> The Company is not liable for any financial losses, data corruption, or damages incurred through the use of the Website or Service. Users understand that our system operates live, and any data they provide may be publicly accessible. Furthermore, the Company is not responsible for any cyber security attacks or unauthorized use of the Website. By using our services, Users acknowledge these risks and agree to proceed at their own discretion.
                    </p>
                </footer>
            </div>
            @endif
        </main>

        <!-- Library: Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        
        @if (auth()->user()->hasRole('superadmin'))
        {{-- Data Tables --}}
        <script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
        @endif

        <!-- Vendor: JS Files -->
        <script src="{{getadminasset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}?v={{ config('app.version') }}"></script>
        {{-- <script src="{{getadminasset('vendor/chart.js/chart.umd.js')}}?v={{ config('app.version') }}"></script>
        <script src="{{getadminasset('vendor/echarts/echarts.min.js')}}?v={{ config('app.version') }}"></script>
        <script src="{{getadminasset('vendor/quill/quill.min.js')}}?v={{ config('app.version') }}"></script> --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

        <!-- Library: Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

        <script src="{{getadminasset('js/main.js')}}?v={{ config('app.version') }}"></script>
        <script src="{{ getadminasset('js/notifications.js') }}?v={{ config('app.version') }}"></script>
        <script src="{{getadminasset('js/toggle-sidebar-profile-menu.js')}}?v={{ config('app.version') }}"></script>

        {{-- Particle js script added by Hamza Amjad --}}
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        @if (!auth()->user()->hasRole('superadmin'))
        <script src="{{getadminasset('js/user-dashboard.js')}}?v={{ config('app.version') }}"></script>
        <script src="{{getadminasset('js/particle.js')}}?v={{ config('app.version') }}"></script>
        @else
        <script>
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 100,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#808080"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#808080",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        </script>
        @endif

        @yield('page_script')
        @yield('componenet_script')
        @stack('scripts')
    </body>
</html>
