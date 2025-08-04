@extends('layouts.app')
@section('page')
    <header name="header">
        <h2>{{ __('Packages') }}</h2>
    </header>

    <div class="my-3 main">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    @include ('shop.partials.packages')

                    @include ('shop.partials.refreshers')
                </div>
                <div class="col-lg-4">
                    <div class="p-3 bg-white">
                        <h5 class="pb-3 text-dark">Order Summary</h5>

                        @php $total = 0 @endphp
                        @if(session()->has('cart') && !empty(session('cart')))
                            @foreach ($cart as $id=>$item)
                                @php $total += $item['price'] * $item['quantity'] @endphp
                                <div class="pt-3 items-list d-flex justify-content-between">
                                    <h6>Item #{{$loop->iteration}}</h6>
                                    <h6>{{$item['name']}} ({{$item['quantity']}})</h6>
                                </div>
                            @endforeach
                        @endif

                        <div class="pt-3 mb-4 totals border-top d-flex justify-content-between">
                            <h5 class="text-dark">Total:</h5>
                            <h5 class="text-dark">PKR {{$total}}</h5>
                        </div>
                        <a href="{{ route('shop.cart') }}" class="btn btn-accent" onclick="event.preventDefault();">Checkout</a>
                        <span class='text-danger fs-12 text-center'><b>You cannot make any transactions during current promotional period.</b></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
