<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Game;
use App\Models\UserFavorite;

class UserFavoritesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users and games for testing
        $users = User::where('role', '!=', 'admin')->take(3)->get();
        $games = Game::take(10)->get();

        if ($users->count() == 0 || $games->count() == 0) {
            $this->command->info('No users or games found. Please seed users and games first.');
            return;
        }

        $this->command->info('Creating sample user favorites...');

        foreach ($users as $user) {
            // Add some favorites for each user
            $favoriteGames = $games->random(rand(3, 5));
            foreach ($favoriteGames as $game) {
                UserFavorite::firstOrCreate([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'type' => 'favorite'
                ], [
                    'notes' => $this->getRandomNote($game->title)
                ]);
            }

            // Add some wishlist items for each user
            $wishlistGames = $games->diff($favoriteGames)->random(rand(2, 4));
            foreach ($wishlistGames as $game) {
                UserFavorite::firstOrCreate([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'type' => 'wishlist'
                ], [
                    'notes' => $this->getRandomWishlistNote($game->title)
                ]);
            }

            $favCount = $user->userFavorites()->where('type', 'favorite')->count();
            $wishCount = $user->userFavorites()->where('type', 'wishlist')->count();
            $this->command->info("User {$user->name}: {$favCount} favorites, {$wishCount} wishlist items");
        }

        $this->command->info('User favorites seeding completed!');
    }

    private function getRandomNote($gameTitle)
    {
        $notes = [
            "Amazing game! Can't wait to play it again.",
            "One of my all-time favorites.",
            "Great graphics and storyline.",
            "Highly recommended to everyone.",
            "Perfect for relaxing after work.",
            "Love the multiplayer experience.",
            "Incredible soundtrack and atmosphere.",
            "This game changed my perspective on gaming.",
            null, // Some entries without notes
            null,
        ];

        return $notes[array_rand($notes)];
    }

    private function getRandomWishlistNote($gameTitle)
    {
        $notes = [
            "Waiting for a sale to buy this.",
            "Heard great things about this game.",
            "Want to play this with friends.",
            "On my must-play list for this year.",
            "Looks interesting, need to research more.",
            "Waiting for DLC to be released.",
            "Gift idea for my birthday.",
            null, // Some entries without notes
            null,
        ];

        return $notes[array_rand($notes)];
    }
}
