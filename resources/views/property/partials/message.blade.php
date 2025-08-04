@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('ads_error'))
    <div class="alert alert-danger">
        {{ session('ads_error') }}
    </div>
@endif