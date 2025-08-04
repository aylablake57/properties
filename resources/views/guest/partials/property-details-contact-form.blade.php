<form class="mt-3" method="post" action="{{isset($property->user_id) ? url('agents/send-contact-property') : url('agents/send-contact-agent')}}" id="send-contact-form">
    @if (session('check_contact'))
        <div class="alert alert-success">
            {{ session('check_contact') }}
        </div>
    @endif
    @csrf
    @isset($property)
        <input type="hidden" name="id" value="{{$property->user_id}}">
        <input type="hidden" name="property_id" value="{{$property->id}}">
    @endisset

    @isset($user)
        <input type="hidden" name="agent_email" value="{{$user->email}}">
    @endisset
    <div class="mb-3">
        <label for="name">Your Name <span class="text-danger fs-12">*(Mandatory)</span></label>
        <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{old('name')}}" required>
        @error('name')
            <span class='text-danger fs-12'>{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email">Your Email <span class="text-danger fs-12">*(Mandatory)</span></label>
        <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required>
        @error('email')
            <span class='text-danger fs-12'>{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="mobile">Your Mobile <span class="text-danger fs-12">*(Mandatory)</span></label>
        {{-- addon Height fixed by Hamza Amjad --}}
        <!-- Use the PhoneInput Component -->
        <x-phone-input name="mobile" placeholder="Your Phone" value="{{old('mobile')}}" required/>
    </div>
    <div class="mb-3">
        <label for="message">Your Message <span class="text-danger fs-12">*(Mandatory)</span></label>
        <x-textarea 
            name="message" 
            id="message" 
            placeholder="Message" 
            maxlength="1500" 
            required="true"
            value="{{old('message')}}"
        />
    </div>
    <div class="mb-2">
        <label for="type" class="fs-12 me-3">I am a:
        <div class="form-check form-check-inline fs-12 me-1">
            <label class="form-check-label" for="rdTypeBuyer">    
                <input class="form-check-input" type="radio" name="rdType" id="rdTypeBuyer" value="Buyer" checked>
                Buyer
            </label>
        </div>
        <div class="form-check form-check-inline me-1">
            <label class="form-check-label" for="rdTypeAgent">    
                <input class="form-check-input" type="radio" name="rdType" id="rdTypeAgent" value="Property Agent">
                Property Agent
            </label>
        </div>
        <div class="form-check form-check-inline me-1">
            <label class="form-check-label" for="rdTypeOther">    
                <input class="form-check-input" type="radio" name="rdType" id="rdTypeOther" value="Other">
                Other
            </label>
        </div>
    </div>
    <div class="pt-3">
        <button name="submit" type="submit" class="btn btn-accent" id="submitButton">Send Email</button>
    </div>
</form>