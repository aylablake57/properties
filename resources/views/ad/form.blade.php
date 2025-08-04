@extends('layouts.app')
@section('page')
    <header name="header">
        <h2>{{ $ad ? 'Edit Ad' : 'Create Ad' }}</h2>
    </header>

    <div class="main my-3">
            <div class="tab-content float-none">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('ad.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="section-title">Ad Info</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                @if($ad && $ad->file_name != '')
                                    <img src="{{ env('FTP_BASE_URL') . '/' .$ad->file_name }}" class="img-fluid mb-3" alt="Properties">
                                @endif
                                <label for="image">Ad Image File <span class="text-danger fs-12">*(Mandatory)</span></label>
                                <input type="file" class="form-control" name="ad_image" accept="image/*">
                                @error('ad_image')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>Tips</label>
                                <ul>
                                    <li>This Ad will be displayed in the Ad section of different pages.</li>
                                    <li>Upload good quality pictures</li>
                                    <li>Max size 1MB, .jpg .png .jpeg .gif only</li>
                                    <li>The dimensions of the image should be 300x180</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 offset-lg-8 text-end">
                            @if ($ad)
                            <input type="hidden" name="ad_id" value="{{ $ad->id }}" >
                            @endif
                            <button class="btn btn-accent">
                            {{ $ad ? 'Update Ad' : 'Submit Ad' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('page_script')

    @endsection
@endsection