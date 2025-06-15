@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Review: {{ $review->title }}
                    </h4>
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-dark btn-sm">
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

                    <!-- Current Game Info -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-joystick me-3 h4 mb-0"></i>
                            <div>
                                <h6 class="mb-1">Reviewing: {{ $review->game->title }}</h6>
                                <small class="text-muted">
                                    Originally reviewed on {{ $review->created_at->format('M d, Y \a\t g:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select class="form-select @error('rating') is-invalid @enderror" 
                                            id="rating" name="rating" required>
                                        <option value="">Select rating</option>
                                        <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5) - Excellent</option>
                                        <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4) - Very Good</option>
                                        <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>⭐⭐⭐ (3) - Good</option>
                                        <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>⭐⭐ (2) - Fair</option>
                                        <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>⭐ (1) - Poor</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Current Recommendation</label>
                                    <div class="form-control-plaintext">
                                        @if($review->is_recommended)
                                            <span class="badge bg-success">
                                                <i class="bi bi-hand-thumbs-up me-1"></i>Recommended
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-hand-thumbs-down me-1"></i>Not Recommended
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Review Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $review->title) }}" 
                                   placeholder="Summarize your review in a few words..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Review Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="6" 
                                      placeholder="Share your thoughts about this game..." 
                                      required>{{ old('content', $review->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 10 characters required.</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_recommended" name="is_recommended" value="1" 
                                       {{ old('is_recommended', $review->is_recommended) ? 'checked' : '' }}>
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
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="bi bi-save me-2"></i>Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Review History -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>Review History
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $review->created_at->format('M d, Y \a\t g:i A') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Last Updated:</strong> {{ $review->updated_at->format('M d, Y \a\t g:i A') }}
                            </small>
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
</script>
@endsection
