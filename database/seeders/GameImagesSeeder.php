<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameImagesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Adding cover images to games...');

        // Real game cover images from popular games
        $gameImages = [
            'The Witcher 3: Wild Hunt' => 'https://image.api.playstation.com/vulcan/img/cfn/11307x4B5WLoVoIUtdewG4uJ_YuDRTwBxQy0qP8ylgazLLc2oyKkyKwEhGNdGl0_HWWviJYzKwhJXFb8FLa-z3r3NXBRYhcV.png',
            'Cyberpunk 2077' => 'https://image.api.playstation.com/vulcan/ap/rnd/202111/3013/cKZ4tKNNjNVRDO2dpaN9jKAH.png',
            'Red Dead Redemption 2' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/Y9NM6QRV5aUOWOZJAjt3hT7N.png',
            'God of War' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2217/LsaRVLF5bBpaMlbn5sLnhBEN.png',
            'The Last of Us Part II' => 'https://image.api.playstation.com/vulcan/ap/rnd/202010/2618/wrYaKMyRXzSJH0q1lg5U2YvS.png',
            'Horizon Zero Dawn' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/s1k0JqJyq4EShb7YKLe7KzOO.png',
            'Spider-Man: Miles Morales' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/1020/BOaTAaNdKgwWuAkMJKlZQ2x3.png',
            'Assassin\'s Creed Valhalla' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/0619/0qTGBXUNB3g8LzA4eK3Dc7f1.png',
            'Call of Duty: Modern Warfare II' => 'https://image.api.playstation.com/vulcan/ap/rnd/202210/1114/qEO07R1kcvQH2hOAJRvzXPJp.png',
            'Elden Ring' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/2000/phvVT0qZfcRms5qDAk0SI3CM.png',
            'Sons of the Forest' => 'https://image.api.playstation.com/vulcan/ap/rnd/202211/2812/HZGHoHMPKOiMGhU6hPH3ZRyX.png',
            'Baldur\'s Gate 3' => 'https://image.api.playstation.com/vulcan/ap/rnd/202306/0104/775c15d6c7b4d6c46e6bdf8e4ae1bc1d67beb39a9db2ea48.png',
            'Hades' => 'https://image.api.playstation.com/vulcan/ap/rnd/202007/3100/GbqQdJqLbepIeKJB47MlqN6J.png',
            'Among Us' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/1717/BWwOiMEZ3YLZ5kWF49k6n2Kl.png',
            'Fall Guys' => 'https://image.api.playstation.com/vulcan/ap/rnd/202008/0420/T45iRUyUJ0sK1hOlh7lFFzAV.png',
            'FIFA 23' => 'https://image.api.playstation.com/vulcan/ap/rnd/202207/1210/UQhMqEU7rJlcn4nDNYObN2AF.png',
            'Gran Turismo 7' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/2021/cVVlClsMudkRIC73n47UjzC1.png',
            'Minecraft' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2614/NjF9NWadNGaXkJMNMkh9RfrT.png',
            'Fortnite' => 'https://image.api.playstation.com/vulcan/ap/rnd/202207/1314/zovObq8bENtoAHYrLzWo2xGz.png',
            'Grand Theft Auto V' => 'https://image.api.playstation.com/vulcan/ap/rnd/202010/2618/Y9NM6QRV5aUOWOZJAjt3hT7N.png',
        ];

        // Fallback images for games not in the above list
        $fallbackImages = [
            'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1556438064-2d7646166914?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=400&h=600&fit=crop',
            'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=400&h=600&fit=crop',
        ];

        $games = Game::all();
        $fallbackIndex = 0;

        foreach ($games as $game) {
            $imageUrl = null;
            
            // Try to find a matching image for known games
            foreach ($gameImages as $gameTitle => $url) {
                if (stripos($game->title, $gameTitle) !== false || 
                    stripos($gameTitle, $game->title) !== false) {
                    $imageUrl = $url;
                    break;
                }
            }
            
            // If no specific image found, use a fallback
            if (!$imageUrl) {
                $imageUrl = $fallbackImages[$fallbackIndex % count($fallbackImages)];
                $fallbackIndex++;
            }
            
            $game->update([
                'image_url' => $imageUrl
            ]);
            
            $this->command->info("Updated image for: {$game->title}");
        }

        $this->command->info('Game images seeding completed!');
    }
}
