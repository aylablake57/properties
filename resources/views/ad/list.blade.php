@extends('layouts.app')
@section('page')
    <header name="header">
        <h2>{{ __('My Ads') }}</h12>
    </header>

    @include('partials.ad-list')

@endsection
