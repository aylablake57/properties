<!-- new file properties.blade.php added by Yousaf in View to Display Approved Properties -->
@extends('layouts.app')
@section('title') All Properties @endsection

@section('page')
<div class="my-3">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-sm-12">
            <div class="widget-container table-responsive bg-white p-3">
                {{ $dataTable->table(['class' => 'table table-bordered']) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
