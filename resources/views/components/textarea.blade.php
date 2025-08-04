<textarea 
    class="form-control" 
    name="{{ $name }}" 
    id="{{ $id }}" 
    placeholder="{{ $placeholder }}" 
    {{ $required ? 'required' : '' }} 
    maxlength="{{ $maxlength }}"
>{{ old($name, $value) }}</textarea>
<div class="d-flex justify-content-between mt-1">
    <small class="text-muted">Max {{ $maxlength }} characters</small>
    <small id="charCount" class="text-muted">0/{{ $maxlength }}</small>
</div>
    
@error($name)
    <span class='text-danger fs-12'>{{ $message }}</span>
@enderror

@section('componenet_script')
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('{{ $id }}');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            const length = textarea.value.length;
            charCount.textContent = `${length}/${textarea.getAttribute('maxlength')}`;
        }

        textarea.addEventListener('input', updateCharCount);
        updateCharCount(); 
    });
</script>
@endsection
