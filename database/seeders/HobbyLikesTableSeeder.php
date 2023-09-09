<?php

namespace Database\Seeders;

use App\Models\Hobby;
use App\Models\HobbyLike;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbyLikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // すべての趣味を取得
        $hobbies = Hobby::all();

        // すべてのユーザーを取得
        $users = User::all();

        // すべての趣味に対して、ランダムなユーザーがそれを「like」するようにデータを追加
        foreach ($hobbies as $hobby) {
            // ランダムなユーザー数(例: 1〜5人)がこの趣味を「like」することにします。
            for ($i = 0; $i < rand(1, 5); $i++) {
                // ランダムなユーザーを取得
                $user = $users->random();

                // そのユーザーが既にこの趣味を「like」しているか確認
                $alreadyLiked = HobbyLike::where('hobby_id', $hobby->id)
                                           ->where('user_id', $user->id)
                                           ->count();

                // 既に「like」していない場合、データを追加
                if (!$alreadyLiked) {
                    HobbyLike::create([
                        'hobby_id' => $hobby->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }
    }
}
