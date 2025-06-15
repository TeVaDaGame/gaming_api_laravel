@extends('layouts.app')

@section('title', 'Search Games')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-search me-2"></i>
                    Search Games
                </h1>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Search Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('games.search') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="q" class="form-label">Search Query</label>
                                <input type="text" class="form-control" id="q" name="q" 
                                       value="{{ $query }}" placeholder="Search by title or description...">
                            </div>
                            <div class="col-md-2">
                                <label for="genre" class="form-label">Genre</label>
                                <select class="form-select" id="genre" name="genre">
                                    <option value="">All Genres</option>
                                    @foreach($genres as $genreOption)
                                        <option value="{{ $genreOption->id }}" 
                                                {{ $genre == $genreOption->id ? 'selected' : '' }}>
                                            {{ $genreOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="publisher" class="form-label">Publisher</label>
                                <select class="form-select" id="publisher" name="publisher">
                                    <option value="">All Publishers</option>
                                    @foreach($publishers as $publisherOption)
                                        <option value="{{ $publisherOption->id }}" 
                                                {{ $publisher == $publisherOption->id ? 'selected' : '' }}>
                                            {{ $publisherOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="min_rating" class="form-label">Min Rating</label>
                                <select class="form-select" id="min_rating" name="min_rating">
                                    <option value="">Any Rating</option>
                                    <option value="9" {{ $minRating == '9' ? 'selected' : '' }}>9+ Stars</option>
                                    <option value="8" {{ $minRating == '8' ? 'selected' : '' }}>8+ Stars</option>
                                    <option value="7" {{ $minRating == '7' ? 'selected' : '' }}>7+ Stars</option>
                                    <option value="6" {{ $minRating == '6' ? 'selected' : '' }}>6+ Stars</option>
                                    <option value="5" {{ $minRating == '5' ? 'selected' : '' }}>5+ Stars</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="max_price" class="form-label">Max Price</label>
                                <select class="form-select" id="max_price" name="max_price">
                                    <option value="">Any Price</option>
                                    <option value="10" {{ $maxPrice == '10' ? 'selected' : '' }}>Under $10</option>
                                    <option value="20" {{ $maxPrice == '20' ? 'selected' : '' }}>Under $20</option>
                                    <option value="30" {{ $maxPrice == '30' ? 'selected' : '' }}>Under $30</option>
                                    <option value="50" {{ $maxPrice == '50' ? 'selected' : '' }}>Under $50</option>
                                    <option value="60" {{ $maxPrice == '60' ? 'selected' : '' }}>Under $60</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search me-2"></i>Search Games
                                </button>
                                <a href="{{ route('games.search') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Search Results 
                        @if($results->total() > 0)
                            <span class="badge bg-primary">{{ $results->total() }} found</span>
                        @endif
                    </h5>
                    @if($query || $genre || $publisher || $minRating || $maxPrice)
                        <small class="text-muted">
                            Filters active
                        </small>
                    @endif
                </div>
                <div class="card-body">
                    @if($results->count() > 0)
                        <div class="row g-4">
                            @foreach($results as $game)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 game-card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $game->title }}</h5>
                                        <p class="card-text text-muted">{{ Str::limit($game->description, 100) }}</p>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Publisher:</small>
                                            <span class="badge bg-info">{{ $game->publisher->name }}</span>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Developers:</small>
                                            @foreach($game->developers->take(2) as $developer)
                                                <span class="badge bg-secondary me-1">{{ $developer->name }}</span>
                                            @endforeach
                                            @if($game->developers->count() > 2)
                                                <span class="text-muted">+{{ $game->developers->count() - 2 }} more</span>
                                            @endif
                                        </div>
                                        
                                        @if($game->genres->count() > 0)
                                        <div class="mb-2">
                                            <small class="text-muted">Genres:</small>
                                            @foreach($game->genres->take(3) as $gameGenre)
                                                <span class="badge bg-success me-1">{{ $gameGenre->name }}</span>
                                            @endforeach
                                            @if($game->genres->count() > 3)
                                                <span class="text-muted">+{{ $game->genres->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                        @endif
                                        
                                        @if($game->platforms->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted">Platforms:</small>
                                            @foreach($game->platforms->take(3) as $platform)
                                                <span class="badge bg-warning text-dark me-1">{{ $platform->name }}</span>
                                            @endforeach
                                            @if($game->platforms->count() > 3)
                                                <span class="text-muted">+{{ $game->platforms->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                        @endif
                                          <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-star-fill me-1"></i>{{ number_format($game->rating, 1) }}
                                                </span>
                                                <span class="text-success fw-bold">${{ number_format($game->price, 2) }}</span>
                                            </div>
                                            <small class="text-muted">{{ $game->release_date->format('M Y') }}</small>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="d-grid">
                                            <a href="{{ route('games.show', $game) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($results->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $results->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-search h1 text-muted d-block mb-3"></i>
                            @if($query || $genre || $publisher || $minRating || $maxPrice)
                                <h4 class="text-muted">No games found matching your criteria</h4>
                                <p class="text-muted">Try adjusting your search filters or 
                                   <a href="{{ route('games.search') }}">clear all filters</a>
                                </p>
                            @else
                                <h4 class="text-muted">Start searching for games</h4>
                                <p class="text-muted">Use the filters above to find games by title, genre, publisher, rating, or price</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.game-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #dee2e6;
}

.game-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.75em;
}
</style>

<script>
// Auto-submit form when filters change (optional)
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select[name="genre"], select[name="publisher"], select[name="min_rating"], select[name="max_price"]');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment the line below if you want auto-submit on filter change
            // this.form.submit();
        });
    });
    
    // Add enter key support for search input
    document.getElementById('q').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
});
</script>
@endsection
