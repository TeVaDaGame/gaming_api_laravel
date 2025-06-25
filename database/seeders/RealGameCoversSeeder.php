<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class RealGameCoversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of real game covers from reliable sources (Updated with high-quality images)
        $gameCovers = [
            // Popular AAA Games
            'the-witcher-3-wild-hunt' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202006/2605/a7gCXKsVftOF8e4aSJrnvQx9.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/292030/header.jpg'
            ],
            'cyberpunk-2077' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202111/3013/cKZ4tKNNmMhqr9u1m4ZCJ42M.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg'
            ],
            'red-dead-redemption-2' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/Y9jip6pTpZqadNAFvwMFBQeN.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1174180/header.jpg'
            ],
            'grand-theft-auto-v' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/wrpuzC7VogVKKShhmzIjvQnZ.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/271590/header.jpg'
            ],
            'minecraft' => [
                'image_url' => 'https://www.minecraft.net/content/dam/games/minecraft/key-art/Vanilla-PMP_Collection-Carousel-0_Buzzy-Bees_1280x768.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1172470/header.jpg'
            ],
            'assassins-creed-valhalla' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/1013/PRfYtTZQsuj3ALrBXGL8MjAH.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/2208920/header.jpg'
            ],
            'call-of-duty-modern-warfare-ii' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202105/0321/850MBhRZ6TM1FmkKqhOSQ5vu.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1938090/header.jpg'
            ],
            'fifa-23' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202307/1201/81055b6b8d24e26c2e848e0b8c6e69e97fe9eb82.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1811260/header.jpg'
            ],
            'fortnite' => [
                'image_url' => 'https://cdn2.unrealengine.com/fortnite-chapter-4-season-4-last-resort-key-art-1920x1080-2b0ae5c7d9b7.jpg',
                'cover_image' => 'https://cdn2.unrealengine.com/17br-logo-1920x1080-0c1eca0e3b8e.jpg'
            ],
            'apex-legends' => [
                'image_url' => 'https://media.contentapi.ea.com/content/dam/apex-legends/common/apex-section-bg.jpg.adapt.1920w.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1172470/header.jpg'
            ],
            'battlefield-2042' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/0711/KHBq6RSE5EwKkwqUkGlhmJfn.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1517290/header.jpg'
            ],
            'forza-horizon-5' => [
                'image_url' => 'https://compass-ssl.xbox.com/assets/43/83/43837119-5c5b-4a0a-b1c2-4c4b1b5b3b5b.jpg?n=Forza-Horizon-5_GLP-Page-Hero-1084_1920x1080.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1551360/header.jpg'
            ],
            'the-elder-scrolls-v-skyrim' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/489830/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/489830/capsule_616x353.jpg'
            ],
            'elden-ring' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1245620/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1245620/capsule_616x353.jpg'
            ],
            'spider-man-miles-morales' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/1020/T45iRN1bhiWcJUzST6sfcQtT.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1817190/header.jpg'
            ],
            'god-of-war-2018' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2217/LsaRVLF8OjQ3FO0M8slaQLEy.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1593500/header.jpg'
            ],
            'sons-of-the-forest' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1326470/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1326470/capsule_616x353.jpg'
            ],
            'dark-souls-iii' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/374320/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/374320/capsule_616x353.jpg'
            ],
            'rocket-league' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/252950/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/252950/capsule_616x353.jpg'
            ],
            'terraria' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/105600/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/105600/capsule_616x353.jpg'
            ],
            'baldurs-gate-3' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1086940/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1086940/capsule_616x353.jpg'
            ],
            'no-mans-sky' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/275850/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/275850/capsule_616x353.jpg'
            ],
            'stardew-valley' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/413150/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/413150/capsule_616x353.jpg'
            ],
            
            // Nintendo Games
            'the-legend-of-zelda-breath-of-the-wild' => [
                'image_url' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000000025/7137262b5a64d921e193653f8aa0b722925abc5680380ca0e18a5cfd91697f58',
                'cover_image' => 'https://assets.nintendo.com/image/upload/ar_16:9,c_lpad,w_1240/b_white/f_auto/q_auto/ncom/software/switch/70010000000025/c42553b4de592c15b60badc95776dec937b1348a'
            ],
            
            // PC Gaming
            'counter-strike-2' => [
                'image_url' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/730/header.jpg',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/730/capsule_616x353.jpg'
            ],
            'league-of-legends' => [
                'image_url' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ahri_0.jpg',
                'cover_image' => 'https://riot-web-static.s3-us-west-1.amazonaws.com/lolesports/assets/images/lol_keyart.png'
            ],
            'valorant' => [
                'image_url' => 'https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt5183e01fb66e88a6/5f0b1b7de6b5e4c5c8c7e1a2/VALORANT_keyart_BlackText_png.png',
                'cover_image' => 'https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt5183e01fb66e88a6/5f0b1b7de6b5e4c5c8c7e1a2/VALORANT_keyart_BlackText_png.png'
            ],
            'horizon-zero-dawn' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/p3pYq0QxntZQREXRVdAzmn1w.png',
                'cover_image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1151640/header.jpg'
            ],
            'the-last-of-us-part-ii' => [
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202306/1219/60ebb6b1f5a689ae9c1ba9af4c61c63a2db1bc3f.png',
                'cover_image' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/Y9jip6pTpZqadNAFvwMFBQeN.png'
            ]
        ];

        $this->command->info('Adding real game covers...');

        foreach ($gameCovers as $slug => $covers) {
            $game = Game::where('slug', $slug)->first();
            
            if ($game) {
                $game->update([
                    'image_url' => $covers['image_url'],
                    'cover_image' => $covers['cover_image']
                ]);
                
                $this->command->info("✅ Updated covers for: {$game->title}");
            } else {
                $this->command->warn("⚠️  Game not found: {$slug}");
            }
        }

        // For any games without covers, assign high-quality placeholder covers
        $gamesWithoutCovers = Game::where(function($query) {
            $query->whereNull('image_url')
                  ->orWhere('image_url', '');
        })->get();

        if ($gamesWithoutCovers->count() > 0) {
            $this->command->info("Adding high-quality placeholders for remaining games...");
            
            $placeholderCovers = [
                'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&h=600&fit=crop',
                'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=400&h=600&fit=crop'
            ];

            foreach ($gamesWithoutCovers as $index => $game) {
                $placeholderIndex = $index % count($placeholderCovers);
                $game->update([
                    'image_url' => $placeholderCovers[$placeholderIndex],
                    'cover_image' => $placeholderCovers[$placeholderIndex]
                ]);
                
                $this->command->info("✅ Added placeholder for: {$game->title}");
            }
        }

        $this->command->info('🎮 Real game covers have been added successfully!');
        $this->command->info('📊 Total games updated: ' . Game::whereNotNull('image_url')->count());
    }
}
