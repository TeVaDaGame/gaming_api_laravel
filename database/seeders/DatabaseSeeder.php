<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        DB::table('users')->insert([
            ['name' => 'John Doe', 'email' => 'john@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Jane Smith', 'email' => 'jane@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Mike Johnson', 'email' => 'mike@gmail.com', 'password' => Hash::make('password')]
        ]);

        // Publishers
        DB::table('publishers')->insert([
            [
                'name' => 'Electronic Arts',
                'slug' => 'electronic-arts',
                'description' => 'Leading gaming company',
                'founded_year' => 1982,
                'headquarters' => 'Redwood City, CA',
                'website_url' => 'https://www.ea.com'
            ],
            [
                'name' => 'Ubisoft',
                'slug' => 'ubisoft',
                'description' => 'French video game company',
                'founded_year' => 1986,
                'headquarters' => 'Montreuil, France',
                'website_url' => 'https://www.ubisoft.com'
            ],
            [
                'name' => 'Nintendo',
                'slug' => 'nintendo',
                'description' => 'Japanese gaming giant',
                'founded_year' => 1889,
                'headquarters' => 'Kyoto, Japan',
                'website_url' => 'https://www.nintendo.com'
            ]
        ]);

        // Developers
        DB::table('developers')->insert([
            [
                'name' => 'DICE',
                'slug' => 'dice',
                'description' => 'Battlefield series developer',
                'founded_year' => 1992,
                'headquarters' => 'Stockholm, Sweden',
                'website_url' => 'https://www.dice.se'
            ],
            [
                'name' => 'Ubisoft Montreal',
                'slug' => 'ubisoft-montreal',
                'description' => 'Leading Ubisoft studio',
                'founded_year' => 1997,
                'headquarters' => 'Montreal, Canada',
                'website_url' => 'https://montreal.ubisoft.com'
            ],
            [
                'name' => 'Nintendo EPD',
                'slug' => 'nintendo-epd',
                'description' => 'Nintendo\'s main development division',
                'founded_year' => 2015,
                'headquarters' => 'Kyoto, Japan',
                'website_url' => 'https://www.nintendo.com'
            ]
        ]);

        // Platforms
        DB::table('platforms')->insert([
            [
                'name' => 'PlayStation 5',
                'slug' => 'ps5',
                'manufacturer' => 'Sony',
                'release_date' => '2020-11-12'
            ],
            [
                'name' => 'Xbox Series X',
                'slug' => 'xbox-series-x',
                'manufacturer' => 'Microsoft',
                'release_date' => '2020-11-10'
            ],
            [
                'name' => 'Nintendo Switch',
                'slug' => 'nintendo-switch',
                'manufacturer' => 'Nintendo',
                'release_date' => '2017-03-03'
            ]
        ]);

        // Genres
        DB::table('genres')->insert([
            [
                'name' => 'Action',
                'slug' => 'action',
                'description' => 'Fast-paced gaming experiences'
            ],
            [
                'name' => 'RPG',
                'slug' => 'rpg',
                'description' => 'Role-playing games with character development'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Competitive sports simulations'
            ]
        ]);

        // Games
        DB::table('games')->insert([
            [
                'title' => 'Battlefield 2042',
                'slug' => 'battlefield-2042',
                'description' => 'Next-gen multiplayer shooter',
                'release_date' => '2021-11-19',
                'publisher_id' => 1,
                'rating' => 7.5,
                'price' => 59.99,
                'is_active' => true
            ],
            [
                'title' => 'Assassin\'s Creed Valhalla',
                'slug' => 'assassins-creed-valhalla',
                'description' => 'Viking-era action RPG',
                'release_date' => '2020-11-10',
                'publisher_id' => 2,
                'rating' => 8.0,
                'price' => 59.99,
                'is_active' => true
            ],
            [
                'title' => 'The Legend of Zelda: BOTW',
                'slug' => 'zelda-breath-of-the-wild',
                'description' => 'Open-world adventure',
                'release_date' => '2017-03-03',
                'publisher_id' => 3,
                'rating' => 9.5,
                'price' => 59.99,
                'is_active' => true
            ]
        ]);

        // Developer-Game Relationships
        DB::table('developer_game')->insert([
            ['developer_id' => 1, 'game_id' => 1, 'role' => 'Lead Developer'],
            ['developer_id' => 2, 'game_id' => 2, 'role' => 'Lead Developer'],
            ['developer_id' => 3, 'game_id' => 3, 'role' => 'Lead Developer']
        ]);

        // Game-Platform Relationships
        DB::table('game_platform')->insert([
            ['game_id' => 1, 'platform_id' => 1, 'release_date' => '2021-11-19'],
            ['game_id' => 1, 'platform_id' => 2, 'release_date' => '2021-11-19'],
            ['game_id' => 2, 'platform_id' => 1, 'release_date' => '2020-11-10'],
            ['game_id' => 2, 'platform_id' => 2, 'release_date' => '2020-11-10'],
            ['game_id' => 3, 'platform_id' => 3, 'release_date' => '2017-03-03']
        ]);

        // Game-Genre Relationships
        DB::table('game_genre')->insert([
            ['game_id' => 1, 'genre_id' => 1],  // Battlefield 2042 - Action
            ['game_id' => 2, 'genre_id' => 1],  // AC Valhalla - Action
            ['game_id' => 2, 'genre_id' => 2],  // AC Valhalla - RPG
            ['game_id' => 3, 'genre_id' => 1],  // Zelda BOTW - Action
            ['game_id' => 3, 'genre_id' => 2]   // Zelda BOTW - RPG
        ]);

        // Reviews
        DB::table('reviews')->insert([
            [
                'user_id' => 1,
                'game_id' => 1,
                'rating' => 7.5,
                'title' => 'Good but needs work',
                'content' => 'Impressive graphics but has some bugs',
                'is_recommended' => true
            ],
            [
                'user_id' => 2,
                'game_id' => 2,
                'rating' => 8.0,
                'title' => 'Amazing Viking saga',
                'content' => 'Great story and beautiful world',
                'is_recommended' => true
            ],
            [
                'user_id' => 3,
                'game_id' => 3,
                'rating' => 9.5,
                'title' => 'Masterpiece',
                'content' => 'One of the best games ever made',
                'is_recommended' => true
            ],
            [
                'user_id' => 1,
                'game_id' => 2,
                'rating' => 8.5,
                'title' => 'Great RPG experience',
                'content' => 'Loved the character progression',
                'is_recommended' => true
            ],
            [
                'user_id' => 2,
                'game_id' => 3,
                'rating' => 9.0,
                'title' => 'Revolutionary',
                'content' => 'Changed how I think about open-world games',
                'is_recommended' => true
            ]
        ]);
    }
}
