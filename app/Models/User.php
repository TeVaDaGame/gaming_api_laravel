<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get default settings
     */
    public function getDefaultSettings()
    {
        return [
            'theme' => 'light',
            'items_per_page' => 12,
            'date_format' => 'M d, Y',
            'time_zone' => 'UTC',
            'email_notifications' => true,
            'review_notifications' => true,
            'newsletter_subscription' => false,
            'game_recommendations' => true,
            'favorite_genres' => [],
            'preferred_platforms' => [],
            'rating_display' => 'stars',
            'mature_content_filter' => false,
            'show_only_available' => false,
            'profile_visibility' => 'public',
            'review_privacy' => 'public',
            'activity_tracking' => true,
        ];
    }

    /**
     * Get user setting with fallback to default
     */
    public function getSetting($key, $default = null)
    {
        $settings = $this->settings ?? [];
        $defaultSettings = $this->getDefaultSettings();
        
        return $settings[$key] ?? $default ?? $defaultSettings[$key] ?? null;
    }

    /**
     * Update a specific setting
     */
    public function updateSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->update(['settings' => $settings]);
    }

    /**
     * Update multiple settings
     */
    public function updateSettings(array $newSettings)
    {
        $settings = array_merge($this->settings ?? [], $newSettings);
        $this->update(['settings' => $settings]);
    }

    /**
     * Get user's favorite games
     */
    public function favorites()
    {
        return $this->belongsToMany(Game::class, 'user_favorites')
                    ->wherePivot('type', 'favorite')
                    ->withPivot(['notes', 'created_at'])
                    ->withTimestamps();
    }

    /**
     * Get user's wishlist games
     */
    public function wishlist()
    {
        return $this->belongsToMany(Game::class, 'user_favorites')
                    ->wherePivot('type', 'wishlist')
                    ->withPivot(['notes', 'created_at'])
                    ->withTimestamps();
    }

    /**
     * Get all user favorites (both favorites and wishlist)
     */
    public function userFavorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    /**
     * Check if user has favorited a game
     */
    public function hasFavorited($gameId, $type = 'favorite')
    {
        return $this->userFavorites()
                    ->where('game_id', $gameId)
                    ->where('type', $type)
                    ->exists();
    }

    /**
     * Add game to favorites or wishlist
     */
    public function addToFavorites($gameId, $type = 'favorite', $notes = null)
    {
        return $this->userFavorites()->updateOrCreate(
            ['game_id' => $gameId, 'type' => $type],
            ['notes' => $notes]
        );
    }

    /**
     * Remove game from favorites or wishlist
     */
    public function removeFromFavorites($gameId, $type = 'favorite')
    {
        return $this->userFavorites()
                    ->where('game_id', $gameId)
                    ->where('type', $type)
                    ->delete();
    }
}
