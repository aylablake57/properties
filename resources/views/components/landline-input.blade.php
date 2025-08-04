<label for="landline">Landline Number:</label>
<input 
    type="tel"
    id="landline" 
    name="landline"  
    value="{{ old('landline', $value) }}" 
    class="form-control"
    pattern="\d{11,12}"
    maxlength="12" 
    placeholder="Your Landline No."  
    title="Please enter a valid landline number (11 or 12 digits)"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
>
@error('landline')
    <span class="text-red-500 fs-12">{{ $message }}</span>
@enderror

@section('component_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const landlineInput = document.getElementById('landline');

            landlineInput.addEventListener('input', function(e) {
                // Replace any non-numeric character
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@endsection