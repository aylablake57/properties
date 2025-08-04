@extends('guest.layouts.guest')
@section('title') Maps DHAs @endsection
@section('local-style')
    <link href="{{getAdminAsset('css/inner.css')}}?v={{ config('app.version') }}" rel="stylesheet">

    <!-- Include Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.css" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">

    <link href="{{getAdminAsset('css/maps.css')}}?v={{ config('app.version') }}" rel="stylesheet">
@endsection

@section('page')
<div class="container-fluid mt-5 pt-5 container-map">
    <div class="row ad-margin-top">
        <div class="col-lg-2 col-md-3 col-12 mb-3">
            <div class="tab-content">
                <div class="tab-pane active">
                    <form method="get" action="{{ route('maps') }}">
                        <div class="justify-content-start mb-3">
                            <label for="city" class="form-label">CITY</label>
                            <select class="form-select dropdown" name="city" id="city-dropdown" required>
                                <option value="" selected disabled>Select</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ str_replace('_', ' ', $city->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="justify-content-start mb-3">
                            <label for="area" class="form-label">LOCATION</label>
                            <select class="form-select dropdown" name="location" id="location-dropdown" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="justify-content-end pt-4">
                            <button type="submit" class="btn btn-accent">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-9 col-12">
            <!-- Filter Button -->
            <div class="maps d-flex justify-content-end mb-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="filterButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterButton">
                        <div class="radio-buttons p-3">
                            <input type="radio" id="streets" name="style" value="streets-v11" checked>
                            <label for="streets">Streets</label>
                            <br>
                            <input type="radio" id="satellite-streets" name="style" value="satellite-streets-v11">
                            <label for="satellite-streets">Satellite Streets</label>
                            <br>
                            <input type="radio" id="light" name="style" value="light-v10">
                            <label for="light">Light</label>
                            <br>
                            <input type="radio" id="dark" name="style" value="dark-v10">
                            <label for="dark">Dark</label>
                        </div>
                    </ul>
                </div>
            </div>                        
                    
            <!-- Map Section -->
            <div id="map" class="mt-2"></div>

            <div class="container-bottom">
                <div id="fullscreen" class="map-overlay map-expand"><i class="fas fa-expand"></i></div>
                <div id="location-button" class="map-overlay map-marker"><i class="fas fa-map-marker-alt"></i></div>
                <div id="show-all-markers" class="map-overlay map-all"><i class="fas fa-map-marked-alt"></i></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_script')
<script src="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script src="{{getAdminAsset('js/map.js')}}?v={{ config('app.version') }}"></script>
<script>
// URL for your custom marker image
const customMarkerUrl = "{{ asset('assets/images/icons/marker.gif') }}"; // Replace with your image URL
</script>
@endsection