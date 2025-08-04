<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DHA 360 | Authentic Properties</title>

        <!-- For Face BooK Login -->
        <meta property="og:url"                content="https://example.com" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="Site's placeholder title" />
        <meta property="og:description"        content="Site's placeholder description" />
        <meta property="og:image"              content="https://mystoragebucket/mysiteimage.png" />
        <meta property="fb:app_id"             content="888613483105988" />

        <!-- Favicons -->
        <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="36x36">
        <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="192x192">
        <link rel="apple-touch-icon" href="{{getAdminAsset('images/logo-1.png')}}">
        <meta name="msapplication-TileImage" content="{{getAdminAsset('images/logo-1.png')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Library: Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Library: swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <!-- Library: Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

        <!-- Library: Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Custome CSS -->
        <link href="{{getAdminAsset('css/login.css')}}?v={{ config('app.version') }}" rel="stylesheet">
        <link href="{{getAdminAsset('css/media.css')}}?v={{ config('app.version') }}" rel="stylesheet">

        {!! RecaptchaV3::initJs() !!}

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
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-6 d-none d-md-block d-lg-block d-xl-block ">  {{-- bg-image --}}
                    <div class="text-content">
                        <h2>Experience a <span class="badge bg-danger">Swift</span> Property Sale <br>with dha360.pk</h2>
                        <p>Follow three easy steps to upload your property!</p>
                        <ul>
                            <li> Create your free account, add basic details of your property.</li>
                            <li> Upload good quality pictures and videos of your property.</li>
                            <li> Submit it for review and it will go live within 24 hours.</li>
                        </ul>
                        <!-- Add your image below the list -->
                        <img src="{{ getAdminAsset('images/login/ad1.png') }}" alt="Property Image">
                    </div>
                </div>
                <div class="col-sm-6" {{-- style="position:relative;" --}}>
                    {{ $slot }}
                </div>
            </div>
        </div>
        <div class="selling-tips-container bg-white mt-5">
            <div class="container">
                <div class="selling-tips">
                    <h2>Tips for Fastest Sale</h2>
                    <p>Creating an effective property ad is crucial for attracting potential buyers or renters. Here are some tips to help you craft a compelling property ad:</p>
                    <h3><i class="fasolid fa-1"></i> Catchy Headline</h3>
                    <p>Use a headline that grabs attention and highlights the key selling points. For example, “Spacious 3-Bedroom Family Home with Stunning Views” is more engaging than “3-Bedroom House for Sale.”</p>
                    <h3><i class="fasolid fa-2"></i> High-Quality Photos</h3>
                    <p>Include high-resolution images that showcase the property’s best features. Make sure to photograph all major rooms, the exterior, and any unique elements (e.g., a pool or garden). Natural light works wonders, so aim for daytime shots.</p>
                    <h3><i class="fasolid fa-3"></i> Detailed Description</h3>
                    <p>Provide a comprehensive description of the property. Include details about the number of bedrooms and bathrooms, square footage, special features (e.g., renovated kitchen, hardwood floors), and any recent upgrades or renovations.</p>
                    <h3><i class="fasolid fa-4"></i> Highlight Key Features</h3>
                    <p>Emphasize features that make the property stand out, such as energy-efficient appliances, smart home technology, or proximity to amenities like schools, parks, and public transport.</p>
                </div>
            </div>
        </div>
        {{-- <div class="faqs-container">
            <div class="faqs">
                <h2>Frequently Asked Questions</h2>
                <h3><i class="fas fa-question-circle"></i> What are the charges to post a property on ilaan.com?</h3>
                <p>There are no charges to post a property on ilaan.com. It is completely free to list your property.</p>
                <h3><i class="fas fa-question-circle"></i> How many properties can I list on ilaan.com?</h3>
                <p>You can list as many properties as you want on ilaan.com. There is no limit to the number of properties you can advertise.</p>
                <h3><i class="fas fa-question-circle"></i> What fields are mandatory to add while adding a property?</h3>
                <p>Mandatory fields include property type, location, number of rooms, and other essential details to provide a comprehensive listing.</p>
                <h3><i class="fas fa-question-circle"></i> Can I pin my listing on top of search results?</h3>
                <p>Yes, you can opt for a premium feature to pin your listing on top of search results for better visibility.</p>
            </div>
        </div> --}}

        {{-- <script src="https://kit.fontawesome.com/c8d0b72f05.js" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        <!-- Library: custom -->
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
        <script src="{{getAdminAsset('js/register.js')}}?v={{ config('app.version') }}"></script>

        @yield('page_script')
    </body>
</html>

