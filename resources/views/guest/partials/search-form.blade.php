<form method="get" action="{{ route('search') }}">
    <div class="row">
        <div class="col justify-content-start mb-3">
            <label for="city" class="form-label">CITY</label>
            <select class="form-select dropdown" name="city" id="city-dropdown">
                {{-- <option value="">Select</option> --}}
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" @selected(isset($search['city']) && $search['city'] == $city->id)>
                        {{ str_replace('_', ' ', $city->name) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col justify-content-center mb-3">
            <label for="area" class="form-label">LOCATION</label>
            <select class="form-select dropdown" name="location" id="location-dropdown">
                <option value="all">All</option>
            </select>
        </div>
        <div class="col justify-content-center mb-3">
            <label for="area" class="form-label">PROPERTY TYPE</label>
            <select class="form-select dropdown" name="type" id="property_type">
                <option value="all">All</option>
                @foreach ($types as $type)
                    @if (isset($search['type']) && $search['type'] == $type->name)
                        <option value="{{ $type->id }}" selected>{{ str_replace('_', ' ', $type->name) }}</option>
                    @elseif(!isset($search['type']) && $type->name == 'plot')
                        <option value="{{ $type->id }}" selected>{{ str_replace('_', ' ', $type->name) }}</option>
                    @else
                        <option value="{{ $type->id }}">{{ str_replace('_', ' ', $type->name) }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col justify-content-center mb-3">
            <label for="area" class="form-label">SUB-TYPE</label>
            <select class="form-select dropdown" name="sub_type" id="sub_type">
                <option value="all">All</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="custom-wrapper">
            <label for="price" class="form-label">PRICE</label>
            <div class="price-input-container d-flex flex-column flex-md-row align-items-center mb-3">
                <div class="price-input d-flex flex-grow-1">
                    <input type="text" id="minPrice" name="min_price" placeholder="PKR 0" class="min-input form-control">
                    <span class="text-center mt-1 mx-2">to</span>
                    <input type="text" placeholder="Any" id="maxPrice" name="max_price" class="max-input form-control">
                </div>
            </div>
            {{-- Hint-text added to display price in Lakh or Crore --}}
            <div class="price-hints d-flex justify-content-between">
                <p><span id="minPriceHint" class="price-hint">0</span> to <span id="maxPriceHint" class="price-hint">Any</span></p>
            </div>
            <div class="slider-container">
                <div class="price-slider"></div>
            </div>
            <!-- Slider -->
            <div class="range-input mb-2">
                <input type="range" class="min-range" min="5000000" max="500000000" value="5000000" step="1">
                <input type="range" class="max-range" min="5000000" max="500000000" value="500000000" step="1">
            </div>
        </div>

        <div id="areaFilter" class="col justify-content-center mb-3">
            <label for="area" class="form-label">AREA(Marla)</label>
            <div class="area-wrapper">
                <div class="area-input-container d-flex flex-column flex-md-row align-items-center mb-3">
                    <div class="area-input d-flex flex-grow-1 w-100">
                        <input type="number" placeholder="Min" class="area-min-input form-control" id="areaMinInput"
                            value="0" name="min_area" min="0" max="49">
                        <span class="text-center mt-1 mx-2">to</span>
                        <input type="number" placeholder="Max" class="area-max-input form-control" id="areaMaxInput"
                            value="Any" name="max_area" min="0" max="50">
                    </div>
                </div>
                {{-- Area hint-text added --}}
                <div class="area-hint-text">
                    <p><span id="minAreaHint">0</span> to <span id="maxAreaHint">50</span> Marla</p>
                </div>
                <div class="area-slider-container">
                    <div class="area-range-slider"></div>
                </div>
                <!-- Slider -->
                <div class="area-range-input mb-2">
                    <input type="range" class="area-min-range" min="0" max="49" value="0"
                        step="1">
                    <input type="range" class="area-max-range" min="2" max="50" value="50"
                        step="1">
                </div>
            </div>
        </div>

        <div class="col justify-content-end pt-4">
            <button type="submit" class="btn btn-accent">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </div>
</form>
