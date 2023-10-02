<?php

namespace Database\Seeders;

use App\Models\ThemeColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThemeColor::create([
            // ちいかわっぽい
            'color1' => '#feeedc',
            'color2' => '#bde1da',
            'color3' => '#f5b5a7',
        ]);

        ThemeColor::create([
            'color1' => '#dbd2e8',
            'color2' => '#dfe8f0',
            'color3' => '#fff6a4',
        ]);
        
        ThemeColor::create([
            'color1' => '#ded3d6',
            'color2' => '#c0e4f2',
            'color3' => '#fffcd7',
        ]);

        ThemeColor::create([
            'color1' => '#555168',
            'color2' => '#f5d7d6',
            'color3' => '#e06b7b',
        ]);

        ThemeColor::create([
            'color1' => '#32405f',
            'color2' => '#bdc6ca',
            'color3' => '#889291',
        ]);

    }
}
