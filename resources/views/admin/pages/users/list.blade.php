@extends('layouts.app')
@section('title') Users List @endsection
@section('page')
<div class="main">
    <hr>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <div class="tab-content">
            {{-- Replace table with a div block styled like a table --}}
            <div class="d-none d-md-flex font-weight-bold bg-light p-2">
                <div class="col-md-1">#</div>
                <div class="col-md-2">Name</div>
                <div class="col-md-3">Email</div>
                <div class="col-md-2">Phone</div>
                <div class="col-md-2">City</div>
                <div class="col-md-2 text-center">Action</div>
            </div>
            <div class="row">
                @foreach ($users as $user)
                <div class="col-12 mb-2">
                    <div class="d-flex flex-column flex-md-row align-items-center border p-2">
                        <div class="col-12 col-md-1">
                            <strong>{{ $loop->iteration }}</strong>
                        </div>
                        <div class="col-12 col-md-2">
                            <strong class="d-md-none">Name:</strong> {{ $user->name }}
                        </div>
                        <div class="col-12 col-md-3">
                            <strong class="d-md-none">Email:</strong> {{ $user->email }}
                        </div>
                        <div class="col-12 col-md-2">
                            <strong class="d-md-none">Phone:</strong> {{ $user->phone }}
                        </div>
                        <div class="col-12 col-md-2">
                            <strong class="d-md-none">City:</strong> {{ $user->city->name }}
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <a href="{{ route('admin.users.form', ['id' => $user->id]) }}" class="btn btn-sm btn-success">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection