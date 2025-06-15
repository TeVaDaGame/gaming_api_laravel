@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-gear me-2"></i>Settings
                </h1>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Display & Interface Settings -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-palette me-2"></i>Display & Interface
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="theme" class="form-label">Theme</label>
                                    <select class="form-select @error('theme') is-invalid @enderror" id="theme" name="theme">
                                        <option value="light" {{ $user->getSetting('theme') == 'light' ? 'selected' : '' }}>
                                            <i class="bi bi-sun"></i> Light Mode
                                        </option>
                                        <option value="dark" {{ $user->getSetting('theme') == 'dark' ? 'selected' : '' }}>
                                            <i class="bi bi-moon"></i> Dark Mode
                                        </option>
                                    </select>
                                    @error('theme')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="items_per_page" class="form-label">Items Per Page</label>
                                    <select class="form-select @error('items_per_page') is-invalid @enderror" id="items_per_page" name="items_per_page">
                                        <option value="6" {{ $user->getSetting('items_per_page') == 6 ? 'selected' : '' }}>6 items</option>
                                        <option value="12" {{ $user->getSetting('items_per_page') == 12 ? 'selected' : '' }}>12 items</option>
                                        <option value="24" {{ $user->getSetting('items_per_page') == 24 ? 'selected' : '' }}>24 items</option>
                                        <option value="48" {{ $user->getSetting('items_per_page') == 48 ? 'selected' : '' }}>48 items</option>
                                    </select>
                                    @error('items_per_page')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_format" class="form-label">Date Format</label>
                                    <select class="form-select @error('date_format') is-invalid @enderror" id="date_format" name="date_format">
                                        <option value="M d Y" {{ $user->getSetting('date_format') == 'M d Y' ? 'selected' : '' }}>Jan 15, 2025</option>
                                        <option value="d/m/Y" {{ $user->getSetting('date_format') == 'd/m/Y' ? 'selected' : '' }}>15/01/2025</option>
                                        <option value="Y-m-d" {{ $user->getSetting('date_format') == 'Y-m-d' ? 'selected' : '' }}>2025-01-15</option>
                                    </select>
                                    @error('date_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="time_zone" class="form-label">Time Zone</label>
                                    <input type="text" class="form-control @error('time_zone') is-invalid @enderror" 
                                           id="time_zone" name="time_zone" value="{{ $user->getSetting('time_zone') }}" 
                                           placeholder="UTC">
                                    @error('time_zone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bell me-2"></i>Notifications & Preferences
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" 
                                           name="email_notifications" value="1" 
                                           {{ $user->getSetting('email_notifications') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications">
                                        <i class="bi bi-envelope me-1"></i>Email Notifications
                                    </label>
                                    <div class="form-text">Receive notifications about new games and updates</div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="review_notifications" 
                                           name="review_notifications" value="1" 
                                           {{ $user->getSetting('review_notifications') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="review_notifications">
                                        <i class="bi bi-chat-dots me-1"></i>Review Notifications
                                    </label>
                                    <div class="form-text">Get notified when someone interacts with your reviews</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="newsletter_subscription" 
                                           name="newsletter_subscription" value="1" 
                                           {{ $user->getSetting('newsletter_subscription') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="newsletter_subscription">
                                        <i class="bi bi-newspaper me-1"></i>Newsletter Subscription
                                    </label>
                                    <div class="form-text">Receive our weekly gaming newsletter</div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="game_recommendations" 
                                           name="game_recommendations" value="1" 
                                           {{ $user->getSetting('game_recommendations') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="game_recommendations">
                                        <i class="bi bi-lightbulb me-1"></i>Game Recommendations
                                    </label>
                                    <div class="form-text">Get personalized game suggestions</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gaming Preferences -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-joystick me-2"></i>Gaming Preferences
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="favorite_genres" class="form-label">Favorite Genres</label>
                                    <select class="form-select" id="favorite_genres" name="favorite_genres[]" multiple size="6">
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" 
                                                {{ in_array($genre->id, $user->getSetting('favorite_genres', [])) ? 'selected' : '' }}>
                                                {{ $genre->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Hold Ctrl/Cmd to select multiple genres</div>
                                </div>

                                <div class="mb-3">
                                    <label for="rating_display" class="form-label">Rating Display</label>
                                    <select class="form-select @error('rating_display') is-invalid @enderror" id="rating_display" name="rating_display">
                                        <option value="stars" {{ $user->getSetting('rating_display') == 'stars' ? 'selected' : '' }}>⭐ Stars</option>
                                        <option value="numbers" {{ $user->getSetting('rating_display') == 'numbers' ? 'selected' : '' }}>Numbers (1-5)</option>
                                        <option value="both" {{ $user->getSetting('rating_display') == 'both' ? 'selected' : '' }}>Both Stars & Numbers</option>
                                    </select>
                                    @error('rating_display')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="preferred_platforms" class="form-label">Preferred Platforms</label>
                                    <select class="form-select" id="preferred_platforms" name="preferred_platforms[]" multiple size="6">
                                        @foreach($platforms as $platform)
                                            <option value="{{ $platform->id }}" 
                                                {{ in_array($platform->id, $user->getSetting('preferred_platforms', [])) ? 'selected' : '' }}>
                                                {{ $platform->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Hold Ctrl/Cmd to select multiple platforms</div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="mature_content_filter" 
                                           name="mature_content_filter" value="1" 
                                           {{ $user->getSetting('mature_content_filter') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mature_content_filter">
                                        <i class="bi bi-shield-exclamation me-1"></i>Filter Mature Content
                                    </label>
                                    <div class="form-text">Hide mature-rated games from search results</div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="show_only_available" 
                                           name="show_only_available" value="1" 
                                           {{ $user->getSetting('show_only_available') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_only_available">
                                        <i class="bi bi-check-circle me-1"></i>Show Only Available Games
                                    </label>
                                    <div class="form-text">Hide discontinued or unavailable games</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-lock me-2"></i>Privacy & Data
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profile_visibility" class="form-label">Profile Visibility</label>
                                    <select class="form-select @error('profile_visibility') is-invalid @enderror" 
                                            id="profile_visibility" name="profile_visibility">
                                        <option value="public" {{ $user->getSetting('profile_visibility') == 'public' ? 'selected' : '' }}>
                                            <i class="bi bi-globe"></i> Public
                                        </option>
                                        <option value="private" {{ $user->getSetting('profile_visibility') == 'private' ? 'selected' : '' }}>
                                            <i class="bi bi-lock"></i> Private
                                        </option>
                                    </select>
                                    @error('profile_visibility')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="review_privacy" class="form-label">Review Privacy</label>
                                    <select class="form-select @error('review_privacy') is-invalid @enderror" 
                                            id="review_privacy" name="review_privacy">
                                        <option value="public" {{ $user->getSetting('review_privacy') == 'public' ? 'selected' : '' }}>
                                            <i class="bi bi-eye"></i> Public
                                        </option>
                                        <option value="private" {{ $user->getSetting('review_privacy') == 'private' ? 'selected' : '' }}>
                                            <i class="bi bi-eye-slash"></i> Private
                                        </option>
                                    </select>
                                    @error('review_privacy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="activity_tracking" 
                                           name="activity_tracking" value="1" 
                                           {{ $user->getSetting('activity_tracking') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="activity_tracking">
                                        <i class="bi bi-activity me-1"></i>Allow Activity Tracking
                                    </label>
                                    <div class="form-text">Help us improve the platform by tracking anonymous usage data</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="button" class="btn btn-outline-warning" onclick="resetToDefaults()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset to Defaults
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Reset to default values
function resetToDefaults() {
    if (confirm('Are you sure you want to reset all settings to their default values?')) {
        // Reset form fields to defaults
        document.getElementById('theme').value = 'light';
        document.getElementById('items_per_page').value = '12';
        document.getElementById('date_format').value = 'M d Y';
        document.getElementById('time_zone').value = 'UTC';
        document.getElementById('rating_display').value = 'stars';
        document.getElementById('profile_visibility').value = 'public';
        document.getElementById('review_privacy').value = 'public';
        
        // Reset checkboxes
        document.getElementById('email_notifications').checked = true;
        document.getElementById('review_notifications').checked = true;
        document.getElementById('newsletter_subscription').checked = false;
        document.getElementById('game_recommendations').checked = true;
        document.getElementById('mature_content_filter').checked = false;
        document.getElementById('show_only_available').checked = false;
        document.getElementById('activity_tracking').checked = true;
        
        // Clear multi-selects
        document.getElementById('favorite_genres').selectedIndex = -1;
        document.getElementById('preferred_platforms').selectedIndex = -1;
    }
}

// Theme preview
document.getElementById('theme').addEventListener('change', function() {
    const theme = this.value;
    if (theme === 'dark') {
        document.body.style.backgroundColor = '#212529';
        document.body.style.color = '#fff';
    } else {
        document.body.style.backgroundColor = '';
        document.body.style.color = '';
    }
});
</script>
@endsection
