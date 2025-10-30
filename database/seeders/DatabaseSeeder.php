<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Developer;
use App\Models\Publisher;
use App\Models\Platform;
use App\Models\Genre;
use App\Models\Game;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $dev = Developer::firstOrCreate(['name'=>'SuperDev Studios']);
        $pub = Publisher::firstOrCreate(['name'=>'MegaPublisher']);
        $gen = Genre::firstOrCreate(['name'=>'Action'],['name'=>'RPG']);
        $plat = Platform::firstOrCreate(['name'=>'PC'],['name'=>'Playstation 5']);

        Game::firstOrCreate([
            'title'=>'Epic Quest',
            'slug'=>'epic-quest',
            'developer_id' => $dev->id,
            'publisher_id' => $pub->id,
            'genre_id' =>$gen->id,
            'platform_id' =>$plat->id,
            'release_date' => '2024-09-01',
            'price' => 39.99,
            'description' => 'A great adventure game'
        ]);

    }
}
