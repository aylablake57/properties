<!-- code commented by Yousaf is starting here -->
@extends('guest.layouts.guest')
@section('title')
    Search
@endsection
@section('local-style')
    <link href="{{ getAdminAsset('css/inner.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ getAdminAsset('css/slider.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <style>
        .trend_chart {
            height: 400px !important;
        }

        .swiper {
            height: auto;
        }

        .swiper-slide {
            background: none;
        }
    </style>
@endsection

@section('page')
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-content ad-margin-top">
                    <div class="tab-pane active">
                        @include('guest.partials.search-form')
                        @include('guest.partials.filter')
                    </div>
                </div>
            </div>
            <div class="search-results">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-9 mb-3">
                        @if ($properties->count() > 0)
                            <div class="border-top border-bottom mb-5">
                                <div class="container">
                                    <div class="row py-3 center-icons">
                                        @include('guest.partials.sort')
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="latest-projects my-5">
                            <div class="row" id="search-results">
                                @forelse ($properties as $property)
                                    @include('guest.partials.searched-listing')
                                @empty
                                    <div class="col-sm-12">
                                        <h4>Sorry! No results are found.</h4>
                                    </div>
                                @endforelse
                                {!! $properties->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 bg-white mb-3">
                        <div class="ads-container">
                            <div class="mb-5 bg-white border-bottom">
                                <div class="container">
                                    <div class="row ">
                                        <div class="col-sm-12">
                                            <h4>Advertisement</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Scroller added By Hamza Amjad --}}
                            <div class="Advertisement-ad-images-wrapper">
                                @if (file_exists('assets/images/banner/top-banner.jpeg'))
                                    <img src="{{ getAdminAsset('images/banner/top-banner.jpeg') }}"
                                        class="img-fluid ad-image" alt="Properties">
                                @endif

                                <!-- By Asfia -->
                                @foreach (getAdsForColumn() as $ad)
                                    <img src="{{ env('FTP_BASE_URL') . '/' . $ad->file_name }}" id="{{ $ad->user_id }}"
                                        class="img-fluid ad-image mb-4 border-all ad-modal-trigger" alt="properties"
                                        data-bs-toggle="modal" data-bs-target="#adImageModal"
                                        data-ad-image="{{ env('FTP_BASE_URL') . '/' . $ad->file_name }}"
                                        data-agent-profile="{{ route('agents.agents-profile', $ad->user_id) }}">
                                @endforeach
                                {{-- Model added by Hamza Amjad for view of advertisement image, with View Profile button --}}
                                <div class="modal fade" id="adImageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Advertisement Ad</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="modal-image-wrapper">
                                                    <img id="modal-ad-image" src="" class="img-fluid"
                                                        alt="Ad Image">
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex">
                                                <!-- By Asfia -->
                                                <a href="#" id="view-agent-profile" class="btn btn-accent">
                                                    <i class="fas fa-user me-2"></i> View Agent Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12">
                        @include ('guest.partials.trends')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($similarProperties && $similarProperties->isNotEmpty())
        <div class="featured-projects bg-gredient mt-5 py-5">
            <div class="container">
                <div class="section-title text-start mb-5">
                    <h2 class="text-white">You May Also Like</h2>
                </div>

                <div class="swiper featured-swiper ">
                    <div class="swiper-wrapper">
                        @foreach ($similarProperties as $property)
                            @include('guest.partials.listing', ['property' => $property])
                        @endforeach
                    </div>
                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-wrapper d-flex justify-content-end pt-5">
                    <div class="swiper-button-prev me-4"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    @endempty
@endsection

@section('page_script')
    <script>
        window.routes = {
            subtypes: "{{ route('subtypes') }}"
        };
    </script>
    <script src="{{ getAdminAsset('js/home-slider.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ getAdminAsset('js/search.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ getAdminAsset('js/main.js') }}?v={{ config('app.version') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adImages = document.querySelectorAll('.ad-modal-trigger');
            const modalImage = document.getElementById('modal-ad-image');
            const agentProfileLink = document.getElementById('view-agent-profile');

            adImages.forEach(image => {
                image.addEventListener('click', function() {
                    const adImageSrc = this.getAttribute('data-ad-image');
                    const agentProfileHref = this.getAttribute('data-agent-profile');

                    modalImage.src = adImageSrc;
                    agentProfileLink.href = agentProfileHref;
                });
            });
        });
    </script>
@endsection
