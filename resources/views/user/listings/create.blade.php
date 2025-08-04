<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Add Listing') }}</h2>
    </x-slot>

    <div class="main my-5">
        <div class="container">
            <div class="navigation-container">
                <a href="#" class="active" data-id="1">1. Sell</a>
                <a href="#" data-id="2">2. Rent</a>
            </div>
            <div class="tab-content">
                @if (session('listing_add_status'))
                    {!! session('listing_add_status') !!}
                @endif
                <form action="{{url('/add_listing')}}" method="POST">
                    @csrf
                    <div class="section-title">Types & Sub-Types</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="property_type" class="form-label">*Property Type (mandatory) </label>
                                <select class="form-select" name="property_type">
                                    <option value="0" disabled>Please Select</option>
                                    @foreach($property_types as $row)
                                        <option value="{{$row->id}}" <?=(old('property_type') == $row->id ? "selected" : "")?>>{{$row->name}}</option>
                                    @endforeach
                                </select>
                                @error('property_type')
                                    <br/><span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="property_subtype" class="form-label">*Property Sub-Type (mandatory) </label>
                                <select class="form-select" name="property_subtype">
                                    <option value="0" selected disabled>Please Select</option>
                                    <option value="Residential" <?=(old('property_type') == "Residential" ? "selected" : "")?>>Residential</option>
                                    <option value="Commercial" <?=(old('property_type') == "Commercial" ? "selected" : "")?>>Commercial</option>
                                    <option value="Agricultural" <?=(old('property_type') == "Agricultural" ? "selected" : "")?>>Agricultural</option>
                                    <option value="Industrial" <?=(old('property_type') == "Industrial" ? "selected" : "")?>>Industrial</option>
                                    <option value="Plot File" <?=(old('property_type') == "Plot File" ? "selected" : "")?>>Plot File</option>
                                </select>
                                @error('property_subtype')
                                    <br/><span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="section-title">Location</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label for="address" class="form-label">*Address </label>
                                <input type="text" id="address" class="form-control" name="address" value="{{old('address')}}">
                                @error('address')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="country" class="form-label">Country </label>
                                <select class="form-select dropdown" name="country">
                                    <option value="0" disabled>None</option>
                                    <option value="pakistan" selected>Pakistan</option>
                                </select>
                                @error('country')
                                    <br/><span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="city" class="form-label">City </label>
                                <select class="form-select dropdown" name="city">
                                    <option value="Bahawalpur" <?=(old('city') == "Bahawalpur" ? "selected" : "")?>>Bahawalpur</option>
                                    <option value="Gujranwala" <?=(old('city') == "Gujranwala" ? "selected" : "")?>>Gujranwala</option>
                                    <option value="Islamabad" <?=(old('city') == "Islamabad" ? "selected" : "")?>>Islamabad</option>
                                    <option value="Karachi" <?=(old('city') == "Karachi" ? "selected" : "")?>>Karachi</option>
                                    <option value="Lahore" <?=(old('city') == "Lahore" ? "selected" : "")?>>Lahore</option>
                                    <option value="Multan" <?=(old('city') == "Multan" ? "selected" : "")?>>Multan</option>
                                    <option value="Peshawar" <?=(old('city') == "Peshawar" ? "selected" : "")?>>Peshawar</option>
                                    <option value="Quetta" <?=(old('city') == "Quetta" ? "selected" : "")?>>Quetta</option>
                                </select>
                                @error('city')
                                    <br/><span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="area" class="form-label">Area </label>
                                <select class="form-select dropdown" name="area">
                                    @foreach($property_locations as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                @error('area')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="latitude" class="form-label">Latitude (for Google Maps) </label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{old('latitude')}}">
                                @error('latitude')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="longitude" class="form-label">Longitude (for Google Maps) </label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{old('longitude')}}">
                                @error('latitude')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="google_street" class="form-label">Google Street View - Camera Angle (value from 0 to 360) </label>
                                <input type="text" id="google_street" class="form-control" name="google_street" value="{{old('google_street')}}">
                                @error('latitude')
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
                    <hr>
                    <div class="section-title">Size & Price</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="title" class="form-label">*Size </label>
                                <div class="row">
                                    <div class="col-sm-8 mb-3">
                                        <input type="text" id="address" class="form-control" name="size_value" value="{{old('size_value')}}">
                                        @error('size_value')
                                            <span class='text-danger fs-12'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <select class="form-select" name="size_name">
                                            @foreach($property_areas as $row)
                                                <option value="{{$row->size_name}}" <?=(old('size_name') == $row->id ? "selected" : "")?>>{{$row->unit}}</option>
                                            @endforeach
                                        </select>
                                        @error('size_name')
                                            <br/><span class='text-danger fs-12'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title" class="form-label">*Price </label>
                                <div class="row">
                                    <div class="col-sm-8 mb-3">
                                        <input type="text" id="price" class="form-control" name="price" value="{{old('price')}}">
                                        @error('price')
                                            <span class='text-danger fs-12'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <select class="form-select">
                                            <option value="PKR" disabled selected>PKR</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Installments Available</label>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Ready for Possession</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="section-title">Amenities & Features</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="title" class="form-label">Features </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Possession</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Disputed</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Electricity</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Sui Gas</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Irrigation</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Tube Wells</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Accessible By Road</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Perimeter Fencing</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Boundary Lines</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Land Fertility</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="title" class="form-label">Nearby Facilities </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Schools</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Hospitals</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Colleges</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Resturants</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Airport</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="chkPossession">
                                    <label class="form-check-label" for="chkPossession">Public Transport</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="title" class="form-label">Others </label>
                                <div class="col-sm-6 mb-3">
                                    <label for="security" class="form-label">Security</label>
                                    <input type="text" id="security" class="form-control" name="security" value="{{old('security')}}">
                                    @error('security')
                                        <span class='text-danger fs-12'>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="other_facility" class="form-label">Other Facility</label>
                                    <input type="text" id="other_facility" class="form-control" name="other_facility" value="{{old('other_facility')}}">
                                    @error('other_facility')
                                        <span class='text-danger fs-12'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="section-title">Ad Details</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label for="title" class="form-label">*Title </label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-12 mb-3">

                                <label for="description" class="form-label">Description </label>
                                <!--Commented by Yousaf
                                <textarea id="description" class="form-control" rows="3" name="description" value="{{old('description')}}"></textarea>
                                @error('description')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror -->
                                <label for="description" class="form-label">Description</label>
                                <x-textarea 
                                    name="description" 
                                    id="description" 
                                    placeholder="Describe your property in 1500 characters * " 
                                    maxlength="1500" 
                                    required="true">{{ old('description') }}</x-textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="section-title">Media</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="title" class="form-label">Upload Images</label>
                                <input type="file" class="form-control" name="pictures" id="pictures">
                                @error('pictures')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title" class="form-label">Upload videos</label>
                                <input type="file" class="form-control" name="videos" id="videos">
                                @error('videos')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="section-title">Contact</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="address" class="form-label">*Email </label>
                                <input type="email" id="email" class="form-control" name="email" value="{{old('email')}}">
                                @error('email')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="phone" class="form-label">Mobile </label>
                                    <x-phone-input name="phone" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-landline-input name="landline" />
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-6 offset-6 text-end">
                            <button class="btn btn-accent">Submit Listing</button>
                        </div>
                    </div>
                </form>
                {{-- <div class="section-title">Size & Price</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                --}}
                {{-- <div class="tab-content">
                    <div class="step-1">
                        <div class="section-title">Property Description</div>
                        <div class="mb-3">
                            <label for="title">*Title (mandatory) </label>
                            <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                        </div>
                        <div class="mb-3">
                            <label for="title">Description </label>
                            <input type="text" id="title" class="form-control" value="" rows="6" cols="40" name="wpestate_title">
                        </div>
                        <div class="section-title">Property Price</div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">After Price Label (ex: "/month") </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Before Price Label (ex: "from ") </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="title">Price in PKR (only numbers) </label>
                                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_title">
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</x-app-layout>

@section('page_script')
@endsection