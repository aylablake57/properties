{{-- By Asfia --}}
<style>
    .filled {
    color: gold;
}
</style>
<div class="testimonial-container">
    <div class="testimonial-grid">
        @if ($feedbacks && count($feedbacks) > 0)
            @foreach ($feedbacks as $feedback)
                <div class="testimonial-card">
                    <div class="user-details">
                        <div class="user-image">
                            <img src="{{ showUserImage($feedback->user) }}" alt="{{ $feedback->user->name }}">
                        </div>
                        <div class="user-info">
                            <p class="user-name">{{ $feedback->user->name }}</p>
                            <p class="user-role">{{ Str::ucfirst($feedback->user->user_type->value) }}</p>
                        </div>
                    </div>
                    <div class="user-review">
                        <h4>{{ \Str::limit($feedback->comment, 116) }}</h4>
                        @if ($feedback->user->about !== null)
                            <p>{{ \Str::limit($feedback->user->about, 64) }}</p>
                        @endif
                    </div>
                    <i class="fa fa-quote-right icon-comma"></i>
                    <!-- Star Rating -->
                    <div class="star-rating">
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $feedback->rating)
                                    <i class="fas fa-star filled"></i>
                                @else
                                    <i class="fas fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="single-star">
                            <i class="fas fa-star"></i>
                            <span class="rating">{{ $feedback->rating }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <!-- Add more testimonial cards here -->
    </div>
</div>
