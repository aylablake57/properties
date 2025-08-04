@include('property.partials.message')
<style>
    #starRating span {
        font-size: 2rem;
        cursor: pointer;
    }

    #starRating span.checked {
        color: #a0af50 !important;
    }

    /* Modal styling added by Asim */
    .modal-btn-main{
        background-color: #a0af50;
        color: white !important;
        border-color: #a0af50 !important;
        width: 100px;
    }

    .modal-btn-main:hover{
        background-color: #6b7e00;
        border-color: #6b7e00 !important;
    }

    .modal-btn-outlined{
        background-color: white;
        color: #a0af50 !important;
        border-color: #a0af50 !important;
        width: 100px;
    }

    .modal-btn-outlined:hover{
        background-color: #6b7e00;
        border-color: #6b7e00 !important;
        color: white !important;
    }

    .review-btn-main{
        background-color: #a0af50;
        color: white !important;
        border-color: #a0af50 !important;
    }

    .review-btn-main:hover{
        background-color: #6b7e00;
        border-color: #6b7e00 !important;
    }

    .form-control{
        border-color: #a0af50 !important;
    }
</style>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Name</th>
                <th>Area</th>
                <th>Price</th>
                <th>City</th>
                <th>Location</th>
                <th>Approval</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listings as $listing)
            <tr>
                <th scope="row">{{ $listing->id }}</th>
                <td>{{ $listing->title }}</td>
                <td>{{ $listing->subtype?->name ?? 'Unknown Subtype' }}</td>
                <td>{{ $listing->area_size . ' - ' . str_replace("_", " ", $listing->area_unit?->name ?? 'Unknown Unit') }}</td>
                <td>{{ 'PKR ' . ($listing->price ?? 'N/A') }}</td>
                <td>{{ $listing->city?->name ?? 'Unknown City' }}</td>
                <td>{{ $listing->location?->name ?? 'Unknown Location' }}</td>
                <td>
                    @php
                        $statusClass = match($listing->publish_status) {
                            'Approved' => 'success',
                            'Pending' => 'warning',
                            'Cancel' => 'danger',
                            default => 'secondary',
                        };
                        $statusText = $listing->publish_status == 'Cancel' ? 'Cancelled' : ($listing->publish_status ?? 'Unknown Status');
                    @endphp
                    <span class="badge text-bg-{{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td>
                    @php
                        $isApproved = $listing->publish_status == 'Approved';
                        $isSold = $listing->is_sold;
                        $isChecked = $isSold ? 'checked' : '';
                        $statusBadge = $isSold ? 'success' : 'warning';
                        $statusText = $isSold ? 'Sold' : 'Available';
                        $tooltip = !$isSold ? 'data-bs-toggle="tooltip" data-bs-title="If your property has been sold, click here!"' : '';
                    @endphp

                    <div class="form-check form-switch">
                        <input class="form-check-input isSold" type="checkbox" role="switch"
                               id="isSold_{{ $listing->id }}" data-id="{{ $listing->id }}"
                               {{ $isChecked }} {{ !$isApproved ? 'disabled' : '' }} {!! $tooltip !!}>
                        <span class="badge text-bg-{{ $statusBadge }}">{{ $statusText }}</span>
                    </div>
                </td>

                <td class="text-center">
                    <a href="{{ route('property.form', ['id' => $listing->id]) }}" data-bs-toggle="tooltip" data-bs-title="Edit your property info">
                        <i class="fa fa-edit text-success py-1"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for property sold confirmation -->
<div class="modal pt-5 fade" id="soldModal" tabindex="-1" aria-labelledby="soldModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="soldModalLabel"><img src="{{ asset('assets/images/icons/confirmation.png') }}" alt="Properties" class="img-fluid pe-3">Property Sold Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal styled and connected to database by Asim-->
            <div class="modal-body">
                <p>Was the property sold via DHA360 Platform?</p>
                <div class="container">
                    <div class="row ">
                        <button id="confirmSoldDHA360" class="btn btn-primary modal-btn-main border me-2">Yes</button>
                        <button id="confirmNotDHA360" class="btn btn-secondary modal-btn-outlined border" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
                <div id="ratingSection" class="mt-4" style="display:none;">
                    <p>Rate your experience:</p>
                    <div id="starRating">
                        <input type="hidden" id="authUserId" value="{{ auth()->user()->id }}">
                        <span class="fa fa-star feedbackstar" data-value="1"></span>
                        <span class="fa fa-star feedbackstar" data-value="2"></span>
                        <span class="fa fa-star feedbackstar" data-value="3"></span>
                        <span class="fa fa-star feedbackstar" data-value="4"></span>
                        <span class="fa fa-star feedbackstar" data-value="5"></span>
                    </div>
                </div>
                <!-- Review Message Section added by Asim (Activates when star reviews are filled) -->
                <div id="reviewMessageField" class="mt-3" style="display:none;">
                    <label for="reviewMessage" class="mb-2">Leave us a review:</label>
                    <textarea id="reviewMessage" name="comment" class="form-control border" rows="4" placeholder="Share your thoughts..."></textarea>
                    <button id="submitReview" class="btn btn-primary review-btn-main border mt-3" type='submit'>Submit Review</button>
                </div>
            </div>
        </div>
    </div>
</div>
