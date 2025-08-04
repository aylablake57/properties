@php
    if ($property) {
        $email = $property->email;
        $phone = str_replace("92" , "" , $property->phone);
        $landline = $property->landline;
    } else {
        $email = old('email') ? old('email') : auth()->user()->email;
        $phone = old('phone') ? old('phone') : str_replace("92" , "" , auth()->user()->phone);
        $landline = old('landline') ? old('landline') : auth()->user()->landline;
    }
@endphp
<div class="section-title">Contact Details</div>
<div class="section-content">
    <div class="row">
        <div class="col-sm-4 mb-3">
            <label for="title">Email <span class="text-danger fs-12">*(Mandatory)</span></label>
            <input type="email" class="form-control" name="email" value="{{ $email }}" required placeholder="Enter your email where you want to be contacted">
            @error('email')
                <span class='text-danger fs-12'>{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-sm-4 mb-3">
            <label for="title">Phone <span class="text-danger fs-12">*(Mandatory)</span></label>
            <x-phone-input name="phone" pattern="^0?3\d{9}$" value="{{ $phone }}" required="true" placeholder="Your Phone"/>
        </div>

        <div class="col-sm-4 mb-3">
            <x-landline-input name="landline"/>
        </div>
    </div>
</div>