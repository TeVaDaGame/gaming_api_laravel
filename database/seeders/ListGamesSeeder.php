<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class ListGamesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Games in database:');
        $this->command->info('==================');
        
        $games = Game::all();
        foreach ($games as $game) {
            $this->command->info("'{$game->slug}' => '{$game->title}'");
        }
        
        $this->command->info("\nTotal games: " . $games->count());
    }
}
