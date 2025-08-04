@extends('layouts.app')
@section('page')
    <header name="header">
        <h2>{{ __('Reset User Password') }}</h2>
    </header>
    <div class="container mt-5">

        <!-- Search Form -->
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form id="searchForm" class="d-flex" method="GET" action="{{ route('admin.filterUsers') }}">
                    <input class="form-control me-2" type="search" placeholder="Search by Name or Email"
                        aria-label="Search" id="userItem" required name="searchItem">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>

        {{-- Status Messages --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="widget-container bg-white table-responsive p-3">
                    {{-- Table Listing --}}
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>CNIC</th>
                                <th>Email Address</th>
                                <th>Reset Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($results && count($results) > 0)
                                @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->phone }}</td>
                                        <td>{{ $result->cnic_number }}</td>
                                        <td>{{ $result->email }}</td>
                                        <td class="text-center">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#passwordResetModal"
                                               data-user-id="{{ $result->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No results found for your search. Try something else.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Password Reset Modal -->
        <div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordResetModalLabel">Reset User Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordResetForm" method="POST" action="{{ route('admin.resetPassword') }}">
                            @csrf
                            <input type="hidden" name="userID" id="userID" value="{{ old('userID') }}">

                            <div class="mb-2 input-group">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" value="{{ old('newPassword') }}">
                            </div>
                            @error('newPassword')
                                <span class='text-danger fs-12 mb-5'>{{ $message }}</span>
                            @enderror

                            <button type="submit" class="btn btn-accent mt-2">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('page_script')
<script>
    // By Asfia
    // Populate the hidden user ID field when opening the modal
    document.querySelectorAll('[data-bs-target="#passwordResetModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            document.getElementById('userID').value = userId;
        });
    });

    // Open the modal if there are validation errors
    @if ($errors->any())
        window.onload = function() {
            var passwordResetModal = new bootstrap.Modal(document.getElementById('passwordResetModal'));
            passwordResetModal.show();
        };
    @endif
</script>
@endsection
