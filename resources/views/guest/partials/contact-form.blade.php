<form method="post" action="{{ url('send-contact#sectionContact') }}">
    @csrf
    @if (session('check_contact'))
        {!! session('check_contact') !!}
    @endif
    <div class="row">
        <div class="col-sm-6 mb-3">
            <input type="text" class="form-control" name="name" placeholder="Your Name *" value="{{ old('name') }}"
                required>
            @error('name')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <input type="email" class="form-control" name="email" placeholder="Your Email *"
                value="{{ old('email') }}" required>
            @error('email')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <x-phone-input name="mobile" value="{{ old('mobile') }}" placeholder="Your Phone *" />
        </div>
        {{-- Dropdown started by Hamza Amjad --}}
        <div class="col-sm-6 mb-3">
            <select class="form-select" id="complaintType" name="complaintType" required>
                <option value="" disabled selected>Select Reason *</option>
                <option value="property-inquiry">Property Inquiry</option>
                <option value="registration-issues">Registration Issues</option>
                <option value="payment-issues">Payment Issues</option>
                <option value="maintenance-issues">Maintenance Requests</option>
                <option value="general-feedback">General Feedback</option>
                <option value="customer-service">Customer Service</option>
                <option value="other">Other</option>
            </select>
            @error('complaintType')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        {{-- Dropdown end --}}

        <div class="col-sm-12 mb-3">
            <x-textarea name="message" id="message" placeholder="Message *" maxlength="1500" required="true"
                value="{{ old('message') }}" />
        </div>
        <div class="col-sm-4 justify-content-start pt-4">
            <button name="submit" type="submit" class="btn btn-accent">Send Email</button>
        </div>
    </div>
</form>
