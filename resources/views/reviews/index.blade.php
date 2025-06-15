@extends('layouts.app')

@section('title', 'Game Reviews')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-star-fill me-2"></i>
                    Game Reviews
                </h1>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Write Review
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter Options -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Filter Reviews</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reviews.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="game" class="form-label">Game</label>
                                <select class="form-select" id="game" name="game">
                                    <option value="">All Games</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" 
                                                {{ request('game') == $game->id ? 'selected' : '' }}>
                                            {{ $game->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="rating" class="form-label">Minimum Rating</label>
                                <select class="form-select" id="rating" name="rating">
                                    <option value="">Any Rating</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1+ Stars</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="recommended" class="form-label">Recommendation</label>
                                <select class="form-select" id="recommended" name="recommended">
                                    <option value="">Any</option>
                                    <option value="1" {{ request('recommended') == '1' ? 'selected' : '' }}>Recommended</option>
                                    <option value="0" {{ request('recommended') == '0' ? 'selected' : '' }}>Not Recommended</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reviews -->
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        All Reviews 
                        @if($reviews->total() > 0)
                            <span class="badge bg-primary">{{ $reviews->total() }} found</span>
                        @endif
                    </h5>
                    @if(request()->hasAny(['game', 'rating', 'recommended']))
                        <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        <div class="row g-4">
                            @foreach($reviews as $review)
                            <div class="col-lg-6">
                                <div class="card h-100 review-card border-start border-primary border-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title mb-1">{{ $review->title }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-joystick me-1"></i>{{ $review->game->title }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <div class="rating mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
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
                                    <div class="card-body">
                                        <p class="card-text">{{ Str::limit($review->content, 150) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div>
                                                <small class="text-muted">
                                                    <i class="bi bi-person me-1"></i>{{ $review->user->name }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar me-1"></i>{{ $review->created_at->format('M d, Y') }}
                                                </small>
                                            </div>
                                            @if($review->user_id === auth()->id())
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this review?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @elseif(auth()->user()->isAdmin())
                                            <div class="btn-group" role="group">
                                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this review? (Admin action)')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($reviews->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->appends(request()->query())->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-star h1 text-muted d-block mb-3"></i>
                            @if(request()->hasAny(['game', 'rating', 'recommended']))
                                <h4 class="text-muted">No reviews found matching your criteria</h4>
                                <p class="text-muted">Try adjusting your filters or 
                                   <a href="{{ route('reviews.index') }}">clear all filters</a>
                                </p>
                            @else
                                <h4 class="text-muted">No reviews yet</h4>
                                <p class="text-muted">Be the first to write a review!</p>
                                <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Write First Review
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.review-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.rating i {
    font-size: 0.9rem;
}
</style>
@endsection
