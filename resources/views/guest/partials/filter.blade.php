<div class="col bg-light p-2 border rounded">
    <div class="justify-content-between d-flex mt-3">
        <span id="applyFiltersBtn" class="model-filter-span">Filters <i class="fa-solid fa-angle-down ps-1" aria-hidden="true"></i></span>
        <h5 class="right-most text-end mr-5">{{ $properties->count() . ' ' . \Str::plural('Property', $properties->count()) }} </h5>
    </div>
    <div class="container mt-3" id="filtersSection" style="display: none;">
        <form action="{{ route('search', ['city'=>2]) }}" method="get">
            <div class="section-content">
                @foreach (getAmenities() as $title => $amenity)
                    @if ($title == 'Features')
                        <div class="row mt-3">
                            <h6>{{ $title }}</h6>
                            <div class="col-sm-12">
                                <div class="row">
                                    @foreach ($amenity as $key => $data)
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-check custom-checkbox">
                                                <input class="form-check-input" type="checkbox" id="{{ $key . '-' . $data['id'] }}" name="amenities[{{ $data['id'] }}]" value="true">
                                                <label class="form-check-label" for="{{ $key . '-' . $data['id'] }}">{{ $data['value'] }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="text-end offset-lg-8 mt-3">
                <button type="submit" class="btn btn-accent">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        const filtersSection = document.getElementById('filtersSection');
        applyFiltersBtn.addEventListener('click', function() {
            if (filtersSection.style.display === 'none' || filtersSection.style.display === '') {
                filtersSection.style.display = 'block';
            } else {
                filtersSection.style.display = 'none';
            }
        });
    });
</script>