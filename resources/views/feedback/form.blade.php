@extends('layouts.app')
<style>
    .feedbackstar {
    color: #ccc;
    cursor: pointer;
    }

    .feedbackstar.checked {
        color: #ffcc00;
    }

</style>
@section('page')
    <header name="header">
        <h2>Give Your Feedback</h2>
    </header>

    <div class="main my-3">
        <div class="container-fluid">
            <div class="tab-content float-none">
                @if (session('message'))
                    <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }}">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{ route('storeFeedback') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="section-title">My Feedback</div>
                        <div class="section-content">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="col-sm-12 mb-3">
                                <label for="comments">Comments <span class="text-danger fs-12"></span></label>
                                <x-textarea
                                    name="comments"
                                    id="comments"
                                    placeholder="What are your comments about us?"
                                    maxlength="1500"
                                    :required="false">
                                </x-textarea>
                                @error('comments')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="suggestions">Suggestions <span class="text-danger fs-12"></span></label>
                                <input type="text" name="suggestions" id="suggestions" placeholder="What are your suggestions for us?" class="form-control">
                                @error('suggestions')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="title">Rate your experience <span class="text-danger fs-12">*(Mandatory)</span></label>
                                <div id="starsRating">
                                    <span class="fa fa-star feedbackstar" data-value="1"></span>
                                    <span class="fa fa-star feedbackstar" data-value="2"></span>
                                    <span class="fa fa-star feedbackstar" data-value="3"></span>
                                    <span class="fa fa-star feedbackstar" data-value="4"></span>
                                    <span class="fa fa-star feedbackstar" data-value="5"></span>
                                </div>
                                <input type="hidden" name="rating" id="rating" required="true" value="{{ old('rating') }}">
                                @error('rating')
                                    <span class='text-danger fs-12'>{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4 offset-lg-8 text-end">
                                    <button id="submitReview" class="btn btn-accent">Submit Feedback</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.feedbackstar');
            const ratingInput = document.getElementById('rating');

            const highlightStars = (value) => {
                stars.forEach(star => {
                    if (star.getAttribute('data-value') <= value) {
                        star.classList.add('checked');
                    } else {
                        star.classList.remove('checked');
                    }
                });
            };

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    highlightStars(value);
                });
            });

            const oldRating = ratingInput.value;
            if (oldRating) {
                highlightStars(oldRating);
            }
        });
    </script>
@endsection
