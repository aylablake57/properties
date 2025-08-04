<div class="bg-white p-3 mb-3">
    <p>Note: Only applicable on already posted ads</p>
    @foreach ($boosters as $booster)
        <div class="row mb-3">
            <div class="col-sm-7">
                <h5 class="text-dark"> {{ $booster->name }}</h5>
                <p>{{ $booster->description }}</p>
            </div>
            <div class="col-sm-2 pt-3">
                <h6 class="text-dark">RS. {{ $booster->price }}</h6>
            </div>
            <div class="col-sm-3 pt-2">
                <a href="{{ url('shop/add-to-cart', 1) }}" class="btn btn-accent w-auto">Add to Cart</a>
            </div>
        </div>
    @endforeach
</div>