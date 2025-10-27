<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Developer;
use App\Models\Publisher;
use App\Models\Platform;
use App\Models\Genre;
use App\Models\Game;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // roles
        $adminRole = Role::firstOrCreate(['name'=>'admin'], ['label'=>'Administrador']);
        $userRole = Role::firstOrCreate(['name'=>'user'], ['label'=>'Usuario']);

        // admin user
        $admin = User::firstOrCreate(['email'=>'admin@example.com'], [
            'name'=>'Admin',
            'password'=>Hash::make('secret123')
        ]);
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // sample data
        $dev = Developer::firstOrCreate(['name'=>'SuperDev Studios']);
        $pub = Publisher::firstOrCreate(['name'=>'MegaPublisher']);

        $genre1 = Genre::firstOrCreate(['name'=>'Action']);
        $genre2 = Genre::firstOrCreate(['name'=>'RPG']);

        $plat1 = Platform::firstOrCreate(['name'=>'PC']);
        $plat2 = Platform::firstOrCreate(['name'=>'PlayStation 5']);

        $game = Game::firstOrCreate(['slug'=>'epic-quest'], [
            'title'=>'Epic Quest',
            'developer_id' => $dev->id,
            'publisher_id' => $pub->id,
            'release_date' => '2024-09-01',
            'price' => 39.99,
            'description' => 'A great adventure game',
            'average_rating' => 0
        ]);

        $game->genres()->sync([$genre1->id, $genre2->id]);
        $game->platforms()->sync([$plat1->id, $plat2->id]);
    }
}
