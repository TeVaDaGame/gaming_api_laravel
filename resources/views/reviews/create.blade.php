@extends('layouts.app')

@section('title', 'Write Review')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-star-fill me-2"></i>Write a Review
                    </h4>
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="game_id" class="form-label">Game <span class="text-danger">*</span></label>
                                    <select class="form-select @error('game_id') is-invalid @enderror" 
                                            id="game_id" name="game_id" required>
                                        <option value="">Select a game to review</option>
                                        @foreach($games as $gameOption)
                                            <option value="{{ $gameOption->id }}" 
                                                    {{ (old('game_id', $game->id ?? '') == $gameOption->id) ? 'selected' : '' }}>
                                                {{ $gameOption->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select class="form-select @error('rating') is-invalid @enderror" 
                                            id="rating" name="rating" required>
                                        <option value="">Select rating</option>
                                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5) - Excellent</option>
                                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4) - Very Good</option>
                                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3) - Good</option>
                                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2) - Fair</option>
                                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1) - Poor</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Review Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Summarize your review in a few words..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Review Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="6" 
                                      placeholder="Share your thoughts about this game... What did you like or dislike? Would you recommend it to others?" 
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 10 characters required.</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_recommended" name="is_recommended" value="1" 
                                       {{ old('is_recommended') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_recommended">
                                    <i class="bi bi-hand-thumbs-up me-1"></i>
                                    I recommend this game to others
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('reviews.index') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Reviews
                                </a>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-house me-2"></i>Dashboard
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Review Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Review Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Do:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check text-success me-2"></i>Be honest and fair</li>
                                <li><i class="bi bi-check text-success me-2"></i>Focus on the game content</li>
                                <li><i class="bi bi-check text-success me-2"></i>Mention specific features</li>
                                <li><i class="bi bi-check text-success me-2"></i>Help other gamers decide</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger">❌ Don't:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-x text-danger me-2"></i>Use offensive language</li>
                                <li><i class="bi bi-x text-danger me-2"></i>Include spoilers</li>
                                <li><i class="bi bi-x text-danger me-2"></i>Post spam or irrelevant content</li>
                                <li><i class="bi bi-x text-danger me-2"></i>Review games you haven't played</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-update character count
document.getElementById('content').addEventListener('input', function() {
    const content = this.value;
    const minLength = 10;
    const currentLength = content.length;
    
    // You can add character counter here if needed
});

// Show selected game info when changed
document.getElementById('game_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        // You can add game info display here if needed
    }
});
</script>
@endsection
