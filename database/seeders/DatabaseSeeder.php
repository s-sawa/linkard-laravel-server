<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Hobbies と HobbyLikes のシーダーを呼び出し
        $this->call([
            ThemeColorsTableSeeder::class,
            HobbiesTableSeeder::class,
            HobbyLikesTableSeeder::class,
            UsersSeeder::class,
            GroupsSeeder::class,
        ]);
    }
}
