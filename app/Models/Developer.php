<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Developer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'founded_year',
        'headquarters',
        'website_url'
    ];

    protected $casts = [
        'founded_year' => 'integer'
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'developer_game')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
