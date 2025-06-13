<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gaming API</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
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
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/docs">API Documentation</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
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
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-joystick text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ rand(50, 200) }}</h3>
                            <p class="text-muted mb-0">Total Games</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-people text-success" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ rand(20, 50) }}</h3>
                            <p class="text-muted mb-0">Developers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-star text-warning" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ rand(100, 500) }}</h3>
                            <p class="text-muted mb-0">Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-graph-up text-info" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 mb-1">{{ rand(1000, 5000) }}</h3>
                            <p class="text-muted mb-0">API Calls</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Quick Actions</h2>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-plus-circle text-primary" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Add New Game</h4>
                            <p class="text-muted">Create a new game entry in your database</p>
                            <button class="btn btn-primary">Add Game</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-search text-success" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Search Games</h4>
                            <p class="text-muted">Find games by title, genre, or developer</p>
                            <button class="btn btn-success">Search</button>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Resource</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-plus-circle text-success me-2"></i>Created</td>
                                    <td>Game: "Cyberpunk 2077"</td>
                                    <td>{{ now()->subMinutes(5)->diffForHumans() }}</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-pencil text-warning me-2"></i>Updated</td>
                                    <td>Developer: "CD Projekt RED"</td>
                                    <td>{{ now()->subMinutes(15)->diffForHumans() }}</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-eye text-info me-2"></i>Viewed</td>
                                    <td>Genre: "Action RPG"</td>
                                    <td>{{ now()->subMinutes(30)->diffForHumans() }}</td>
                                    <td><span class="badge bg-info">Info</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
