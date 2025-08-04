@extends('layouts.app')
@section('title') Property Requests for Approvals @endsection
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
            <div class="widget-container bg-white p-3">
                {{-- <h6>Recent Properties for Approvals</h6> --}}

                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
                {{-- <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Added On</th>
							<th>Owner</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Price</th>
                            <th>City</th>
                            <th>Location</th>
                            <th>Purpose</th>
							<th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newProperties as $property)
                            <tr>
								<td>{{ date('d-m-Y' , strtotime($property->created_at)) }}</td>
								<td class="text-capitalize">{{ $property->user->name }}</td>
                                <td>{{ $property->subtype->name }}</td>
                                <td>{{ $property->area_size . ' - ' . str_replace("_", " ", $property->area_unit->name) }}</td>
                                <td>{{ 'PKR ' . $property->price }}</td>
                                <td>{{ $property->city->name }}</td>
                                <td>{{ $property->location->name }}</td>
                                <td>{{ ucwords($property->purpose) }}</td>
								<td>
									<a href="{{ route('property.form', ['id' => $property->id]) }}">
										<i class="fa fa-edit"></i>
									</a>
								</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush