@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="bg-white p-3 mb-3">
    @foreach ($packages as $package)
        <div class="row {{ ($loop->last) ? '' : 'border-bottom' }} mb-3">
            <div class="col-sm-7">
                <h5 class="text-dark">{{ $package->name }}</h5>
                <p>{!! $package->description !!}</p>
            </div>
            <div class="col-sm-2 pt-3">
                <h6 class="text-dark">RS. {{$package->price}}</h6>
            </div>
            <div class="col-sm-3 pt-2 mb-3">
                <a href="{{ url('shop/add-to-cart', $package->id) }}" class="btn btn-accent w-auto">Add to Cart</a>
            </div>
        </div>
    @endforeach
</div>