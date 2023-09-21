<?php

namespace Database\Seeders;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbyNames = ['読書', '映画鑑賞'];

        User::all()->each(function ($user) use ($hobbyNames) {
            foreach ($hobbyNames as $hobbyName) {
                $hobby = new Hobby;
                $hobby->hobby = $hobbyName;
                $user->hobbies()->save($hobby);
            }
        });
    }
}
