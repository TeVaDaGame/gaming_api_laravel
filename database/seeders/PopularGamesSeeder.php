<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Game;

class PopularGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's add more publishers, developers, and genres for the popular games
          // Additional Publishers
        $additionalPublishers = [
            ['name' => 'Rockstar Games', 'slug' => 'rockstar-games', 'founded_year' => 1998],
            ['name' => 'Epic Games', 'slug' => 'epic-games', 'founded_year' => 1991],
            ['name' => 'Valve Corporation', 'slug' => 'valve-corporation', 'founded_year' => 1996],
            ['name' => 'Nintendo', 'slug' => 'nintendo', 'founded_year' => 1889],
            ['name' => 'Take-Two Interactive', 'slug' => 'take-two-interactive', 'founded_year' => 1993],
            ['name' => 'Bethesda Softworks', 'slug' => 'bethesda-softworks', 'founded_year' => 1986],
            ['name' => 'Square Enix', 'slug' => 'square-enix', 'founded_year' => 2003],
            ['name' => 'CD Projekt', 'slug' => 'cd-projekt', 'founded_year' => 1994],
        ];

        foreach ($additionalPublishers as $publisherData) {
            Publisher::firstOrCreate(['slug' => $publisherData['slug']], $publisherData);
        }

        // Additional Developers
        $additionalDevelopers = [
            ['name' => 'Rockstar North', 'slug' => 'rockstar-north', 'founded_year' => 1988],
            ['name' => 'Epic Games', 'slug' => 'epic-games-dev', 'founded_year' => 1991],
            ['name' => 'Valve', 'slug' => 'valve', 'founded_year' => 1996],
            ['name' => 'Nintendo EPD', 'slug' => 'nintendo-epd', 'founded_year' => 2015],
            ['name' => 'Mojang Studios', 'slug' => 'mojang-studios', 'founded_year' => 2009],
            ['name' => 'Bethesda Game Studios', 'slug' => 'bethesda-game-studios', 'founded_year' => 2001],
            ['name' => 'From Software', 'slug' => 'from-software', 'founded_year' => 1986],
            ['name' => 'Guerrilla Games', 'slug' => 'guerrilla-games', 'founded_year' => 2000],
            ['name' => 'Insomniac Games', 'slug' => 'insomniac-games', 'founded_year' => 1994],
        ];

        foreach ($additionalDevelopers as $developerData) {
            Developer::firstOrCreate(['slug' => $developerData['slug']], $developerData);
        }

        // Additional Genres
        $additionalGenres = [
            ['name' => 'Open World', 'slug' => 'open-world'],
            ['name' => 'Battle Royale', 'slug' => 'battle-royale'],
            ['name' => 'Sandbox', 'slug' => 'sandbox'],
            ['name' => 'Survival', 'slug' => 'survival'],
            ['name' => 'Puzzle', 'slug' => 'puzzle'],
            ['name' => 'Horror', 'slug' => 'horror'],
            ['name' => 'Fighting', 'slug' => 'fighting'],
        ];

        foreach ($additionalGenres as $genreData) {
            Genre::firstOrCreate(['slug' => $genreData['slug']], $genreData);
        }

        // Get IDs for relationships
        $publishers = Publisher::all()->keyBy('slug');
        $developers = Developer::all()->keyBy('slug');
        $genres = Genre::all()->keyBy('slug');
        $platforms = Platform::all()->keyBy('slug');

        // Create 15 Popular Games
        $popularGames = [
            [
                'title' => 'Grand Theft Auto V',
                'slug' => 'grand-theft-auto-v',
                'description' => 'An action-adventure game set in the fictional state of San Andreas, featuring three protagonists.',
                'release_date' => '2013-09-17',
                'publisher' => 'rockstar-games',
                'rating' => 9.6,
                'price' => 29.99,
                'is_active' => true,
                'developers' => ['rockstar-north'],
                'genres' => ['action', 'adventure', 'open-world'],
                'platforms' => ['pc', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Minecraft',
                'slug' => 'minecraft',
                'description' => 'A sandbox game that allows players to build and explore procedurally generated worlds.',
                'release_date' => '2011-11-18',
                'publisher' => 'microsoft-studios',
                'rating' => 9.0,
                'price' => 26.95,
                'is_active' => true,
                'developers' => ['mojang-studios'],
                'genres' => ['sandbox', 'survival', 'adventure'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Fortnite',
                'slug' => 'fortnite',
                'description' => 'A free-to-play battle royale game with building mechanics and vibrant graphics.',
                'release_date' => '2017-07-25',
                'publisher' => 'epic-games',
                'rating' => 8.3,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['epic-games-dev'],
                'genres' => ['battle-royale', 'shooter', 'action'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'The Elder Scrolls V: Skyrim',
                'slug' => 'the-elder-scrolls-v-skyrim',
                'description' => 'An epic fantasy open-world RPG where you can be anyone and do anything.',
                'release_date' => '2011-11-11',
                'publisher' => 'bethesda-softworks',
                'rating' => 9.4,
                'price' => 39.99,
                'is_active' => true,
                'developers' => ['bethesda-game-studios'],
                'genres' => ['rpg', 'open-world', 'adventure'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Elden Ring',
                'slug' => 'elden-ring',
                'description' => 'A fantasy action-RPG adventure set within a world created by Hidetaka Miyazaki and George R.R. Martin.',
                'release_date' => '2022-02-25',
                'publisher' => 'bethesda-softworks',
                'rating' => 9.5,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['from-software'],
                'genres' => ['rpg', 'action', 'open-world'],
                'platforms' => ['pc', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'The Legend of Zelda: Breath of the Wild',
                'slug' => 'the-legend-of-zelda-breath-of-the-wild',
                'description' => 'An open-air adventure that breaks conventions in the Legend of Zelda series.',
                'release_date' => '2017-03-03',
                'publisher' => 'nintendo',
                'rating' => 9.7,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['nintendo-epd'],
                'genres' => ['adventure', 'action', 'open-world'],
                'platforms' => ['nintendo-switch'],
            ],
            [
                'title' => 'Red Dead Redemption 2',
                'slug' => 'red-dead-redemption-2',
                'description' => 'An epic tale of life in Americas unforgiving heartland in 1899.',
                'release_date' => '2018-10-26',
                'publisher' => 'rockstar-games',
                'rating' => 9.7,
                'price' => 59.99,
                'is_active' => true,
                'developers' => ['rockstar-north'],
                'genres' => ['action', 'adventure', 'open-world'],
                'platforms' => ['pc', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'Counter-Strike 2',
                'slug' => 'counter-strike-2',
                'description' => 'The next generation of the worlds most popular FPS franchise.',
                'release_date' => '2023-09-27',
                'publisher' => 'valve-corporation',
                'rating' => 8.8,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['valve'],
                'genres' => ['shooter', 'action', 'strategy'],
                'platforms' => ['pc'],
            ],
            [
                'title' => 'Horizon Zero Dawn',
                'slug' => 'horizon-zero-dawn',
                'description' => 'Experience Aloys entire legendary quest to unravel the mysteries of a world ruled by machines.',
                'release_date' => '2017-02-28',
                'publisher' => 'sony-interactive-entertainment',
                'rating' => 9.0,
                'price' => 49.99,
                'is_active' => true,
                'developers' => ['guerrilla-games'],
                'genres' => ['rpg', 'action', 'adventure'],
                'platforms' => ['pc', 'playstation-5', 'playstation-4'],
            ],
            [
                'title' => 'Spider-Man: Miles Morales',
                'slug' => 'spider-man-miles-morales',
                'description' => 'Experience the rise of Miles Morales as he masters new powers to become his own Spider-Man.',
                'release_date' => '2020-11-12',
                'publisher' => 'sony-interactive-entertainment',
                'rating' => 8.5,
                'price' => 49.99,
                'is_active' => true,
                'developers' => ['insomniac-games'],
                'genres' => ['action', 'adventure', 'open-world'],
                'platforms' => ['playstation-5', 'playstation-4'],
            ],
            [
                'title' => 'Apex Legends',
                'slug' => 'apex-legends',
                'description' => 'A free-to-play hero shooter battle royale game set in the Titanfall universe.',
                'release_date' => '2019-02-04',
                'publisher' => 'electronic-arts',
                'rating' => 8.2,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['dice'],
                'genres' => ['battle-royale', 'shooter', 'action'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'FIFA 23',
                'slug' => 'fifa-23',
                'description' => 'The Worlds Game featuring both mens and womens FIFA World Cup competitions.',
                'release_date' => '2022-09-30',
                'publisher' => 'electronic-arts',
                'rating' => 8.0,
                'price' => 69.99,
                'is_active' => true,
                'developers' => ['dice'],
                'genres' => ['sports', 'simulation'],
                'platforms' => ['pc', 'nintendo-switch', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
            [
                'title' => 'God of War',
                'slug' => 'god-of-war-2018',
                'description' => 'Kratos returns in an epic Norse mythology adventure with his son Atreus.',
                'release_date' => '2018-04-20',
                'publisher' => 'sony-interactive-entertainment',
                'rating' => 9.5,
                'price' => 39.99,
                'is_active' => true,
                'developers' => ['naughty-dog'],
                'genres' => ['action', 'adventure', 'rpg'],
                'platforms' => ['pc', 'playstation-5', 'playstation-4'],
            ],
            [
                'title' => 'Valorant',
                'slug' => 'valorant',
                'description' => 'A 5v5 character-based tactical FPS where precise gunplay meets unique agent abilities.',
                'release_date' => '2020-06-02',
                'publisher' => 'take-two-interactive',
                'rating' => 8.3,
                'price' => 0.00,
                'is_active' => true,
                'developers' => ['epic-games-dev'],
                'genres' => ['shooter', 'action', 'strategy'],
                'platforms' => ['pc'],
            ],            [
                'title' => 'Cyberpunk 2077',
                'slug' => 'cyberpunk-2077',
                'description' => 'An open-world action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.',
                'release_date' => '2020-12-10',
                'publisher' => 'cd-projekt',
                'rating' => 7.8,
                'price' => 49.99,
                'is_active' => true,
                'developers' => ['cd-projekt-red'],
                'genres' => ['rpg', 'action', 'open-world'],
                'platforms' => ['pc', 'playstation-5', 'xbox-series-x-s', 'playstation-4', 'xbox-one'],
            ],
        ];

        foreach ($popularGames as $gameData) {
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

        $this->command->info("Popular games seeder completed!");
    }
}
