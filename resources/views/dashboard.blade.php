<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gaming API</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">    <style>
        /* Fix font rendering and prevent text glitching */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        
        /* Prevent layout shifts */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }
        
        /* Improved stats cards with better transitions */
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        
        .stats-card:hover {
            transform: translateY(-5px) translateZ(0);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Fix image loading glitches */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        
        /* Prevent text jumping */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        /* Fix card body spacing */
        .card-body {
            position: relative;
        }
        
        /* Smooth icon rendering */
        .bi {
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        
        /* Prevent layout shift on hover */
        .btn {
            transition: all 0.2s ease-in-out;
            will-change: transform;
        }
        
        /* Fix table glitching */
        .table {
            table-layout: fixed;
            width: 100%;
        }
          /* Prevent content jumping */
        .container {
            position: relative;
        }
        
        /* Font loading optimization */
        body:not(.fonts-loaded) {
            visibility: hidden;
        }
        
        body.fonts-loaded {
            visibility: visible;
        }
        
        /* Preload critical resources */
        @font-face {
            font-family: 'bootstrap-icons';
            font-display: swap;
        }
    </style>
</head>
<body>    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard"><i class="bi bi-controller"></i> Gaming API</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games.search') }}"><i class="bi bi-search me-1"></i>Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites.index') }}"><i class="bi bi-heart me-1"></i>Favorites</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><a class="dropdown-item" href="{{ route('status') }}"><i class="bi bi-activity me-2"></i>System Status</a></li>
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

    <!-- Dashboard Header -->
    <section class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="lead">Manage your gaming database through our comprehensive API dashboard</p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="text-white-50">
                        <i class="bi bi-calendar3 me-2"></i>{{ now()->format('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">                        <div class="card-body">
                            <i class="bi bi-joystick text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ $stats['total_games'] }}</h3>
                            <p class="text-muted mb-0">Total Games</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">                        <div class="card-body">
                            <i class="bi bi-people text-success" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ $stats['total_developers'] }}</h3>
                            <p class="text-muted mb-0">Developers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">                        <div class="card-body">
                            <i class="bi bi-star text-warning" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ $stats['total_reviews'] }}</h3>
                            <p class="text-muted mb-0">Reviews</p>
                        </div>
                    </div>
                </div>                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-heart text-danger" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ $favoriteStats['total_favorites'] }}</h3>
                            <p class="text-muted mb-0">Favorites</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-bookmark-star text-info" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ $favoriteStats['total_wishlist'] }}</h3>
                            <p class="text-muted mb-0">Wishlist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- Quick Actions -->
    <section class="py-5 bg-light">        <div class="container">
            <h2 class="text-center mb-5">Quick Actions</h2>              <div class="row g-4">
                @if(Auth::user()->role === 'admin')
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-plus-circle text-primary" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Manage Games</h4>
                            <p class="text-muted">Create, edit, and manage game entries</p>
                            <a href="{{ route('games.manage') }}" class="btn btn-primary">Manage Games</a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-search text-success" style="font-size: 3rem;"></i>                            <h4 class="mt-3">Search Games</h4>
                            <p class="text-muted">Find games by title, genre, or developer</p>
                            <a href="{{ route('games.search') }}" class="btn btn-success">Search Games</a>
                        </div>
                    </div>                </div>                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-heart-fill text-danger" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">My Favorites</h4>
                            <p class="text-muted">View and manage your favorite games</p>
                            <a href="{{ route('favorites.index', ['type' => 'favorite']) }}" class="btn btn-danger">View Favorites</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-bookmark-star text-info" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">My Wishlist</h4>
                            <p class="text-muted">Games you want to play in the future</p>
                            <a href="{{ route('favorites.index', ['type' => 'wishlist']) }}" class="btn btn-info">View Wishlist</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-star-fill text-warning" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Game Reviews</h4>
                            <p class="text-muted">Read and write reviews for your favorite games</p>
                            <a href="{{ route('reviews.index') }}" class="btn btn-warning">View Reviews</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-book text-info" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">API Documentation</h4>
                            <p class="text-muted">Explore all available API endpoints</p>
                            <a href="/docs" class="btn btn-info">View Docs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">Recent Activity</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Game</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>                            <tbody>
                                @foreach($recentGames as $game)
                                <tr>
                                    <td><i class="bi bi-plus-circle text-success me-2"></i>Added</td>
                                    <td>"{{ $game->title }}"</td>
                                    <td>{{ $game->created_at->diffForHumans() }}</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Fix glitching issues -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent layout shifts and glitching
            
            // 1. Fix image loading glitches
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.complete) {
                    img.style.opacity = '0';
                    img.style.transition = 'opacity 0.3s ease';
                    
                    img.onload = function() {
                        this.style.opacity = '1';
                    };
                    
                    img.onerror = function() {
                        this.style.opacity = '1';
                        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iIzY2N2VlYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IndoaXRlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R0FNRSBDT1ZFUjwvdGV4dD48L3N2Zz4=';
                    };
                }
            });
            
            // 2. Fix text rendering glitches
            const textElements = document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, span, div');
            textElements.forEach(el => {
                el.style.willChange = 'auto';
                el.style.backfaceVisibility = 'hidden';
            });
            
            // 3. Preload critical fonts
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/fonts/bootstrap-icons.woff2';
            link.as = 'font';
            link.type = 'font/woff2';
            link.crossOrigin = 'anonymous';
            document.head.appendChild(link);
            
            // 4. Fix card hover glitches
            const cards = document.querySelectorAll('.stats-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.willChange = 'transform';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.willChange = 'auto';
                });
            });
            
            // 5. Fix Bootstrap component initialization
            if (typeof bootstrap !== 'undefined') {
                // Initialize dropdowns properly
                const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
                dropdowns.forEach(dropdown => {
                    new bootstrap.Dropdown(dropdown);
                });
            }
            
            // 6. Smooth scroll for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // 7. Force layout recalculation to prevent glitches
            setTimeout(() => {
                document.body.style.display = 'none';
                document.body.offsetHeight; // Trigger reflow
                document.body.style.display = '';
            }, 100);
        });
        
        // Prevent font loading glitches
        document.fonts.ready.then(() => {
            document.body.classList.add('fonts-loaded');
        });
    </script>
</body>
</html>
