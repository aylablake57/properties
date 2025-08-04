@extends('layouts.app')
@section('page')
    <header name="header">
        <h2>{{ $property ? 'Edit Property' : 'Add Property' }} (To Sell)</h2>
    </header>

    <div class="main my-3">
        <div class="container-fluid">
            <div class="tab-content float-none">
            @if ($property && $property->is_sold)
                <!-- Alert Message for Sold Property -->
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <strong>Attention:</strong> Sold Properties cannot be updated.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('property.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('property.partials.info')
                <hr>
                @include('property.partials.location')
                <hr>
                @include('property.partials.size-and-price')

                @include('property.partials.installment')
                <hr>
                @include('property.partials.contact')

                @include('property.partials.amenities')
                <hr>
                <div class="row">
                    <div class="col-sm-4 offset-lg-8 text-end">
                        @if ($property)
                        <input type="hidden" name="property_id" value="{{ $property->id }}" >
                        @endif

                        @if ($property && !$property->is_sold)
                            <button class="btn btn-accent">Update Property</button>
                        @else
                            <button class="btn btn-accent">Submit Property</button>
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('page_script')
{{-- <script src="{{getAdminAsset('js/main.js')}}?v={{ config('app.version') }}"></script> --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // for the subtypes route
    window.routes = {
        subtypes: "{{ route('subtypes') }}"
    };
</script>
<script>

    let property_id = "{{ $property?->id }}";
    let subTypeId = "{{ $property?->sub_type }}";
    $(document).ready(function () {
        //Populate Sub-Type dropdown - Edit Form
            
        // let typeName = $('#property_type').val();

        // if (subTypeId == '') {
        //     subTypeId = $('#sub_type').attr('data_old')
        // }
        // if (typeName) {
        //     getSubTypes(typeName , subTypeId);
        // }

        // Populate locations dropdown - Edit Form
        let cityID = $('#city-dropdown').val();
        let location = "{{ $property?->location_id }}";
        if (cityID) {
            getLocations(cityID, location)
        }

        // Populate locations dropdown - Create Form
        $('#city-dropdown').on('change', function () {
            let cityID = this.value;
            getLocations(cityID)
        });

        function getLocations(id, location = null)
        {
            $("#location-dropdown").html('');
            $.ajax({
                url: "{{ route('locations')}}",
                type: "GET",
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function (result) {
                    $.each(result, function (key, value) {
                        $("#location-dropdown").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    if (location) {
                        $("#location-dropdown").val(location);
                    }
                }
            });
        }

        // Populate amenities - Edit Form
        if (property_id) {
            getAmenities(subTypeId , property_id);
        }

        // Map initialization
        var map = L.map('view-map').setView([29.996433707724773, 69.6638185265725], 6);

        //osm layer
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);

        // marker add
        var marker = L.marker([29.996433707724773, 69.6638185265725]).addTo(map);
        var circle = L.circle([29.996433707724773, 69.6638185265725], {
            color: 'blue',
            fillColor: '#30f',
            fillOpacity: 0.2,
            radius: 50
        }).addTo(map);

        // search button click
        $('.btn-view-map').click(function() {
            var lat = $('#latitude').val();
            if (lat == "") {
                toastr.error("Please enter latitude values.");
                return;
            }

            var lng = $('#longitude').val();
            if (lng == "") {
                toastr.error("Please enter longitude values.");
                return;
            }

            lat = parseFloat(lat);
            lng = parseFloat(lng);

            if (isNaN(lat) || isNaN(lng)) {
                toastr.error("Please enter valid numeric latitude and longitude values.");
                return;
            }

            $("#view-map").removeClass('d-none');
            map.setView([lat, lng], 50);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
        });
    });

 

    $(document).on('change' , '#sub_type' , function() {
        var subTypeId = this.value;
        
        if (property_id) {
            getAmenities(subTypeId , property_id);
        } else {
            getAmenities(subTypeId , null);
        }

    });



    function getAmenities(subTypeId , property_id)
    {
        $("#listAmenities").html('');

        $.ajax({
            url: "{{ route('amenities')}}",
            type: "GET",
            data: {
                subTypeId: subTypeId,
                property_id: property_id
            },
            dataType: 'json',
            success: function (result) {
                $("#listAmenities").html(result);
            },
            fail: function(response) {
                console.log(response);
            }
        });
    }

    $(document).on('click' , '.delete-image' , function() {
        var id = $(this).attr('data-id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to remove this image permanently?',
            backgroundDismiss: true,
            buttons: {
                /* confirm: function () {
                    $.alert('Confirmed!');
                },
                cancel: function () {
                    $.alert('Canceled!');
                }, */
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-success',
                    keys: ['enter'],
                    action: function() {
                        $.ajax({
                            url: "{{ route('property.remove-image')}}",
                            type: "GET",
                            data: {
                                id: id,
                            },
                            dataType: 'json',
                            success: function (result) {
                                if (result == 1) {
                                    $('#img-' + id).remove();
                                    $('#btn-' + id).remove();
                                    toastr.success('Image has been removed successfully!');
                                } else {
                                    toastr.error('File not found. Please try again!');
                                }

                            },
                            fail: function(data) {
                                console.log(data);
                            }
                        });
                    }
                },
                no: {
                    text: 'No',
                    action: function(){

                    }
                }
            }
        });
    });

    $(document).ready(function() {
        // Input elements
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Retrieve stored values from localStorage
        const storedLatitude = localStorage.getItem('latitude');
        const storedLongitude = localStorage.getItem('longitude');

        // Pre-fill the input fields if values exist in localStorage
        if (storedLatitude) {
            latitudeInput.value = storedLatitude;
        }
        if (storedLongitude) {
            longitudeInput.value = storedLongitude;
        }

        latitudeInput.addEventListener('blur', function () {
            localStorage.setItem('latitude', latitudeInput.value);
        });

        longitudeInput.addEventListener('blur', function () {
            localStorage.setItem('longitude', longitudeInput.value);
        });

        $('form').on('submit', function() {
            localStorage.removeItem('latitude');
            localStorage.removeItem('longitude');
        });
    });

</script>
@endsection

{{-- Google map code done by Hamza Amjad --}}
{{-- let map;
let marker;
let circle;

function initMap() {
    // Define custom map styles
    var styles = [
        {
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        },
        {
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#616161"
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        }
        // Add more style elements as needed
    ];

    // Initialize the map with custom styles
    map = new google.maps.Map(document.getElementById('view-map'), {
        center: { lat: 28.3949, lng: 84.1240 },
        zoom: 15,
        styles: styles // Apply custom styles
    });

    // Initialize marker
    marker = new google.maps.Marker({
        position: { lat: 28.3949, lng: 84.1240 },
        map: map
    });

    // Initialize circle
    circle = new google.maps.Circle({
        strokeColor: '#0000FF',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#0000FF',
        fillOpacity: 0.2,
        map: map,
        center: { lat: 28.3949, lng: 84.1240 },
        radius: 50
    });

    // Search button click
    $('.btn-view-map').click(function() {
        var lat = $('#latitude').val();
        var lng = $('#longitude').val();

        if (lat === "") {
            toastr.error("Please enter latitude values.");
            return;
        }

        if (lng === "") {
            toastr.error("Please enter longitude values.");
            return;
        }

        lat = parseFloat(lat);
        lng = parseFloat(lng);

        if (isNaN(lat) || isNaN(lng)) {
            toastr.error("Please enter valid numeric latitude and longitude values.");
            return;
        }

        var newLatLng = new google.maps.LatLng(lat, lng);
        map.setCenter(newLatLng);
        marker.setPosition(newLatLng);
        circle.setCenter(newLatLng);
    });
}

// Ensure the initMap function is called after the API is loaded
window.initMap = initMap; --}}
