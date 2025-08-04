<div class="section-title">Size & Price</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-4 mb-3">
            <label for="title">Area Size <span class="text-danger fs-12">*(Mandatory)</span></label>
            <input type="number" id="area_size" class="form-control" name="area_size" value="{{ $property ? $property->area_size : old('area_size') }}" placeholder="Enter the unit e.g 1" required>
            @error('area_size')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-4 mb-3">
            <label for="title">Unit (e.g Marla) <span class="text-danger fs-12">*(Mandatory)</span></label>
            <select class="form-select" name="area_unit" required>
                <option value="" selected disabled>Please Select</option>
                @foreach($areaUnits as $unit)
                    <option 
                        value="{{ $unit->value }}" 
                        @selected($property && $property->area_unit->value == $unit->value?  : $unit->value == old('area_unit')) 
                    >
                    {{ str_replace('_', ' ', $unit->name) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4 mb-3">
            <label for="title">Price <span class="text-danger fs-12">*(Mandatory)</span></label>
            <div class="input-group">
                <input type="number" id="price" class="form-control" name="price" value="{{ $property ? $property->price : old('price') }}" placeholder="Enter the price of your property" required>
                <span class="input-group-text ms-1">PKR</span>
            </div>
            @error('price')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>

        <div class="col-sm-6 mb-3 mt-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="ready_for_possession" name="ready_for_possession" value="true" @checked($property ? $property->ready_for_possession : old('ready_for_possession') )>
                <label class="form-check-label" for="ready_for_possession">Ready for Possession</label>
            </div>
            <label class="form-check-label" for="ready_for_possession">Enable this option if your property is ready for possession</label>
        </div>
    </div>
</div>