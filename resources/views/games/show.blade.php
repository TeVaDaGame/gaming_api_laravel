@extends('layouts.app')

@section('title', $game->title)

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Game Header -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <!-- Game Image Placeholder -->
                            <div class="game-image-placeholder bg-light rounded mb-3 d-flex align-items-center justify-content-center" 
                                 style="height: 300px; border: 2px dashed #ddd;">
                                <div class="text-center text-muted">
                                    <i class="bi bi-controller" style="font-size: 4rem;"></i>
                                    <p class="mt-2 mb-0">Game Cover</p>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="d-grid gap-2">
                                @if(auth()->check())
                                    @if($userReview)
                                        <a href="{{ route('reviews.edit', $userReview) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil me-1"></i>Edit My Review
                                        </a>
                                    @else
                                        <a href="{{ route('reviews.create', ['game_id' => $game->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-star me-1"></i>Write Review
                                        </a>
                                    @endif
                                @endif
                                <button class="btn btn-outline-secondary btn-sm" onclick="shareGame()">
                                    <i class="bi bi-share me-1"></i>Share Game
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <!-- Game Title and Basic Info -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="display-6 fw-bold mb-2">{{ $game->title }}</h1>
                                    <div class="d-flex align-items-center mb-2">
                                        @if($averageRating)
                                            <div class="me-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($averageRating))
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 fw-bold">{{ number_format($averageRating, 1) }}</span>
                                                <small class="text-muted">({{ $totalReviews }} {{ Str::plural('review', $totalReviews) }})</small>
                                            </div>
                                        @else
                                            <div class="me-3">
                                                <span class="text-muted">No ratings yet</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    @if($game->price > 0)
                                        <h3 class="text-success mb-0">${{ number_format($game->price, 2) }}</h3>
                                    @else
                                        <h3 class="text-info mb-0">Free</h3>
                                    @endif
                                    <a href="{{ route('games.search') }}" class="btn btn-outline-secondary btn-sm mt-2">
                                        <i class="bi bi-arrow-left me-1"></i>Back to Search
                                    </a>
                                </div>
                            </div>

                            <!-- Game Description -->
                            <div class="mb-4">
                                <h5>Description</h5>
                                <p class="text-muted">{{ $game->description ?: 'No description available for this game.' }}</p>
                            </div>

                            <!-- Game Details Grid -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-primary h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">
                                                <i class="bi bi-calendar-event me-2"></i>Release Information
                                            </h6>
                                            <p class="mb-2"><strong>Release Date:</strong> 
                                                {{ $game->release_date ? $game->release_date->format('F d, Y') : 'TBA' }}
                                            </p>
                                            <p class="mb-0"><strong>Publisher:</strong> 
                                                {{ $game->publisher ? $game->publisher->name : 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card border-success h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-success">
                                                <i class="bi bi-people me-2"></i>Development
                                            </h6>
                                            <p class="mb-0"><strong>Developers:</strong></p>
                                            @if($game->developers->count() > 0)
                                                @foreach($game->developers as $developer)
                                                    <span class="badge bg-outline-success me-1">{{ $developer->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Unknown</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Categories and Platforms -->
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-tags me-2"></i>Genres
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($game->genres->count() > 0)
                                @foreach($game->genres as $genre)
                                    <span class="badge bg-warning text-dark me-2 mb-2 fs-6">
                                        <i class="bi bi-tag me-1"></i>{{ $genre->name }}
                                    </span>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">No genres specified</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-device-hdd me-2"></i>Platforms
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($game->platforms->count() > 0)
                                @foreach($game->platforms as $platform)
                                    <span class="badge bg-info me-2 mb-2 fs-6">
                                        <i class="bi bi-display me-1"></i>{{ $platform->name }}
                                    </span>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">No platforms specified</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-chat-square-text me-2"></i>User Reviews
                        <span class="badge bg-light text-dark ms-2">{{ $totalReviews }}</span>
                    </h5>
                    @auth
                        @if(!$userReview)
                            <a href="{{ route('reviews.create', ['game_id' => $game->id]) }}" class="btn btn-light btn-sm">
                                <i class="bi bi-plus me-1"></i>Write Review
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="card-body">
                    @if($game->reviews->count() > 0)
                        <div class="row">
                            @foreach($game->reviews->take(6) as $review)
                            <div class="col-md-6 mb-3">
                                <div class="card border-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="card-title mb-1">{{ $review->title }}</h6>
                                                <small class="text-muted">
                                                    By {{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <div class="mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                @if($review->recommended)
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
                                        <p class="card-text small">{{ Str::limit($review->content, 150) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($game->reviews->count() > 6)
                            <div class="text-center">
                                <a href="{{ route('reviews.index', ['game' => $game->id]) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye me-1"></i>View All Reviews ({{ $totalReviews }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-chat-square text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">No Reviews Yet</h5>
                            <p class="text-muted">Be the first to review this game!</p>
                            @auth
                                <a href="{{ route('reviews.create', ['game_id' => $game->id]) }}" class="btn btn-primary">
                                    <i class="bi bi-star me-1"></i>Write First Review
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-person me-1"></i>Login to Review
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Similar Games -->
        @if($similarGames->count() > 0)
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-collection me-2"></i>Similar Games
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($similarGames as $similarGame)
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 border-light">
                                <div class="card-body text-center">
                                    <div class="game-placeholder bg-light rounded mb-3 d-flex align-items-center justify-content-center" 
                                         style="height: 120px;">
                                        <i class="bi bi-controller text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="card-title">{{ Str::limit($similarGame->title, 30) }}</h6>
                                    <div class="mb-2">
                                        @foreach($similarGame->genres->take(2) as $genre)
                                            <span class="badge bg-outline-secondary small">{{ $genre->name }}</span>
                                        @endforeach
                                    </div>
                                    <div class="mb-2">
                                        @if($similarGame->price > 0)
                                            <span class="text-success fw-bold">${{ number_format($similarGame->price, 2) }}</span>
                                        @else
                                            <span class="text-info fw-bold">Free</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('games.show', $similarGame) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function shareGame() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $game->title }}',
            text: 'Check out this game: {{ $game->title }}',
            url: window.location.href,
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Game link copied to clipboard!');
        });
    }
}
</script>
@endsection
