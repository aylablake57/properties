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
<div class="table-responsive">
    <table class="table table-hover" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Status</th>
                <th>Created On</th>
                <th>Expires At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listings as $listing)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                <img src="{{  env('FTP_BASE_URL') . '/' . $listing->file_name }}" class="img-thumbnail img-fluid" width="250px" alt="Properties">
                </td>

                @if($listing->status === 'approved')
                <td><span class="badge text-bg-success">Approved</span></td>
                @elseif ($listing->status === 'pending')
                <td><span class="badge text-bg-warning">Pending</span></td>
                @else
                <td><span class="badge text-bg-danger">Cancelled</span></td>
                @endif
                <td>{{ date('d-m-Y' , strtotime($listing->created_at)) }}</td>
                <td>{{ $listing->expiry_date ? date('d-m-Y', strtotime($listing->expiry_date)) : '' }}</td>
                <td>
                    <a href="{{ route('ad.form', ['id' => $listing->id]) }}" class="text-success">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="javascript:;" class="delete text-danger" data-id="{{ $listing->id }}">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="modalConfirmation" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This will permanently delete your Ad. Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('ad.delete') }}" method="post">
                        @csrf
                        <input type="hidden" id="ad_id" name="ad_id">
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Yes</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('componenet_script')
    <script>
        $(document).on('click' , '.delete' , function() {
            $('#ad_id').val($(this).attr('data-id'));
            $('#modalConfirmation').modal('show');
        })
    </script>
@endsection
