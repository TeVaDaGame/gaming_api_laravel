<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Game;
use App\Models\User;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data in proper order (respecting foreign keys)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Game::truncate();
        \DB::table('developer_game')->truncate();
        \DB::table('game_genre')->truncate();
        \DB::table('game_platform')->truncate();
        Publisher::truncate();
        Developer::truncate();
        Genre::truncate();
        Platform::truncate();
        
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create Publishers
        $publishers = [
            ['name' => 'Electronic Arts', 'slug' => 'electronic-arts', 'founded_year' => 1982],
            ['name' => 'Activision Blizzard', 'slug' => 'activision-blizzard', 'founded_year' => 1979],
            ['name' => 'Ubisoft', 'slug' => 'ubisoft', 'founded_year' => 1986],
            ['name' => 'Sony Interactive Entertainment', 'slug' => 'sony-interactive-entertainment', 'founded_year' => 1993],
            ['name' => 'Microsoft Studios', 'slug' => 'microsoft-studios', 'founded_year' => 2000],
        ];

        foreach ($publishers as $publisherData) {
            Publisher::create($publisherData);
        }

        // Create Developers
        $developers = [
            ['name' => 'DICE', 'slug' => 'dice', 'founded_year' => 1992],
            ['name' => 'Infinity Ward', 'slug' => 'infinity-ward', 'founded_year' => 2002],
            ['name' => 'Ubisoft Montreal', 'slug' => 'ubisoft-montreal', 'founded_year' => 1997],
            ['name' => 'Naughty Dog', 'slug' => 'naughty-dog', 'founded_year' => 1984],
            ['name' => 'Turn 10 Studios', 'slug' => 'turn-10-studios', 'founded_year' => 2001],
            ['name' => 'CD Projekt RED', 'slug' => 'cd-projekt-red', 'founded_year' => 2002],
        ];

        foreach ($developers as $developerData) {
            Developer::create($developerData);
        }

        // Create Genres
        $genres = [
            ['name' => 'Action', 'slug' => 'action'],
            ['name' => 'Adventure', 'slug' => 'adventure'],
            ['name' => 'RPG', 'slug' => 'rpg'],
            ['name' => 'Shooter', 'slug' => 'shooter'],
            ['name' => 'Racing', 'slug' => 'racing'],
            ['name' => 'Strategy', 'slug' => 'strategy'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Simulation', 'slug' => 'simulation'],
        ];

        foreach ($genres as $genreData) {
            Genre::create($genreData);
        }

        // Create Platforms
        $platforms = [
            ['name' => 'PlayStation 5', 'slug' => 'playstation-5'],
            ['name' => 'Xbox Series X/S', 'slug' => 'xbox-series-x-s'],
            ['name' => 'Nintendo Switch', 'slug' => 'nintendo-switch'],
            ['name' => 'PC', 'slug' => 'pc'],
            ['name' => 'PlayStation 4', 'slug' => 'playstation-4'],
            ['name' => 'Xbox One', 'slug' => 'xbox-one'],
        ];

        foreach ($platforms as $platformData) {
            Platform::create($platformData);
        }

        // Create sample games
        $games = [
            [
                'title' => 'Battlefield 2042',
                'slug' => 'battlefield-2042',
                'description' => 'A first-person shooter set in a near-future world transformed by disorder.',
                'release_date' => '2021-11-19',
                'publisher_id' => 1, // EA
                'rating' => 7.2,
                'price' => 59.99,
                'is_active' => true,
                'developers' => [1], // DICE
                'genres' => [1, 4], // Action, Shooter
                'platforms' => [1, 2, 4, 5, 6], // PS5, Xbox Series, PC, PS4, Xbox One
            ],
            [
                'title' => 'Call of Duty: Modern Warfare II',
                'slug' => 'call-of-duty-modern-warfare-ii',
                'description' => 'The ultimate weapon is team. Call of Duty returns with Modern Warfare II.',
                'release_date' => '2022-10-28',
                'publisher_id' => 2, // Activision Blizzard
                'rating' => 8.5,
                'price' => 69.99,
                'is_active' => true,
                'developers' => [2], // Infinity Ward
                'genres' => [1, 4], // Action, Shooter
                'platforms' => [1, 2, 4, 5, 6],
            ],
            [
                'title' => 'Assassins Creed Valhalla',
                'slug' => 'assassins-creed-valhalla',
                'description' => 'Become Eivor, a legendary Viking raider on a quest for glory.',
                'release_date' => '2020-11-10',
                'publisher_id' => 3, // Ubisoft
                'rating' => 8.1,
                'price' => 49.99,
                'is_active' => true,
                'developers' => [3], // Ubisoft Montreal
                'genres' => [1, 2, 3], // Action, Adventure, RPG
                'platforms' => [1, 2, 4, 5, 6],
            ],
            [
                'title' => 'The Last of Us Part II',
                'slug' => 'the-last-of-us-part-ii',
                'description' => 'Experience the emotional sequel to the critically acclaimed survival action game.',
                'release_date' => '2020-06-19',
                'publisher_id' => 4, // Sony
                'rating' => 9.2,
                'price' => 39.99,
                'is_active' => true,
                'developers' => [4], // Naughty Dog
                'genres' => [1, 2], // Action, Adventure
                'platforms' => [1, 5], // PS5, PS4
            ],
            [
                'title' => 'Forza Horizon 5',
                'slug' => 'forza-horizon-5',
                'description' => 'Your Horizon Adventure awaits! Explore the vibrant and ever-evolving open world landscapes of Mexico.',
                'release_date' => '2021-11-09',
                'publisher_id' => 5, // Microsoft
                'rating' => 9.0,
                'price' => 59.99,
                'is_active' => true,
                'developers' => [5], // Turn 10
                'genres' => [5], // Racing
                'platforms' => [2, 4, 6], // Xbox Series, PC, Xbox One
            ],
        ];

        foreach ($games as $gameData) {
            $developers = $gameData['developers'];
            $genres = $gameData['genres'];
            $platforms = $gameData['platforms'];
            $releaseDate = $gameData['release_date'];
            
            unset($gameData['developers'], $gameData['genres'], $gameData['platforms']);
            
            $game = Game::create($gameData);
            
            $game->developers()->attach($developers);
            $game->genres()->attach($genres);
            
            // Attach platforms with release dates
            foreach ($platforms as $platformId) {
                $game->platforms()->attach($platformId, ['release_date' => $releaseDate]);
            }
        }

        // Create users if they don't exist
        if (!User::where('email', 'admin@gaming-api.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@gaming-api.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
        }
        
        if (!User::where('email', 'user@gaming-api.com')->exists()) {
            User::create([
                'name' => 'Regular User',
                'email' => 'user@gaming-api.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]);
        }
    }
}
