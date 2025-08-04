@isset($city)

@php 
    if ($city->name == 'DHA City Karachi') {
        $iconUrl = asset('assets/images/icons/karachi.png');
    } else {
        $iconName = explode(" ", $city->name);
        
        $iconUrl = asset('assets/images/icons/'.strtolower($iconName[1]).'.png');
    }
@endphp
<div class="text-center col mb-3">
    <a href="{{ route('search', ['city' => $city->id]) }}">
        
        {{-- <div class="d-flex flex-row justify-content-between"> --}}
        <div class="places" style="background-image: url( {{$iconUrl}} );"></div>
        <div class="place-details">
            <h4>{{ $city->name }}</h4>
            <div class="listing-count">
            {{ $city->properties_count . ' ' . \Str::plural('listing', $city->properties_count) }}
            </div>
        </div>
    </a>
</div>

{{-- <div class="short-col col-md-6 col-lg-6 col-xl-4  mb-4 text-center">
    <a href="{{ route('search', ['city' => $city->id]) }}"> --}}
        
        {{-- <div class="d-flex flex-row justify-content-between"> --}}
            {{-- <div class="places me-3" style="background-image: url( {{$iconUrl}} );"></div>
            <div class="place-details">
                <h4>{{ $city->name }}</h4>
                <div class="listing-count">
                {{ $city->properties_count . ' ' . \Str::plural('listing', $city->properties_count) }}
                </div>
            </div> --}}

            {{-- <div class="city-info d-flex flex-column align-items-center justify-content-center">
                <div class="places" style="background-image: url( {{$iconUrl}} );"></div>
                <div class="listing-count">
                    {{ $city->properties_count . ' ' . \Str::plural('listing', $city->properties_count) }}
                </div>
            </div>

            <div class="place-details">
                <div id="chart-container-{{ $city->id }}" class="city-chart"></div>
                
            </div> --}}
        {{-- </div> --}}
    {{-- </a>
</div> --}}
@endisset