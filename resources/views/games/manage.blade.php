@extends('layouts.app')

@section('title', 'Manage Games')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-joystick me-2"></i>
                    Manage Games
                </h1>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('games.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add New Game
                    </a>
                </div>
            </div>            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('games.manage') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Games</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by title or description..." class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="publisher" class="form-label">Publisher</label>
                            <select id="publisher" name="publisher" class="form-select">
                                <option value="">All Publishers</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ request('publisher') == $publisher->id ? 'selected' : '' }}>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="genre" class="form-label">Genre</label>
                            <select id="genre" name="genre" class="form-select">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            @if(request()->hasAny(['search', 'publisher', 'genre', 'status']))
                                <a href="{{ route('games.manage') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>            <div class="card">                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        All Games ({{ $games->count() }})
                        @if(request('search') || request('publisher') || request('genre') || request('status'))
                            <span class="badge bg-info ms-2">
                                <i class="bi bi-funnel me-1"></i>Filtered
                            </span>
                        @endif
                    </h5>
                    <div class="d-flex align-items-center">
                        <div id="bulkActions" class="me-3" style="display: none;">
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmBulkDelete()">
                                <i class="bi bi-trash me-1"></i>Delete Selected
                            </button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleSelectAll()">
                            <i class="bi bi-check-square me-1"></i>Select All
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form id="bulkForm" method="POST" action="{{ route('games.bulk-delete') }}">
                        @csrf
                        @method('DELETE')                        <table class="table table-hover mb-0">                            <thead class="table-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th width="80">Cover</th>
                                    <th>Title</th>
                                    <th>Publisher</th>
                                    <th>Developers</th>
                                    <th>Release Date</th>
                                    <th>Rating</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>                                @forelse($games as $game)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_games[]" value="{{ $game->id }}" 
                                               class="form-check-input game-checkbox" onchange="updateBulkActions()">
                                    </td>
                                    <td>
                                        <img src="{{ $game->image }}" 
                                             alt="{{ $game->title }}" 
                                             class="img-thumbnail"
                                             style="width: 60px; height: 80px; object-fit: cover;"
                                             onerror="this.src='{{ $game->getPlaceholderImage() }}'">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $game->title }}</div>
                                        <small class="text-muted">{{ Str::limit($game->description, 50) }}</small>
                                    </td>
                                    <td>{{ $game->publisher->name }}</td>
                                    <td>
                                        @foreach($game->developers->take(2) as $developer)
                                            <span class="badge bg-secondary me-1">{{ $developer->name }}</span>
                                        @endforeach
                                        @if($game->developers->count() > 2)
                                            <span class="text-muted">+{{ $game->developers->count() - 2 }} more</span>
                                        @endif
                                    </td>
                                    <td>{{ $game->release_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill me-1"></i>{{ number_format($game->rating, 1) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($game->price, 2) }}</td>
                                    <td>
                                        @if($game->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('games.edit', $game) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete({{ $game->id }}, '{{ $game->title }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <form id="delete-form-{{ $game->id }}" 
                                              action="{{ route('games.destroy', $game) }}" 
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox h1 d-block mb-3"></i>
                                            <p class="mb-0">No games found. <a href="{{ route('games.create') }}">Create your first game</a></p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>                        </table>
                    </form>
                </div>
                <!-- Removed pagination - showing all games -->
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the game <strong id="gameTitle"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Game</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(gameId, gameTitle) {
    document.getElementById('gameTitle').textContent = gameTitle;
    document.getElementById('confirmDeleteBtn').onclick = function() {
        document.getElementById('delete-form-' + gameId).submit();
    };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const gameCheckboxes = document.querySelectorAll('.game-checkbox');
    
    selectAllCheckbox.checked = !selectAllCheckbox.checked;
    
    gameCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.game-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    if (checkedBoxes.length > 0) {
        bulkActions.style.display = 'block';
    } else {
        bulkActions.style.display = 'none';
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.game-checkbox');
    selectAllCheckbox.checked = allCheckboxes.length > 0 && checkedBoxes.length === allCheckboxes.length;
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.game-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select games to delete.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${checkedBoxes.length} selected game(s)? This action cannot be undone.`)) {
        document.getElementById('bulkForm').submit();
    }
}

// Initialize select all checkbox state
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const gameCheckboxes = document.querySelectorAll('.game-checkbox');
            gameCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }
});
</script>
@endsection
