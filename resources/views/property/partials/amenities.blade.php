@php
//$propertyAmenities = $property?->amenities?->pluck('amenity_id')->toArray();
@endphp
<div id="listAmenities">
    {{-- @foreach ($amenities as $title => $amenity)
    @if (!$loop->first) <hr> @endif
    <div class="row mt-3">
        <div class="col-sm-4 mb-3">
            <label for="title">{{ $title }}</label>
        </div>
        <div class="col-sm-8">
            <div class="row">
                @foreach ($amenity as $key => $data)
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="{{ $key. '-' . $data['id'] }}" name="amenities[{{ $data['id'] }}]" value="true"
                        @checked($property ? in_array($data['id'], $propertyAmenities) : '' )>
                        <label class="form-check-label" for="{{ $key. '-' . $data['id'] }}">{{ $data['value'] }}</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach --}}
</div>