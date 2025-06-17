<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Game;

class AdditionalPopularGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's add more publishers and developers for the new games
          // Additional Publishers
        $additionalPublishers = [
            ['name' => 'Endnight Games', 'slug' => 'endnight-games', 'founded_year' => 2013],
            ['name' => 'Respawn Entertainment', 'slug' => 'respawn-entertainment', 'founded_year' => 2010],
            ['name' => 'Riot Games', 'slug' => 'riot-games', 'founded_year' => 2006],
            ['name' => 'Bandai Namco Entertainment', 'slug' => 'bandai-namco-entertainment', 'founded_year' => 2006],
            ['name' => 'Psyonix', 'slug' => 'psyonix', 'founded_year' => 2000],
            ['name' => 'Re-Logic', 'slug' => 're-logic', 'founded_year' => 2011],
            ['name' => 'Larian Studios', 'slug' => 'larian-studios', 'founded_year' => 1996],
            ['name' => 'Hello Games', 'slug' => 'hello-games', 'founded_year' => 2008],
            ['name' => 'ConcernedApe', 'slug' => 'concerned-ape', 'founded_year' => 2011],
        ];

        foreach ($additionalPublishers as $publisherData) {
            Publisher::firstOrCreate(['slug' => $publisherData['slug']], $publisherData);
        }

        // Additional Developers
        $additionalDevelopers = [
            ['name' => 'Endnight Games Ltd', 'slug' => 'endnight-games-ltd', 'founded_year' => 2013],
            ['name' => 'Respawn Entertainment', 'slug' => 'respawn-entertainment-dev', 'founded_year' => 2010],
            ['name' => 'Riot Games', 'slug' => 'riot-games-dev', 'founded_year' => 2006],
            ['name' => 'FromSoftware', 'slug' => 'fromsoftware', 'founded_year' => 1986],
            ['name' => 'Psyonix', 'slug' => 'psyonix-dev', 'founded_year' => 2000],
            ['name' => 'Re-Logic', 'slug' => 're-logic-dev', 'founded_year' => 2011],
            ['name' => 'Larian Studios', 'slug' => 'larian-studios-dev', 'founded_year' => 1996],
            ['name' => 'Hello Games', 'slug' => 'hello-games', 'founded_year' => 2008],
            ['name' => 'Concerned Ape', 'slug' => 'concerned-ape', 'founded_year' => 2011],
        ];

        foreach ($additionalDevelopers as $developerData) {
            Developer::firstOrCreate(['slug' => $developerData['slug']], $developerData);
        }

        // Additional Genres
        $additionalGenres = [
            ['name' => 'Indie', 'slug' => 'indie'],
            ['name' => 'Farming Simulation', 'slug' => 'farming-simulation'],
            ['name' => 'Space Exploration', 'slug' => 'space-exploration'],
            ['name' => 'Turn-Based Strategy', 'slug' => 'turn-based-strategy'],
            ['name' => 'MOBA', 'slug' => 'moba'],
            ['name' => 'Souls-like', 'slug' => 'souls-like'],
        ];

        foreach ($additionalGenres as $genreData) {
            Genre::firstOrCreate(['slug' => $genreData['slug']], $genreData);
        }

        // Get IDs for relationships
        $publishers = Publisher::all()->keyBy('slug');
        $developers = Developer::all()->keyBy('slug');
        $genres = Genre::all()->keyBy('slug');
        $platforms = Platform::all()->keyBy('slug');

        // Create 10 Additional Popular Games
        $newPopularGames = [
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'slug' => 'the-witcher-3-wild-hunt',
                'description' => 'An epic open-world fantasy RPG following Geralt of Rivia on his quest to find his adopted daughter.',
                'release_date' => '2015-05-19',
                'publisher' => 'cd-projekt',
                'rating' => 9.8,
                'price' => 39.99,
                'is_active' => true,
                'developers' => ['cd-projekt-red'],
                'genres' => ['rpg', 'open-world', 'adventure'],
                'platforms' => ['pc', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one', 'nintendo-switch'],
            ],
            [
                'title' => 'Sons of the Forest',
                'slug' => 'sons-of-the-forest',
                'description' => 'A survival horror game where you fight off cannibalistic mutants in a mysterious forest.',
                'release_date' => '2023-02-23',
                'publisher' => 'endnight-games',
                'rating' => 8.4,
                'price' => 29.99,
                'is_active' => true,
                'developers' => ['endnight-games-ltd'],
                'genres' => ['survival', 'horror', 'action'],
                'platforms' => ['pc'],
            ],
            [
                'title' => 'Apex Legends Mobile',
                'slug' => 'apex-legends-mobile',
                'description' => 'The mobile version of the popular battle royale game with optimized controls and features.',
                'release_date' => '2022-05-17',
                'publisher' => 'electronic-arts',
                'rating' => 7.9,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['respawn-entertainment-dev'],
                'genres' => ['battle-royale', 'shooter', 'action'],
                'platforms' => ['pc', 'nintendo-switch'],
            ],
            [
                'title' => 'League of Legends',
                'slug' => 'league-of-legends',
                'description' => 'The worlds most popular multiplayer online battle arena (MOBA) game.',
                'release_date' => '2009-10-27',
                'publisher' => 'riot-games',
                'rating' => 8.6,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['riot-games-dev'],
                'genres' => ['moba', 'strategy', 'action'],
                'platforms' => ['pc'],
            ],
            [
                'title' => 'Dark Souls III',
                'slug' => 'dark-souls-iii',
                'description' => 'The final chapter in the critically acclaimed Dark Souls series, known for its challenging gameplay.',
                'release_date' => '2016-04-12',
                'publisher' => 'bandai-namco-entertainment',
                'rating' => 9.1,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['fromsoftware'],
                'genres' => ['souls-like', 'rpg', 'action'],
                'platforms' => ['pc', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Rocket League',
                'slug' => 'rocket-league',
                'description' => 'A unique blend of soccer and driving, featuring rocket-powered cars in competitive matches.',
                'release_date' => '2015-07-07',
                'publisher' => 'psyonix',
                'rating' => 8.7,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['psyonix-dev'],
                'genres' => ['sports', 'racing', 'action'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Terraria',
                'slug' => 'terraria',
                'description' => 'A 2D sandbox adventure game with crafting, building, and exploration in procedurally generated worlds.',
                'release_date' => '2011-05-16',
                'publisher' => 're-logic',
                'rating' => 8.9,
                'price' => 9.99,
                'is_active' => true,
                'developers' => ['re-logic-dev'],
                'genres' => ['sandbox', 'indie', 'adventure'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Baldurs Gate 3',
                'slug' => 'baldurs-gate-3',
                'description' => 'A story-rich RPG based on Dungeons & Dragons, featuring turn-based combat and deep character customization.',
                'release_date' => '2023-08-03',
                'publisher' => 'larian-studios',
                'rating' => 9.6,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['larian-studios-dev'],
                'genres' => ['rpg', 'turn-based-strategy', 'adventure'],
                'platforms' => ['pc', 'playstation-5'],
            ],            [
                'title' => 'No Mans Sky',
                'slug' => 'no-mans-sky',
                'description' => 'An infinite universe exploration game with procedurally generated planets, creatures, and adventures.',
                'release_date' => '2016-08-09',
                'publisher' => 'hello-games',
                'rating' => 8.1,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['hello-games'],
                'genres' => ['space-exploration', 'survival', 'adventure'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Stardew Valley',
                'slug' => 'stardew-valley',
                'description' => 'A charming farming simulation game where you inherit your grandfathers farm and build a new life.',
                'release_date' => '2016-02-26',
                'publisher' => 'concerned-ape',
                'rating' => 9.2,
                'price' => 14.99,
                'is_active' => true,
                'developers' => ['concerned-ape'],
                'genres' => ['farming-simulation', 'indie', 'simulation'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
        ];

        foreach ($newPopularGames as $gameData) {
            // Check if game already exists
            if (Game::where('slug', $gameData['slug'])->exists()) {
                $this->command->info("Game '{$gameData['title']}' already exists, skipping...");
                continue;
            }

            $developerSlugs = $gameData['developers'];
            $genreSlugs = $gameData['genres'];
            $platformSlugs = $gameData['platforms'];
            $publisherSlug = $gameData['publisher'];
            $releaseDate = $gameData['release_date'];
            
            // Remove relationships from game data
            unset($gameData['developers'], $gameData['genres'], $gameData['platforms'], $gameData['publisher']);
            
            // Set publisher ID
            if (!isset($publishers[$publisherSlug])) {
                $this->command->error("Publisher '{$publisherSlug}' not found, skipping game '{$gameData['title']}'");
                continue;
            }
            $gameData['publisher_id'] = $publishers[$publisherSlug]->id;
            
            // Create the game
            $game = Game::create($gameData);
            
            // Attach developers
            foreach ($developerSlugs as $devSlug) {
                if (isset($developers[$devSlug])) {
                    $game->developers()->attach($developers[$devSlug]->id);
                }
            }
            
            // Attach genres
            foreach ($genreSlugs as $genreSlug) {
                if (isset($genres[$genreSlug])) {
                    $game->genres()->attach($genres[$genreSlug]->id);
                }
            }
            
            // Attach platforms with release dates
            foreach ($platformSlugs as $platformSlug) {
                if (isset($platforms[$platformSlug])) {
                    $game->platforms()->attach($platforms[$platformSlug]->id, ['release_date' => $releaseDate]);
                }
            }

            $this->command->info("Created game: {$game->title}");
        }

        $this->command->info("Additional popular games seeder completed!");
    }
}
