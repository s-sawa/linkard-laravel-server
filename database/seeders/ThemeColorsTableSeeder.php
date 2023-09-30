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
            'color1' => '#FF5733',
            'color2' => '#33FF57',
            'color3' => '#3357FF',
        ]);

        ThemeColor::create([
            'color1' => '#FF33A1',
            'color2' => '#A1FF33',
            'color3' => '#33A1FF',
        ]);

        ThemeColor::create([
            'color1' => '#FFD733',
            'color2' => '#33FFD7',
            'color3' => '#D733FF',
        ]);

    }
}
