@extends('guest.layouts.guest')
@section('title') Explore DHAs @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
    <div class="explore my-5 py-5">
        <div class="container ad-margin-top">
            <div class="section-title my-5">
                <h2>Explore DHAs</h2>
                <p>Take immersive 360-degree virtual tours of DHA properties to make informed decisions.</p>
            </div>
            <div class="bg-white mt-5 py-4">
                <div class="row">
                    <div class="col-sm-4 mb-3 border-right">
                        <img src="{{ getAdminAsset('images/explore/ISB-RWP-1.jpg') }}" class="img-fluid" alt="Properties">
                    </div>
                    <div class="col-sm-8 mb-3">
                        <div id="accordion">
                            <ul id="tabs" class="nav nav-pills nav-fill pb-2 border-bottom" data-bs-toggle="tab">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#phase1" data-bs-toggle="tab" data-bs-parent="#collapse">Phase I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#phase2" data-bs-toggle="tab" data-bs-parent="#collapse">Phase II</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#phase3" data-bs-toggle="tab" data-bs-parent="#collapse">Phase III</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#phase4" data-bs-toggle="tab" data-bs-parent="#collapse">Phase IV</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#phase5" data-bs-toggle="tab" data-bs-parent="#collapse">Phase V</a>
                                </li>
                            </ul>
                        </div>
                        <div class="panel">
                            <div id="phase1" class="collapse show">
                                <ul><li><a href="https://momento360.com/e/u/74ac9cb5435f4b01898ba3c9593d086d?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Head Office DHAI-R</a></li><li><a href="https://momento360.com/e/u/538e9c7970cd458ca7a93c663be37c5e?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">APS Sector B</a></li><li><a href="https://momento360.com/e/u/d028e0ad6dcf4da0a062f97001d19ef7?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Avenue Mall</a></li><li><a href="https://momento360.com/e/u/b42184ebc6f34c8cbfb8f4d2dfc1771b?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Jungle Park</a></li></ul>
                            </div>
                            <div id="phase2" class="collapse fade">
                                <ul><li><a href="https://momento360.com/e/u/ed7d9b2cce46430db231431954118bd8?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Central Park</a></li><li><a href="https://momento360.com/e/u/50ccd55ed84f4a8b9f11b6b5d1ad7b46?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">DES</a></li><li><a href="https://momento360.com/e/u/cf0d8f5cd1684c5b9c4c3df26506386b?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Mini Oval</a></li><li><a href="https://momento360.com/e/u/3e46613baea7471595de265acb4fc7ac?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Sector H Masjid</a></li></ul>
                            </div>
                            <div id="phase3" class="collapse fade">
                                <ul><li><a href="https://momento360.com/e/u/612b8317f357450e96ae67adc8c3702d?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Clock Chowk</a></li><li><a href="https://momento360.com/e/u/341ee34288d844d983b573b448298e8f?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Sector B Masjid</a></li><li><a href="https://momento360.com/e/u/cd25246283fc440198612e20520cc31e?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Sector B Park</a></li></ul>
                            </div>
                            <div id="phase4" class="collapse fade">
                                <ul><li><a href="https://momento360.com/e/u/dc5575b5e2664632915b411dfb2ea839?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">ARL Park</a></li><li><a href="https://momento360.com/e/u/dd505c17e1f941d88bdfe5d90a09d1f6?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Bridge</a></li><li><a href="https://momento360.com/e/u/de34af9c0fd1462a819badf3c633f51b?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Overseas Sector</a></li></ul>
                            </div>
                            <div id="phase5" class="collapse fade">
                                <ul><li><a href="https://momento360.com/e/u/c8bb8be1ec07493d8fc30edbbd90acd2?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Interchange</a></li><li><a href="https://momento360.com/e/u/d6d1b4f129164e71bb1e63f71ff3196f?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Family Park Sec-A</a></li><li><a href="https://momento360.com/e/u/1d722dbd32854bc79f83f0a5a7342765?utm_campaign=embed&amp;utm_source=other&amp;heading=0&amp;pitch=0&amp;field-of-view=75&amp;size=medium&amp;display-plan=true" target="_blank" rel="noopener">Miya Waki</a></li></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            $('#accordion [data-bs-toggle="tab"]').click(function() {
                var $targetTabContent = $($(this).attr('href'));
                if ($targetTabContent.hasClass('active')) {
                    $targetTabContent.removeClass('active');
                }
            });
        });
    </script>
@endsection