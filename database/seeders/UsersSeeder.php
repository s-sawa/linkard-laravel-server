<?php

namespace Database\Seeders;

use App\Models\FreePost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Other;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // ユーザー1を作成
        $user1 = User::create([
            'name' => 'inuinu',
            'email' => 'inu@gmail.com',
            'password' => Hash::make('12345678'),
            'birthday' => '1992-12-21',
            'comment' => 'そつせいたいへん',
            'profile_image_path' => 'user_images/user1/profile_image/1694485473_IMG_4798.JPG',
        ]);

        // ユーザー1の趣味を作成
        $hobbies1 = ['読書', '映画鑑賞'];
        foreach ($hobbies1 as $hobby) {
            Hobby::create([
                'user_id' => $user1->id,
                'hobby' => $hobby,
            ]);
        }

        // ユーザー1のその他のデータを作成
        $otherData1 = [
            ['name' => 'Mr.children', 'newOtherName' => '好きなアーティスト'],
            ['name' => '羊文学', 'newOtherName' => '好きなアーティスト'],
        ];
        foreach ($otherData1 as $data) {
            Other::create([
                'user_id' => $user1->id,
                'name' => $data['name'],
                'newOtherName' => $data['newOtherName'],
            ]);
        }

        // ユーザー1のフリー投稿を作成
        $freePostsData1 = [
            [
                'title' => 'ユーザー1のフリー投稿1',
                'description' => 'これはユーザー1のフリー投稿1の説明です。',
                'image_path' => 'user_images/user1/free_image/1694436261_IMG_4798.JPG',
            ],
        ];

        foreach ($freePostsData1 as $data) {
            FreePost::create([
                'user_id' => $user1->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'image_path' => $data['image_path'],
            ]);
        }

        // ユーザー2を作成
        $user2 = User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('12345678'),
            'birthday' => '1990-01-15',
            'comment' => 'ユーザー2のコメント',
            'profile_image_path' => 'user_images/user2/profile_image/1234567890_user2.jpg',
        ]);

        // ユーザー2の趣味を作成
        $hobbies2 = ['旅行', 'スポーツ観戦'];
        foreach ($hobbies2 as $hobby) {
            Hobby::create([
                'user_id' => $user2->id,
                'hobby' => $hobby,
            ]);
        }

        // ユーザー2のその他のデータを作成
        $otherData2 = [
            ['name' => '映画鑑賞', 'newOtherName' => '趣味'],
            ['name' => '料理', 'newOtherName' => '趣味'],
        ];
        foreach ($otherData2 as $data) {
            Other::create([
                'user_id' => $user2->id,
                'name' => $data['name'],
                'newOtherName' => $data['newOtherName'],
            ]);
        }

        // ユーザー2のフリー投稿を作成
        $freePostsData2 = [
            [
                'title' => 'ユーザー2のフリー投稿1',
                'description' => 'これはユーザー2のフリー投稿1の説明です。',
                'image_path' => 'user_images/user2/free_image/1234567890_user2.jpg',
            ],
        ];

        foreach ($freePostsData2 as $data) {
            FreePost::create([
                'user_id' => $user2->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'image_path' => $data['image_path'],
            ]);
        }

         $user3 = User::create([
            'name' => 'inuinuinuinu',
            'email' => 'shogo@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        // ... 他のユーザーを追加する場合も同様に繰り返してください
    }
}
