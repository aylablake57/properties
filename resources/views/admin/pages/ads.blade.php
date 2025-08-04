@extends('layouts.app')

@section('title')
    Ads Requests for Approvals
@endsection

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
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>

{{-- Approval Confirmation Modal --}}
<div id="modalConfirmation" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Ad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you want to approve this Ad?</p>
            </div>
            <div class="modal-footer">
                <form id="approvalForm" action="{{ route('admin.ads.approval') }}" method="POST">
                    @csrf
                    <input type="hidden" id="approval_ad_id" name="ad_id" value="">
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Yes</button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

{{-- Cancellation Modal --}}
<div id="cancelModal" class="modal fade" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.ads.approval') }}" id="cancelForm">
                    @csrf
                    <input type="hidden" id="cancel_ad_id" name="ad_id" value="">
                    <input type="hidden" name="status" value="cancel">

                    <label for="cancel_reason" class="my-3">Why do you want to cancel this ad?</label>
                    <x-textarea
                        name="cancel_reason"
                        id="message"
                        placeholder="Message"
                        maxlength="1500"
                        required="true"
                    />

                    <!-- Display validation errors -->
                    @if ($errors->has('cancel_reason'))
                        <div class="alert alert-danger mt-2">
                            {{ $errors->first('cancel_reason') }}
                        </div>
                    @endif

                    <!-- Loader -->
                    <div id="loader" class="text-center mt-3" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirmCancel">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    <script>
        function handleApproveClick(id) {
            document.getElementById('approval_ad_id').value = id;
            var modal = new bootstrap.Modal(document.getElementById('modalConfirmation'));
            modal.show();
        }

        function handleCancelClick(id) {
            document.getElementById('cancel_ad_id').value = id;
            var modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        }

        document.getElementById('confirmCancel').addEventListener('click', function () {
            document.getElementById('cancelForm').submit();
        });
    </script>
@endpush
