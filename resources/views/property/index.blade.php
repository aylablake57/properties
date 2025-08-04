@extends('layouts.app')
@section('title') @endsection
@section('page')
    <header class="pagetitle">
        <h1>{{ __('My Properties') }}</h1>
    </header>

    @include('partials.property-list')
@endsection