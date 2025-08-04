<!-- resources/views/components/phone-input.blade.php, 2) phone number regular expression updated by Hamza Amjad, so that number will start from 3 -->
<div class="input-group mb-3">
    <span class="input-group-text">+92</span>
    <input
        type="tel"
        id="phone"
        class="form-control"
        placeholder= '{{ $placeholder ? $placeholder : "Your Phone" }}'
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        aria-label="mobile_number"
        aria-describedby="basic-addon1"
        maxlength="10"
        pattern="^3\d{9}$"
        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
        data-bs-toggle="tooltip" data-bs-title="Enter your mobile phone number without spaces. For example 3xxxxxxxxx"
    >
</div>
@error($name)
<span class="text-danger fs-12">{{ $message }}</span>
@enderror
