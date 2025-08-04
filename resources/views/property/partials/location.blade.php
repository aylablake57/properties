<div class="section-title">Location Details</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="title">City <span class="text-danger fs-12">*(Mandatory)</span></label>
            <select class="form-select dropdown" id="city-dropdown" name="city" required>
                <option value="" selected disabled>Select City</option>
                @foreach ($cities as $city)
                    <option
                        value="{{ $city->id }}"
                        @selected($property && $property->city_id == $city->id?  : $city->id == old('city'))
                    >
                    {{ $city->name }}
                </option>
                @endforeach
            </select>
            @error('city')
                <br/><span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6">
        <label for="title">Location <span class="text-danger fs-12">*(Mandatory)</span></label>
            <select class="form-select dropdown" id="location-dropdown" name="location" required>
            </select>
        </div>

       <div class="col-sm-6 mb-3">
            <label for="title">Address</label>
            <input type="text" id="address" class="form-control" name="address" value="{{ $property ? $property->address : old('address') }}" placeholder="Enter street address of your property if you want.">
            @error('address')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label for="title">Property Number</label>
            <input type="text" class="form-control" name="number" value="{{ $property ? $property->number : old('number') }}" placeholder="Enter your plot number e.g 795 D if you want to mention">
        </div>

        <div class="col-sm-4 mb-3">
            <label for="title">Latitude (for Maps) </label>
            <input type="number" class="form-control" id="latitude" step="any" name="latitude" value="{{$property ? $property->lat : old('latitude')}}">
            @error('latitude')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-4 mb-3">
            <label for="title">Longitude (for Maps) </label>
            <input type="number" class="form-control" id="longitude" step="any" name="longitude" value="{{$property ? $property->lng : old('longitude')}}">
            @error('longitude')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-4 mb-3">
            <label for="title">Street View - Camera Angle </label>
            <input type="text" id="google_street" class="form-control" name="google_street" value="{{$property ? $property->angle : old('google_street')}}">
            @error('google_street')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror

            <div class="text-end">
                <button type="button" class="badge bg-dark btn-view-map">View On Map</button>
            </div>
        </div>

        <div class="col-md-12">
            <div id="view-map"></div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
});

</script>
