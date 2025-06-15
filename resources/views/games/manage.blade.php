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
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">All Games</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
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
                            <tbody>
                                @forelse($games as $game)
                                <tr>
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
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox h1 d-block mb-3"></i>
                                            <p class="mb-0">No games found. <a href="{{ route('games.create') }}">Create your first game</a></p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($games->hasPages())
                <div class="card-footer">
                    {{ $games->links() }}
                </div>
                @endif
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
</script>
@endsection
