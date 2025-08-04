<!-- By Asfia -->
@extends('layouts.app')
@section('title') Feedback from Agents/Agencies @endsection

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
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>

        function toggleGeneralFeedbackStatus(checkbox) {
            const id = $(checkbox).data('id');
            const currentStatus = checkbox.checked ? 'Published' : 'Draft';

            $.ajax({
                url: '{{ route("admin.requests.generalFeedbacksToggle") }}',
                method: 'POST',
                data: {
                    id: id,
                    status: currentStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Status updated to:', response.new_status);

                        const badgeElement = $(checkbox).next('.badge');
                        badgeElement.text(currentStatus === 'Published' ? 'Published' : 'Draft');
                        badgeElement.removeClass('text-bg-success text-bg-warning')
                                    .addClass(currentStatus === 'Published' ? 'text-bg-success' : 'text-bg-warning');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>

@endpush
