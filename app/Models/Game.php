<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_url',
        'cover_image',
        'release_date',
        'publisher_id',
        'rating',
        'price',
        'is_active'
    ];

    protected $casts = [
        'release_date' => 'date',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_active' => 'boolean'
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class, 'developer_game')
                    ->withPivot('role')
                    ->withTimestamps();
    }    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'game_platform')
                    ->withPivot('release_date');
    }public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'game_genre');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get users who favorited this game
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites')
                    ->wherePivot('type', 'favorite')
                    ->withPivot(['notes', 'created_at'])
                    ->withTimestamps();
    }

    /**
     * Get users who wishlisted this game
     */
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites')
                    ->wherePivot('type', 'wishlist')
                    ->withPivot(['notes', 'created_at'])
                    ->withTimestamps();
    }

    /**
     * Check if a specific user has favorited this game
     */
    public function isFavoritedBy($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a specific user has wishlisted this game
     */
    public function isWishlistedBy($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        return $this->wishlistedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Get favorites count for this game
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favoritedBy()->count();
    }

    /**
     * Get wishlist count for this game
     */
    public function getWishlistCountAttribute()
    {
        return $this->wishlistedBy()->count();
    }

    /**
     * Get the primary image URL for this game
     */
    public function getImageAttribute()
    {
        return $this->image_url ?: $this->cover_image ?: $this->getPlaceholderImage();
    }    /**
     * Get placeholder image URL
     */
    public function getPlaceholderImage()
    {
        // Use a faster, more reliable placeholder service
        $gameSlug = urlencode(substr($this->title, 0, 20));
        
        // Use a solid color with game initials for better performance
        $colors = ['4F46E5', '059669', 'DC2626', '7C3AED', '0891B2', 'EA580C'];
        $colorIndex = crc32($this->title) % count($colors);
        $color = $colors[$colorIndex];
        
        $initials = $this->getGameInitials();
        
        // Use a simpler, faster placeholder that won't cause glitching
        return "https://dummyimage.com/300x400/{$color}/ffffff&text={$initials}";
    }
    
    /**
     * Get game initials for placeholder
     */
    private function getGameInitials()
    {
        $words = explode(' ', $this->title);
        $initials = '';
        
        foreach (array_slice($words, 0, 2) as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        return $initials ?: 'GAME';
    }

    /**
     * Get color code for placeholder
     */
    private function getColorCode($bootstrapClass)
    {
        $colorMap = [
            'bg-primary' => '0d6efd',
            'bg-success' => '198754',
            'bg-warning' => 'ffc107',
            'bg-danger' => 'dc3545',
            'bg-info' => '0dcaf0',
            'bg-secondary' => '6c757d',
            'bg-dark' => '212529'
        ];
        
        return $colorMap[$bootstrapClass] ?? '6c757d';
    }

    /**
     * Check if game has a real image (not placeholder)
     */
    public function hasRealImage()
    {
        return !empty($this->image_url) || !empty($this->cover_image);
    }
}
