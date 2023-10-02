<?php

namespace Database\Seeders;
use App\Models\Group;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupNames = [
            "G's",
            '友達',
            '会社',
            'その他',
        ];

        foreach ($groupNames as $name) {
            Group::create([
                'name' => $name,
            ]);
        }
    }
}
