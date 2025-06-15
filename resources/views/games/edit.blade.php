@extends('layouts.app')

@section('title', 'Edit Game')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Game: {{ $game->title }}
                    </h4>
                    <a href="{{ route('games.manage') }}" class="btn btn-outline-dark btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('games.update', $game) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $game->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $game->slug) }}" required>
                                    <div class="form-text">URL-friendly version of the title</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $game->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="release_date" class="form-label">Release Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" 
                                           id="release_date" name="release_date" 
                                           value="{{ old('release_date', $game->release_date->format('Y-m-d')) }}" required>
                                    @error('release_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="publisher_id" class="form-label">Publisher <span class="text-danger">*</span></label>
                                    <select class="form-select @error('publisher_id') is-invalid @enderror" 
                                            id="publisher_id" name="publisher_id" required>
                                        <option value="">Select Publisher</option>
                                        @foreach($publishers as $publisher)
                                            <option value="{{ $publisher->id }}" 
                                                    {{ old('publisher_id', $game->publisher_id) == $publisher->id ? 'selected' : '' }}>
                                                {{ $publisher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('publisher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating (0-10) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('rating') is-invalid @enderror" 
                                           id="rating" name="rating" min="0" max="10" step="0.1" 
                                           value="{{ old('rating', $game->rating) }}" required>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" min="0" step="0.01" 
                                           value="{{ old('price', $game->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="developer_ids" class="form-label">Developers <span class="text-danger">*</span></label>
                            <select class="form-select @error('developer_ids') is-invalid @enderror" 
                                    id="developer_ids" name="developer_ids[]" multiple required>
                                @foreach($developers as $developer)
                                    <option value="{{ $developer->id }}" 
                                            {{ in_array($developer->id, old('developer_ids', $game->developers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $developer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple developers</div>
                            @error('developer_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genre_ids" class="form-label">Genres</label>
                            <select class="form-select @error('genre_ids') is-invalid @enderror" 
                                    id="genre_ids" name="genre_ids[]" multiple>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" 
                                            {{ in_array($genre->id, old('genre_ids', $game->genres->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple genres</div>
                            @error('genre_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="platform_ids" class="form-label">Platforms</label>
                            <select class="form-select @error('platform_ids') is-invalid @enderror" 
                                    id="platform_ids" name="platform_ids[]" multiple>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}" 
                                            {{ in_array($platform->id, old('platform_ids', $game->platforms->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $platform->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple platforms</div>
                            @error('platform_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $game->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('games.manage') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Games
                                </a>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-house me-2"></i>Dashboard
                                </a>
                            </div>
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="bi bi-save me-2"></i>Update Game
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
                      .replace(/[^a-z0-9 -]/g, '')
                      .replace(/\s+/g, '-')
                      .replace(/-+/g, '-')
                      .trim('-');
    document.getElementById('slug').value = slug;
});
</script>
@endsection
