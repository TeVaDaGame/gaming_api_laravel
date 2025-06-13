<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming API - Documentation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <style>
          .sidebar {
            background-color: #f8f9fa;
            min-height: calc(100vh - 76px);
        }
        .endpoint-card {
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
        }
        .method-get { border-left-color: #28a745; }
        .method-post { border-left-color: #007bff; }
        .method-put { border-left-color: #ffc107; }
        .method-delete { border-left-color: #dc3545; }
        .method-badge.bg-get { background-color: #28a745 !important; }
        .method-badge.bg-post { background-color: #007bff !important; }
        .method-badge.bg-put { background-color: #ffc107 !important; }
        .method-badge.bg-delete { background-color: #dc3545 !important; }
        pre { background-color: #2d3748; border-radius: 8px; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><i class="bi bi-controller"></i> Gaming API</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">← Back to Dashboard</a>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <nav class="col-md-3 col-lg-2 sidebar p-3">
                <div class="position-sticky">
                    <h6 class="text-muted text-uppercase mb-3">API Endpoints</h6>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#games">🎮 Games</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#developers">👥 Developers</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#publishers">🏢 Publishers</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#genres">🏷️ Genres</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#platforms">💻 Platforms</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="#reviews">⭐ Reviews</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="py-4">
                    <h1 class="display-4 fw-bold mb-4">Gaming API Documentation</h1>
                    <p class="lead">Complete reference for all available endpoints and their usage.</p>

                    <!-- Base URL -->
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle me-2"></i>Base URL</h5>
                        <code>{{ url('/') }}/api</code>
                    </div>

                    <!-- Games Section -->
                    <section id="games" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-joystick me-2"></i>Games API</h2>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h5>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/games
                                        </h5>
                                        <p class="mb-3">Retrieve all games with pagination</p>
                                        <h6>Response Example:</h6>
                                        <pre><code class="language-json">{
  "data": [
    {
      "id": 1,
      "title": "Game Title",
      "description": "Game description",
      "release_date": "2024-01-01",
      "price": 59.99,
      "rating": 4.5
    }
  ],
  "links": {...},
  "meta": {...}
}</code></pre>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h5>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/games
                                        </h5>
                                        <p class="mb-3">Create a new game</p>
                                        <h6>Request Body:</h6>
                                        <pre><code class="language-json">{
  "title": "New Game",
  "description": "Game description",
  "release_date": "2024-01-01",
  "price": 59.99,
  "publisher_id": 1,
  "developer_ids": [1, 2],
  "genre_ids": [1, 2],
  "platform_ids": [1, 2]
}</code></pre>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/games/search
                                        </h6>
                                        <p>Search games by title or description</p>
                                        <small class="text-muted">Query: ?q=search_term</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/games/popular
                                        </h6>
                                        <p>Get popular games based on ratings</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/games/latest
                                        </h6>
                                        <p>Get latest released games</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/games/{id}/rate
                                        </h6>
                                        <p>Rate a game (1-5 stars)</p>
                                        <small class="text-muted">Body: {"rating": 5}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Developers Section -->
                    <section id="developers" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-people me-2"></i>Developers API</h2>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/developers
                                        </h6>
                                        <p>List all developers</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/developers
                                        </h6>
                                        <p>Create new developer</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/developers/search
                                        </h6>
                                        <p>Search developers</p>
                                        <small class="text-muted">Query: ?q=search_term</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/developers/{id}/games
                                        </h6>
                                        <p>Get games by developer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Publishers Section -->
                    <section id="publishers" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-building me-2"></i>Publishers API</h2>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/publishers
                                        </h6>
                                        <p>List all publishers</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/publishers
                                        </h6>
                                        <p>Create new publisher</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/publishers/search
                                        </h6>
                                        <p>Search publishers</p>
                                        <small class="text-muted">Query: ?q=search_term</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/publishers/{id}/games
                                        </h6>
                                        <p>Get games by publisher</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Genres Section -->
                    <section id="genres" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-tags me-2"></i>Genres API</h2>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/genres
                                        </h6>
                                        <p>List all genres</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/genres
                                        </h6>
                                        <p>Create new genre</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/genres/{id}/games
                                        </h6>
                                        <p>Get games by genre</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-put">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-put me-2">PUT</span>
                                            /api/genres/{id}
                                        </h6>
                                        <p>Update genre</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Platforms Section -->
                    <section id="platforms" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-laptop me-2"></i>Platforms API</h2>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/platforms
                                        </h6>
                                        <p>List all platforms</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/platforms
                                        </h6>
                                        <p>Create new platform</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/platforms/{id}/games
                                        </h6>
                                        <p>Get games by platform</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-delete">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-delete me-2">DELETE</span>
                                            /api/platforms/{id}
                                        </h6>
                                        <p>Delete platform</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Reviews Section -->
                    <section id="reviews" class="mb-5">
                        <h2 class="mb-4"><i class="bi bi-star me-2"></i>Reviews API</h2>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card endpoint-card method-get">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-get me-2">GET</span>
                                            /api/reviews
                                        </h6>
                                        <p>List all reviews</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h6>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/reviews
                                        </h6>
                                        <p>Create new review</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card endpoint-card method-post">
                                    <div class="card-body">
                                        <h5>
                                            <span class="badge method-badge bg-post me-2">POST</span>
                                            /api/reviews
                                        </h5>
                                        <p class="mb-3">Create a new review for a game</p>
                                        <h6>Request Body:</h6>
                                        <pre><code class="language-json">{
  "game_id": 1,
  "user_id": 1,
  "rating": 5,
  "comment": "Amazing game! Highly recommended."
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Response Codes -->
                    <section class="mb-5">
                        <h2 class="mb-4">Response Status Codes</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-success">200</span></td>
                                        <td>Success - Request completed successfully</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-success">201</span></td>
                                        <td>Created - Resource created successfully</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-warning">400</span></td>
                                        <td>Bad Request - Invalid request parameters</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-warning">404</span></td>
                                        <td>Not Found - Resource not found</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">422</span></td>
                                        <td>Unprocessable Entity - Validation errors</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">500</span></td>
                                        <td>Internal Server Error - Server error</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Prism.js for code highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
</body>
</html>
