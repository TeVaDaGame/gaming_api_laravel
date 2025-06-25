<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($type) }} - Gaming API</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }        .game-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .rating-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .tab-pane {
            min-height: 400px;
        }
        .notes-text {
            font-style: italic;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard"><i class="bi bi-controller"></i> Gaming API</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard"><i class="bi bi-house me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games.search') }}"><i class="bi bi-search me-1"></i>Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('favorites.index') }}"><i class="bi bi-heart me-1"></i>Favorites</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-{{ $type === 'favorite' ? 'heart-fill' : 'bookmark-star' }} me-3"></i>
                        My {{ ucfirst($type) }}{{ $type === 'favorite' ? 's' : '' }}
                    </h1>
                    <p class="lead">Manage your {{ $type === 'favorite' ? 'favorite games' : 'gaming wishlist' }}</p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('favorites.index', ['type' => 'favorite']) }}" 
                           class="btn {{ $type === 'favorite' ? 'btn-light' : 'btn-outline-light' }}">
                            <i class="bi bi-heart me-1"></i>Favorites
                        </a>
                        <a href="{{ route('favorites.index', ['type' => 'wishlist']) }}" 
                           class="btn {{ $type === 'wishlist' ? 'btn-light' : 'btn-outline-light' }}">
                            <i class="bi bi-bookmark-star me-1"></i>Wishlist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($favorites->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>{{ $favorites->count() }} game{{ $favorites->count() !== 1 ? 's' : '' }} in your {{ $type }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="grid-view">
                                <i class="bi bi-grid"></i> Grid
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="list-view">
                                <i class="bi bi-list"></i> List
                            </button>
                        </div>
                    </div>
                </div>

                <div id="games-container" class="row g-4">
                    @foreach($favorites as $favorite)
                        <div class="col-lg-4 col-md-6 game-item">                            <div class="card game-card h-100">
                                <div class="position-relative">
                                    <img src="{{ $favorite->game->image }}" 
                                         alt="{{ $favorite->game->title }}" 
                                         class="card-img-top"
                                         style="height: 200px; object-fit: cover;"
                                         onerror="this.src='{{ $favorite->game->getPlaceholderImage() }}'">
                                    
                                    @if($favorite->game->rating)
                                        <div class="rating-badge">
                                            <i class="bi bi-star-fill text-warning me-1"></i>{{ $favorite->game->rating }}
                                        </div>
                                    @endif
                                    
                                    @if($favorite->game->price)
                                        <div class="position-absolute bottom-0 start-0 m-2">
                                            <span class="badge bg-success">${{ number_format($favorite->game->price, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favorite->game->title }}</h5>
                                    <p class="text-muted mb-2">
                                        <small>
                                            <i class="bi bi-building me-1"></i>{{ $favorite->game->publisher->name ?? 'Unknown Publisher' }}
                                        </small>
                                    </p>
                                    
                                    @if($favorite->game->genres->count() > 0)
                                        <div class="mb-2">
                                            @foreach($favorite->game->genres->take(3) as $genre)
                                                <span class="badge bg-secondary me-1">{{ $genre->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($favorite->notes)
                                        <div class="mb-2">
                                            <small class="notes-text">"{{ $favorite->notes }}"</small>
                                        </div>
                                    @endif

                                    <p class="text-muted mb-3">
                                        <small>
                                            <i class="bi bi-calendar me-1"></i>Added {{ $favorite->created_at->diffForHumans() }}
                                        </small>
                                    </p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('games.show', $favorite->game) }}" class="btn btn-primary btn-sm flex-fill">
                                            <i class="bi bi-eye me-1"></i>View Details
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $favorite->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('favorites.destroy', $favorite->game->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Remove from {{ $type }}?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Notes Modal -->
                        <div class="modal fade" id="editModal{{ $favorite->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('favorites.update', $favorite->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Notes - {{ $favorite->game->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="notes{{ $favorite->id }}" class="form-label">Personal Notes</label>
                                                <textarea class="form-control" id="notes{{ $favorite->id }}" name="notes" 
                                                          rows="3" placeholder="Add your personal notes about this game...">{{ $favorite->notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Notes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-{{ $type === 'favorite' ? 'heart' : 'bookmark-star' }}"></i>
                    <h3>No {{ $type === 'favorite' ? 'favorites' : 'wishlist items' }} yet</h3>
                    <p>Start building your {{ $type === 'favorite' ? 'favorites' : 'wishlist' }} by exploring our game database.</p>
                    <a href="{{ route('games.search') }}" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Browse Games
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // View toggle functionality
        document.getElementById('grid-view').addEventListener('click', function() {
            document.getElementById('games-container').className = 'row g-4';
            document.querySelectorAll('.game-item').forEach(function(item) {
                item.className = 'col-lg-4 col-md-6 game-item';
            });
            this.classList.add('active');
            document.getElementById('list-view').classList.remove('active');
        });

        document.getElementById('list-view').addEventListener('click', function() {
            document.getElementById('games-container').className = 'row';
            document.querySelectorAll('.game-item').forEach(function(item) {
                item.className = 'col-12 game-item mb-3';
            });
            this.classList.add('active');
            document.getElementById('grid-view').classList.remove('active');
        });
    </script>
</body>
</html>
