<?php

namespace Database\Seeders;

use App\Models\FreePost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Other;
use App\Models\Other2;
use App\Models\Other3;

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

        $otherData2 = [
            ['name' => '呪術廻戦', 'newOtherName2' => '好きな漫画'],
            ['name' => 'ヨルムンガンド', 'newOtherName2' => '好きな漫画'],
            ['name' => '鋼の錬金術師', 'newOtherName2' => '好きな漫画'],
        ];
        foreach ($otherData2 as $data) {
            Other2::create([
                'user_id' => $user1->id,
                'name' => $data['name'],
                'newOtherName2' => $data['newOtherName2'],
            ]);
        }

        $otherData3 = [
            ['name' => 'エンジニア転職', 'newOtherName3' => '今後の目標'],
            ['name' => '技術力高める', 'newOtherName3' => '今後の目標'],
        ];
        foreach ($otherData3 as $data) {
            Other3::create([
                'user_id' => $user1->id,
                'name' => $data['name'],
                'newOtherName3' => $data['newOtherName3'],
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

        $user2 = User::create([
            'name' => 'nekoneko',
            'email' => 'neko@gmail.com',
            'password' => Hash::make('12345678'),
            'birthday' => '1995-11-30',
            'comment' => '猫が好きです',
            'profile_image_path' => 'user_images/user2/profile_image/1694485473_IMG_4799.JPG',
        ]);

        // ユーザー2の趣味を作成
        $hobbies2 = ['釣り', '旅行'];
        foreach ($hobbies2 as $hobby) {
            Hobby::create([
                'user_id' => $user2->id,
                'hobby' => $hobby,
            ]);
        }

        // ユーザー2のその他のデータを作成
        $otherData1 = [
            ['name' => 'BUMP OF CHICKEN', 'newOtherName' => '好きなアーティスト'],
            ['name' => 'ELLEGARDEN', 'newOtherName' => '好きなアーティスト'],
        ];
        foreach ($otherData1 as $data) {
            Other::create([
                'user_id' => $user2->id,
                'name' => $data['name'],
                'newOtherName' => $data['newOtherName'],
            ]);
        }

        $otherData2 = [
            ['name' => 'ワンピース', 'newOtherName2' => '好きな漫画'],
            ['name' => 'ナルト', 'newOtherName2' => '好きな漫画'],
            ['name' => 'ドラゴンボール', 'newOtherName2' => '好きな漫画'],
        ];
        foreach ($otherData2 as $data) {
            Other2::create([
                'user_id' => $user2->id,
                'name' => $data['name'],
                'newOtherName2' => $data['newOtherName2'],
            ]);
        }

        $otherData3 = [
            ['name' => 'Web開発のスキルアップ', 'newOtherName3' => '今後の目標'],
            ['name' => '英語の向上', 'newOtherName3' => '今後の目標'],
        ];
        foreach ($otherData3 as $data) {
            Other3::create([
                'user_id' => $user2->id,
                'name' => $data['name'],
                'newOtherName3' => $data['newOtherName3'],
            ]);
        }

        // ユーザー2のフリー投稿を作成
        $freePostsData2 = [
            [
                'title' => 'ユーザー2のフリー投稿1',
                'description' => 'これはユーザー2のフリー投稿1の説明です。',
                'image_path' => 'user_images/user2/free_image/1694436261_IMG_4799.JPG',
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


                // ユーザー3を作成
        $user3 = User::create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('12345678'),
            'birthday' => '1993-10-15',
            'comment' => 'こんにちは、ユーザー3です。',
            'profile_image_path' => 'user_images/user3/profile_image/1234567890_IMG_1234.JPG',
        ]);

        // ユーザー3の趣味を作成
        $hobbies3 = ['旅行', '写真撮影'];
        foreach ($hobbies3 as $hobby) {
            Hobby::create([
                'user_id' => $user3->id,
                'hobby' => $hobby,
            ]);
        }

        // ユーザー3のその他のデータを作成
        $otherData3_1 = [
            ['name' => 'BUMP OF CHICKEN', 'newOtherName' => '好きなアーティスト'],
            ['name' => 'ONE OK ROCK', 'newOtherName' => '好きなアーティスト'],
        ];
        foreach ($otherData3_1 as $data) {
            Other::create([
                'user_id' => $user3->id,
                'name' => $data['name'],
                'newOtherName' => $data['newOtherName'],
            ]);
        }

        $otherData3_2 = [
            ['name' => 'ONE PIECE', 'newOtherName2' => '好きな漫画'],
            ['name' => 'NARUTO', 'newOtherName2' => '好きな漫画'],
        ];
        foreach ($otherData3_2 as $data) {
            Other2::create([
                'user_id' => $user3->id,
                'name' => $data['name'],
                'newOtherName2' => $data['newOtherName2'],
            ]);
        }

        $otherData3_3 = [
            ['name' => '新しいスキル習得', 'newOtherName3' => '今後の目標'],
            ['name' => '健康的な生活', 'newOtherName3' => '今後の目標'],
        ];
        foreach ($otherData3_3 as $data) {
            Other3::create([
                'user_id' => $user3->id,
                'name' => $data['name'],
                'newOtherName3' => $data['newOtherName3'],
            ]);
        }

        // ユーザー3のフリー投稿を作成
        $freePostsData3 = [
            [
                'title' => 'ユーザー3のフリー投稿1',
                'description' => 'これはユーザー3のフリー投稿1の説明です。',
                'image_path' => 'user_images/user3/free_image/1234567890_IMG_1234.JPG',
            ],
        ];

        foreach ($freePostsData3 as $data) {
            FreePost::create([
                'user_id' => $user3->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'image_path' => $data['image_path'],
            ]);
        }
        // ... 他のユーザーを追加する場合も同様に繰り返してください
    }
}
