    <footer class="mb-0 footer">
        <div class="container">
            <div class="wrapper">
                <div class="mx-1 row mx-md-1 mx-lg-1 mx-xl-5">
                    <div class="col-md-3">
                        <ul>
                            <li class="widget-container">
                                <h4 class="widget-title">Contact us</h4>
                                <div class="contact-sidebar">
                                    <p class="contact-item">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#mapModal" data-map-src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1662.7121048476527!2d73.09588353890805!3d33.54235299333836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzPCsDMyJzMyLjUiTiA3M8KwMDUnNDkuOCJF!5e0!3m2!1sen!2s!4v1727851573664!5m2!1sen!2s">
                                            <i class="fa fas fa-map-marker-alt"></i>DHA360 Head Office, Avenue Mall, DHA Phase-1, Islamabad
                                        </a>
                                    </p>
                                    <p class="contact-item"><i class="fas fa-phone"></i><a href="tel:%2B92+51+111+DHA360">+92 51 111 DHA360</a></p>
                                    <p class="contact-item"><i class="far fa-envelope"></i><a href="mailto:properties@dha360.pk">properties@dha360.pk</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul>
                            <li class="widget-container">
                                <h4 class="widget-title">Properties By City</h4>
                                <div class="category-list d-flex">
                                    <ul>
                                        <li><a href="{{ route('search' , 'city=6') }}">Bahawalpur</a>{{-- <span>(64)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=7') }}">Gujranwala</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=1') }}">Islamabad</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=3') }}">Karachi</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=2') }}">Lahore</a>{{-- <span>(8)</span> --}}</li>
                                    </ul>
                                    <ul class="ml-3">
                                        <li><a href="{{ route('search' , 'city=4') }}">Multan</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=5') }}">Peshawar</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=8') }}">Quetta</a>{{-- <span>(8)</span> --}}</li>
                                        <li><a href="{{ route('search' , 'city=9') }}">City Karachi</a>{{-- <span>(8)</span> --}}</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <ul>
                            <li class="widget-container">
                                <h4 class="widget-title">Connect</h4>
                                <div class="category-list">
                                    <ul>
                                        <li><a href="https://home.dha360.pk/become-jv-partner/">Become JV Partner</a></li>
                                        <li><a href="https://home.dha360.pk/">Decision Hub 360</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <ul class="ps-0">
                            <li class="widget-container">
                                <h4 class="widget-title">Company</h4>
                                <div class="category-list">
                                    <ul>
                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                        <li><a href="{{ route('contact') }}">Contact</a></li>
                                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                        <li><a href="{{ route('terms-conditions') }}">Terms and Conditions</a></li>
                                        {{-- <li><a href="{{ route('about') }}">FAQs</a></li> --}}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <ul>
                            <h4 class="widget-title">Get Connected</h4>
                            <li class="widget-container d-flex">
                                <div class="social-sidebar">
                                    <a href="https://www.facebook.com/people/Properties-DHA-360/61566460558772/" target="_blank" aria-label="facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.instagram.com/properties_dha360/" target="_blank" aria-label="instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/company/properties-dha-360" target="_blank" aria-label="linkedin">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    <a href="https://www.youtube.com/@DHA360-o2d" target="_blank" aria-label="youtube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- <div class="col-md-3">
                        @include ('guest.partials.latest-properties')
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="mb-0 sub-footer">
            <div class="container">
                <span class="copyright">Copyright © DHA360. All Rights Reserved 2024</span>
            </div>
        </div>
    </footer>
    {{-- Model added for map view, by Hamza Amjad --}}
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">DHA360 Head Office</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="mapIframe" src="" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Library: Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!-- Library: Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <!-- Library: Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Font Awsome -->
    {{-- <script src="https://kit.fontawesome.com/c8d0b72f05.js" crossorigin="anonymous"></script> --}}

    <!-- Toast Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <!-- Slick slider jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slick slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

    <!-- Library: custom -->
    <script src="{{getAdminAsset('js/core.js')}}?v={{ config('app.version') }}"></script>

    <!-- Particle JS script -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    {{-- tawk button responsiveness and height form bottom adjusted by Hamza Amjad --}}
    <!--Start of Tawk.to Script-->
    {{-- <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/66b1e4051601a2195ba14950/1i4je5e17';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        // Custom styling of Offset starts here
        Tawk_API.customStyle = {
            visibility: {
                //for desktop only
                desktop: {
                position: 'br',
                xOffset: 25, // 15px away from right
                yOffset: 125 // 85px up from bottom
                },
                // for mobile only
                mobile: {
                position: 'br',
                xOffset: 20,
                yOffset: 125
                }
            }
        }
    </script> --}}
    <!--End of Tawk.to Script-->

    <script>
        function copyText(elementId, iconId) {
            var copyText = document.getElementById(elementId).textContent.trim();
            navigator.clipboard.writeText(copyText).then(function() {
                var iconElement = document.getElementById(iconId);
                if (iconElement) {
                    iconElement.classList.remove('fa-regular', 'fa-copy');
                    iconElement.classList.add('fa', 'fa-check');
                    setTimeout(function() {
                        iconElement.classList.remove('fa', 'fa-check');
                        iconElement.classList.add('fa-regular', 'fa-copy');
                    }, 2000);
                } else {
                    console.error("Icon element not found: " + iconId);
                }
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        }



    </script>
    {{-- Model script added for map view, by Hamza Amjad --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // When the modal is shown
            var mapModal = document.getElementById('mapModal');
            mapModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var mapSrc = button.getAttribute('data-map-src'); // Extract info from data-* attributes
                var modalIframe = mapModal.querySelector('#mapIframe');
                modalIframe.setAttribute('src', mapSrc); // Update the iframe src
            });
    
            // When the modal is hidden
            mapModal.addEventListener('hidden.bs.modal', function () {
                var modalIframe = mapModal.querySelector('#mapIframe');
                modalIframe.setAttribute('src', ''); // Reset the iframe src
            });
        });
    </script>    
    @yield('page_script')

    @yield('partial_script')

    @yield('componenet_script')
