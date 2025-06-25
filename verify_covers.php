<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Game;

echo "Verifying game covers...\n";
echo "========================\n\n";

$totalGames = Game::count();
$gamesWithCovers = Game::whereNotNull('image_url')->where('image_url', '!=', '')->count();

echo "Total games: {$totalGames}\n";
echo "Games with covers: {$gamesWithCovers}\n";
echo "Coverage: " . round(($gamesWithCovers / $totalGames) * 100, 2) . "%\n\n";

if ($gamesWithCovers < $totalGames) {
    echo "Games without covers:\n";
    $gamesWithoutCovers = Game::where(function($query) {
        $query->whereNull('image_url')->orWhere('image_url', '');
    })->get(['title', 'slug']);
    
    foreach ($gamesWithoutCovers as $game) {
        echo "- {$game->title} ({$game->slug})\n";
    }
} else {
    echo "✅ All games have covers!\n\n";
    
    echo "Sample of games with covers:\n";
    $sampleGames = Game::take(5)->get(['title', 'image_url']);
    foreach ($sampleGames as $game) {
        echo "- {$game->title}: " . (strlen($game->image_url) > 50 ? substr($game->image_url, 0, 50) . '...' : $game->image_url) . "\n";
    }
}

echo "\nVerification complete!\n";
