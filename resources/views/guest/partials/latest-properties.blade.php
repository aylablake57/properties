<div class="latest-properties">
    <h4 class="widget-title">Latest Properties</h4>
    <ul>
        <li class="widget-container">

            <div class="latest-listings">
                @foreach (getLatestProperties() as $property)
                <div class="latest-internal mb-4">
                    <div class="latest-image">
                        <a href="{{ route('property-details' , 'id=' . $property->id) }}">
                            <img src="{{ showPropertyImage($property) }}"  alt="Property Detail">
                        </a>
                    </div>
                    <div class="listing-name ">
                        <span class="title">
                            <a href="{{ route('property-details' , 'id=' . $property->id) }}">{{ \Str::limit($property->title , 30)}}</a>
                        </span>
                        <span class="price">{{ toCurrency($property->price, "PKR") }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </li>
    </ul>
</div>