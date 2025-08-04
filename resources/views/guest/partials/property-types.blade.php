@php
    // $imageUrl = asset('assets/images/types/' . $property->type->image());
@endphp
<div class="col-sm-4">
    <a href="{{ route('search', ['type' => $property->propertyType]) }}">
    {{-- <div class="type-item" style="background-image: url({{ $imageUrl }});"> --}}
        <div class="overlay"></div>
        <div class="type-content">
            <h4>{{ ucwords($property->propertyType?->name) }}</h4>
            <div class="tagline"></div>
            <div class="listing-count">
            {{ $property->type_count . ' ' . \Str::plural('Listing', $property->type_count) }}
            </div>
        </div>
    </div>
    </a>
</div>
