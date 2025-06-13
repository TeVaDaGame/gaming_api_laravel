<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming API - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .card {
            transition: transform 0.3s ease-in-out;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .api-card {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stats-card {
            background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="bi bi-controller"></i> Gaming API</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#endpoints">API Endpoints</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/docs">Documentation</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
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
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4 fw-bold mb-4">Gaming API Dashboard</h1>
                    <p class="lead mb-4">A comprehensive RESTful API for managing games, developers, publishers, genres, platforms, and reviews</p>
                    
                    @auth
                        <div class="mb-4">
                            <a href="/dashboard" class="btn btn-light btn-lg me-3">
                                <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                            </a>
                            <a href="/docs" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-book me-2"></i>View Documentation
                            </a>
                        </div>
                    @else
                        <div class="mb-4">
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
                                <i class="bi bi-person-plus me-2"></i>Get Started
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </a>
                        </div>
                    @endauth
                    
                    <div class="row text-center mt-5">
                        <div class="col-md-4">
                            <h3 class="fw-bold">{{ now()->format('M d, Y') }}</h3>
                            <p>Current Date</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-bold">Laravel {{ app()->version() }}</h3>
                            <p>Framework Version</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-bold">PHP {{ phpversion() }}</h3>
                            <p>Runtime Version</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold">API Features</h2>
                    <p class="lead text-muted">Explore our comprehensive gaming database management system</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-joystick feature-icon text-primary"></i>
                        <h4>Games Management</h4>
                        <p class="text-muted">Complete CRUD operations for games with search, popularity tracking, and rating system</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-people feature-icon text-success"></i>
                        <h4>Developers & Publishers</h4>
                        <p class="text-muted">Manage game developers and publishers with relationship tracking</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-tags feature-icon text-warning"></i>
                        <h4>Genres & Platforms</h4>
                        <p class="text-muted">Organize games by genres and supported platforms</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-star feature-icon text-info"></i>
                        <h4>Reviews System</h4>
                        <p class="text-muted">Comprehensive review and rating system for games</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-search feature-icon text-danger"></i>
                        <h4>Advanced Search</h4>
                        <p class="text-muted">Powerful search capabilities across all entities</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-graph-up feature-icon text-purple"></i>
                        <h4>Analytics</h4>
                        <p class="text-muted">Track popular games, latest releases, and trends</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- API Endpoints Section -->
    <section id="endpoints" class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold">API Endpoints</h2>
                    <p class="lead text-muted">Explore our RESTful API endpoints</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card api-card h-100 p-4">
                        <h4><i class="bi bi-joystick me-2"></i>Games API</h4>
                        <ul class="list-unstyled mt-3">
                            <li><code>GET /api/games</code> - List all games</li>
                            <li><code>POST /api/games</code> - Create new game</li>
                            <li><code>GET /api/games/search</code> - Search games</li>
                            <li><code>GET /api/games/popular</code> - Popular games</li>
                            <li><code>GET /api/games/latest</code> - Latest games</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card stats-card h-100 p-4">
                        <h4><i class="bi bi-people me-2"></i>Developers API</h4>
                        <ul class="list-unstyled mt-3">
                            <li><code>GET /api/developers</code> - List developers</li>
                            <li><code>POST /api/developers</code> - Create developer</li>
                            <li><code>GET /api/developers/search</code> - Search developers</li>
                            <li><code>GET /api/developers/{id}/games</code> - Developer games</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card api-card h-100 p-4">
                        <h4><i class="bi bi-building me-2"></i>Publishers API</h4>
                        <ul class="list-unstyled mt-3">
                            <li><code>GET /api/publishers</code> - List publishers</li>
                            <li><code>POST /api/publishers</code> - Create publisher</li>
                            <li><code>GET /api/publishers/search</code> - Search publishers</li>
                            <li><code>GET /api/publishers/{id}/games</code> - Publisher games</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card stats-card h-100 p-4">
                        <h4><i class="bi bi-tags me-2"></i>Genres & Platforms</h4>
                        <ul class="list-unstyled mt-3">
                            <li><code>GET /api/genres</code> - List genres</li>
                            <li><code>GET /api/platforms</code> - List platforms</li>
                            <li><code>GET /api/reviews</code> - List reviews</li>
                            <li><code>POST /api/games/{id}/rate</code> - Rate game</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="/docs" class="btn btn-primary btn-lg">
                    <i class="bi bi-book me-2"></i>View Full Documentation
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h5 class="mb-3">Gaming API</h5>
                    <p class="mb-3">A powerful RESTful API for gaming data management built with Laravel</p>
                    <p class="text-muted">&copy; {{ date('Y') }} Gaming API. Built with Laravel {{ app()->version() }}</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>