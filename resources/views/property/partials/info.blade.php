<div class="d-flex justify-content-between">
    <div class="section-title">Property Info</div>
    {{-- @if ($property)
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="isSold" name="isSold">
        <label class="form-check-label" for="isSold">Has been sold</label>
    </div>
    @endif --}}
</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="title">Property Category <span class="text-danger fs-12">*(Mandatory)</span></label>
            <select class="form-select" name="type" id="property_type">
                <option value="" selected disabled>Please Select</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected($property && $property->propertyType?->id == $type->id ?: $type->id == old('type'))>
                        {{ str_replace('_', ' ', $type->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6 mb-3">
            <label for="title">Property Type <span class="text-danger fs-12">*(Mandatory)</span></label>
            <select class="form-select" name="subtype" id="sub_type"
                data-old="{{ old('subtype', $property->subtype->id ?? '') }}" data-add-property="true">
                <option value="" selected disabled>Please Select</option>

            </select>
            @error('subtype')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 mb-3">
            <label for="title">Title <span class="text-danger fs-12">*(Mandatory)</span></label>
            <input type="text" class="form-control" id="title" name="title"
                value="{{ $property ? $property->title : old('title') }}"
                placeholder="Enter your ad title e.g Corner Plot in DHA Phase 8">
            @error('title')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 mb-3">
            <label for="title">Description <span class="text-danger fs-12">*(Mandatory)</span></label>

            <x-textarea name="description" id="property_description"
                placeholder="Describe your property, it's size, area, features etc" maxlength="1500" required="true"
                value="{{ $property ? $property->description : old('description') }}" />
        </div>
    </div>
</div>
<hr>
<div class="section-title">Property Pictures</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="title">Featured Image <span class="text-danger fs-12">*(Mandatory)</span></label>
            @if ($property)
                <span class="text-danger fs-12 ms-lg-3">Choosing new file for featured image, will remove the previous
                    file automatically!</span>
            @endif
            @if ($property && $property->featured_image)
                <br>
                <img src="{{ env('FTP_BASE_URL') . '/' . $property->featured_image }}" class="img-thumbnail mb-3"
                    width="200px" alt="Properties" />
            @endif

            <input type="file" class="form-control" name="featured_image" accept="image/*"
                {{ $property ? '' : 'required' }}>


            @error('featured_image')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
            <br>
            <label for="title">Other Images</label>
            @if ($property)
                <span class="text-danger fs-12 ms-lg-3">Choosing new files will be added to gallery. To remove
                    previously added image, click on cross button next to image!</span>
            @endif
            @if ($property && $property->media->isNotEmpty())
                <div class="row">
                    @foreach ($property->media as $media)
                        @if ($media->type != 'featured_image')
                            <div class="col-sm-4 d-flex justify-content-start">
                                <!-- Corrected image path for each media -->
                                <img src="{{ env('FTP_BASE_URL') . '/' . $media->file_path }}"
                                    class="img-thumbnail mb-3" width="200px" id="img-{{ $media->id }}"
                                    alt="{{ $media->file_name }}" />

                                <button type="button" class="btn-close delete-image" style="background-size: 50%;"
                                    data-id="{{ $media->id }}" data-bs-toggle="tooltip"
                                    data-bs-title="Remove this image" aria-label="Close"
                                    id="btn-{{ $media->id }}"></button>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            <input type="file" class="form-control" name="media[]" multiple accept="image/*">
            @error('media')
                <span class='text-danger fs-12'>{{ $media }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label>Tips</label>
            <ul>
                <li>Featured image will be shown at top of your ad</li>
                <li>Other images will create a gallery for your property</li>
                <li>Ads with pictures get 5x more views.</li>
                <li>Upload good quality pictures</li>
                <li>Max size 1MB, .jpg .png only</li>
                <li>Minimum dimensions of image should be 110 x 68</li>
            </ul>
        </div>
    </div>
</div>

<!-- Code added by Asfia Aiman -->
<hr>
<div class="section-title">Property Video Link</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="video_link">Video Link <span class="text-danger fs-12"></span></label>
            @if ($property)
                <span class="text-danger fs-12 ms-lg-3">Entering new link for video, will remove the previous video link
                    automatically!</span>
            @endif

            <input type="url" class="form-control" name="video_link"
                placeholder="Enter the url of the video from any source"
                value="{{ $property ? $property->video_link : old('video_link') }}">

            @error('video_link')
                <span class='text-danger fs-12'>{{ $video_link }}</span>
            @enderror
            <br>
        </div>
        <div class="col-sm-6 mb-3">
            <label>Steps</label>
            <ol>
                <li>Create a clear and detailed video</li>
                <li>Upload the video on Youtube, Tiktok or any other patform</li>
                <li>Right click in the center of the video frame, copy the embed code of the video and paste it in the
                    adjacent textbox</li>
                <li> YouTube links are recommended and preferred for optimal performance and seamless integration. </li>
            </ol>
        </div>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const propertyTypeSelect = document.getElementById('property_type');
        const subtypeSelect = document.getElementById('sub_type');
        const oldSubtypeId = subtypeSelect.getAttribute('data-old');
        function populateSubtypes(typeId, selectedSubtypeId = null) {
            console.log('Type ID:', typeId);
            console.log('Selected Subtype ID:', selectedSubtypeId);

            $.ajax({
                url: "{{ route('subtypes') }}",
                method: 'GET',
                data: {
                    property_type_id: typeId
                },
                success: function(response) {
                    response.forEach(subtype => {
                        let option = document.createElement('option');
                        option.value = subtype.id;
                        option.textContent = subtype.name.replace('_', ' ');

                        // Ensure selected attribute is set correctly
                        if (selectedSubtypeId && parseInt(selectedSubtypeId) === parseInt(subtype.id)) {
                            option.selected = true; // Directly set the 'selected' property
                            console.log('Setting selected for ID:', subtype.id);
                        }
                        subtypeSelect.appendChild(option);
                    });

                },
                error: function(error) {
                    console.error('Error fetching subtypes:', error);
                }
            });
        }

        // On type change, fetch and populate subtypes
        propertyTypeSelect.addEventListener('change', function() {
            const typeId = this.value;
            populateSubtypes(typeId);
        });

        // On page load (for editing), if property type is already set
        if (propertyTypeSelect.value) {
            populateSubtypes(propertyTypeSelect.value, oldSubtypeId);
        }
    });
</script> --}}
