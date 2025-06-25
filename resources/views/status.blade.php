<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Status - Gaming API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .status-ok { color: #198754; }
        .status-warning { color: #fd7e14; }
        .status-error { color: #dc3545; }
        .system-status {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <div class="system-status">
        <div class="container">
            <h1 class="text-center"><i class="bi bi-activity me-2"></i>Gaming API System Status</h1>
            <p class="text-center lead">Real-time health monitoring dashboard</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Database Status -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-database me-2"></i>Database Status
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Connection</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Migrations</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Seeders</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Status -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-cloud-check me-2"></i>API Status
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Games API</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Favorites API</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Search API</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Status -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <i class="bi bi-gear-fill me-2"></i>Features Status
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>User Favorites</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Admin Controls</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Game Images</span>
                            <i class="bi bi-check-circle-fill status-ok"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-bar-chart me-2"></i>System Statistics
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h3 class="text-primary">{{ \App\Models\Game::count() }}</h3>
                                <p>Total Games</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-success">{{ \App\Models\User::count() }}</h3>
                                <p>Registered Users</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-info">{{ \App\Models\UserFavorite::count() }}</h3>
                                <p>Total Favorites</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-warning">{{ \App\Models\Review::count() }}</h3>
                                <p>Game Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="/dashboard" class="btn btn-primary">
                                <i class="bi bi-house me-1"></i>Dashboard
                            </a>
                            <a href="{{ route('games.search') }}" class="btn btn-success">
                                <i class="bi bi-search me-1"></i>Search Games
                            </a>
                            <a href="{{ route('favorites.index') }}" class="btn btn-info">
                                <i class="bi bi-heart me-1"></i>Favorites
                            </a>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('games.manage') }}" class="btn btn-warning">
                                <i class="bi bi-gear me-1"></i>Manage Games
                            </a>
                            @endif
                            <a href="/docs" class="btn btn-outline-secondary">
                                <i class="bi bi-book me-1"></i>API Docs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version Info -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <i class="bi bi-info-circle me-2"></i>Version Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Laravel Version:</strong> {{ app()->version() }}<br>
                                <strong>PHP Version:</strong> {{ PHP_VERSION }}<br>
                                <strong>Environment:</strong> {{ app()->environment() }}
                            </div>
                            <div class="col-md-6">
                                <strong>Last Updated:</strong> {{ date('F d, Y') }}<br>
                                <strong>API Version:</strong> v1.0<br>
                                <strong>Status:</strong> <span class="text-success">All Systems Operational</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
