@extends('layouts.app')
@section('page')
    <div class="p-3 mb-3 bg-white">
        <div class="cart">
            <div class="my-3 row">
                <div class="col-lg-8">
                    <h5 class="pb-3 text-dark">Your Cart</h5>
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Total</td>
                            <td>Remove</td>
                        </tr>
                        @php $total = 0 @endphp
                        @if(session()->has('cart') && !empty(session('cart')))
                            @foreach ($cart as $id=>$item)
                                @php $total += $item['price'] * $item['quantity'] @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item['name']}}</td>
                                    <td> PKR {{ $item['price']}} </td>
                                    <td>
                                        <input type="number" min="1" value="{{ $item['quantity'] }}" data-id="{{$id}}" class="form-control quantity update-cart" />
                                    </td>
                                    <td> PKR {{ $item['price'] * $item['quantity']}} </td>
                                    <td>
                                        <a href="javascript:;" class="remove-from-cart btn btn-sm btn-danger" data-id="{{ $id }}" ><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    </div>
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
                        <button class="btn btn-accent">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
