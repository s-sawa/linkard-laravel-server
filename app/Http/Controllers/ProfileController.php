<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\FreePost;
use App\Models\Hobby;
use App\Models\Other;
use App\Models\Other2;
use App\Models\Other3;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
   {
    // 現在のログインユーザーを取得
    $user = auth()->user();

    // ユーザーの情報を更新
    $user->name = $request->name;
    $user->birthday = $request->birthday;
    $user->comment = $request->comment;
    $user->theme_color_id = $request->themeId;


    // 画像アップロードの処理
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        // ユニークなファイル名にする
        $userDirectory = 'user_images/user' . auth()->user()->id .'/profile_image';

        $filename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path($userDirectory), $filename);

        // 保存した画像のパスをユーザーテーブルに保存
        // profile_image_path はカラム名
        $user->profile_image_path = $userDirectory . '/' . $filename;
    }
    $user->save();

    // 作成されたユーザーのIDを使用して、趣味をHobbiesテーブルに保存
    $hobbies = $request->input('hobbies');
    if (is_array($hobbies)) {
        foreach ($hobbies as $hobby) {
            Hobby::create([
                'user_id' => $user->id,
                'hobby' => $hobby['hobby']
            ]);
        }
    } else {
        Hobby::create([
            'user_id' => $user->id,
            'hobby' => $hobbies
        ]);
    }

    // その他のデータを保存
    $others = $request->input('others');
    if (is_array($others)) {
        foreach ($others as $other) {
            $newOtherName = $other['newOtherName'] ?? null; // データが存在しない場合に null を設定
            // その他のモデルに合わせて調整
            Other::create([
                'user_id' => $user->id,
                'name' => $other['name'],
                'newOtherName' => $request->newOtherName,
            ]);
        }
    } else {
        Other::create([
            'user_id' => $user->id,
            'name' => $others,
            'newsOtherName' => $others,
        ]);
    }

    // その他のデータを保存
    $others2 = $request->input('others2');
    if (is_array($others2)) {
        foreach ($others2 as $other2) {
            Other2::create([
                'user_id' => $user->id,
                'name' => $other2['name'],
                'newOtherName2' => $request->newOtherName2, // こちらを変更しました
            ]);
        }
    } else {
        Other2::create([
            'user_id' => $user->id,
            'name' => $others2,
            'newOtherName2' => $request->newOtherName2, // こちらも変更しました
        ]);
    }


   // その他のデータを保存
    $others3 = $request->input('others3');
    if (is_array($others3)) {
        foreach ($others3 as $other3) {
            Other3::create([
                'user_id' => $user->id,
                'name' => $other3['name'],
                'newOtherName3' => $request->newOtherName3, // こちらを変更しました
            ]);
        }
    } else {
        Other3::create([
            'user_id' => $user->id,
            'name' => $others3,
            'newOtherName3' => $request->newOtherName3, // こちらも変更しました
        ]);
    }

    
    // if ($request->hasFile('free_image')) {
    //     $image = $request->file('free_image');
    //     $filename = time() . '_' . $image->getClientOriginalName();
    //     // 画像をpublic/profile_imagesディレクトリに保存
    //     $userDirectory = 'user_images/user' . auth()->user()->id .'/free_image';
    //     $image->move(public_path($userDirectory), $filename);
    // }

    // // フリー投稿
    // FreePost::create([
    //     'user_id' => $user->id,
    //     'title' => $request->title,
    //     'description' => $request->description,
    //     'image_path' => $userDirectory . '/' . $filename,
    // ]);

    $imagePath = null; // 初期値としてnullをセット

if ($request->hasFile('free_image')) {
    $image = $request->file('free_image');
    $filename = time() . '_' . $image->getClientOriginalName();
    
    $userDirectory = 'user_images/user' . auth()->user()->id .'/free_image';
    $image->move(public_path($userDirectory), $filename);
    
    $imagePath = $userDirectory . '/' . $filename; // 画像がアップロードされた場合のみ、$imagePathをセット
}

// フリー投稿
FreePost::create([
    'user_id' => $user->id,
    'title' => $request->title,
    'description' => $request->description,
    'image_path' => $imagePath, // 画像がアップロードされていない場合はnull
]);


    // SNS
    // $social_links = $request->input('social_links');
    $social_links = $request->input('social_links', []); // デフォルト値として空の配列を設定


    foreach ($social_links as $link) {
        $platform = $link['platform'] ?? null; // null coalescing operatorを使用して値が存在しない場合にnullを設定
        $url = $link['url'] ?? null;
        SocialLink::create([
            'user_id' => $user->id,
            'platform' => $platform,
            'url' => $url,
            // 必要に応じて他のカラムも設定
        ]);
    }



    return response()->json(['message' => 'Profile and hobbies updated successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    { 
        $user = auth()->user();

        // 趣味のデータを取得
        $hobbies = $user->hobbies; // Userモデルで定義したリレーションを介して取得
        $otherData = $user->others;
        $otherData2 = $user->others2;
        $otherData3 = $user->others3;
        $freePosts = $user->freePosts;
        $socialLinks = $user->socialLinks;
        $themeColors = $user->themeColors;

        return response()->json([
            'user' => $user,
            'hobbies' => $hobbies,
            'otherData' => $otherData,
            'otherData2' => $otherData2,
            'otherData3' => $otherData3,
            'freePosts' => $freePosts,
            'socialLinks' => $socialLinks,
            'themeColors' => $themeColors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
            Log::info('Request data:', $request->all());


        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザーの情報を更新
        $user->name = $request->name;
        // $user->birthday = $request->birthday;
        $user->comment = $request->comment;
        $user->theme_color_id = $request->themeId;


        // 画像アップロードの処理 (profile_image)
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $userDirectory = 'user_images/user' . $user->id . '/profile_image';
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path($userDirectory), $filename);
            $user->profile_image_path = $userDirectory . '/' . $filename;
        }

        // 画像アップロードの処理 (free_image)
        if ($request->hasFile('free_image')) {
            $image = $request->file('free_image');
            $userDirectory = 'user_images/user' . $user->id . '/free_image';
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path($userDirectory), $filename);
            
            // ここでは、フリー投稿を更新するので、すでに存在するレコードを探して更新する必要があります。
            $freePost = FreePost::where('user_id', $user->id)->first();
            if ($freePost) {
                $freePost->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image_path' => $userDirectory . '/' . $filename,
                ]);
            }
        }

        $user->save();

        // // 趣味を更新
        // $hobbies = $request->input('hobbies');
        // // Hobby::where('user_id', $user->id)->delete(); // まず、既存の趣味を削除
        // if (is_array($hobbies)) {
        //     foreach ($hobbies as $hobby) {
        //         Hobby::create([
        //             'user_id' => $user->id,
        //             'hobby' => $hobby['hobby']
        //         ]);
        //     }
        // } else {
        //     Hobby::create([
        //         'user_id' => $user->id,
        //         'hobby' => $hobbies
        //     ]);
        // }

        // リクエストから送信された趣味
        $newHobbies = $request->input('hobbies');

        // ユーザーの既存の趣味
        $currentHobbies = Hobby::where('user_id', $user->id)->get();

        foreach ($currentHobbies as $currentHobby) {
            $found = false;
            foreach ($newHobbies as $index => $newHobby) {
                if ($currentHobby->hobby === $newHobby['hobby']) {
                    $found = true;
                    unset($newHobbies[$index]); // 既存の趣味を見つけたら、新趣味のリストから削除
                    break;
                }
            }

            if (!$found) {
                $currentHobby->delete(); // リクエストに存在しない既存の趣味は削除
            }
        }

        // 残った新趣味を作成
        foreach ($newHobbies as $newHobby) {
            Hobby::create([
                'user_id' => $user->id,
                'hobby' => $newHobby['hobby']
            ]);
        }


        
        // その他のデータを更新
        // $others = $request->input('others');
        // Other::where('user_id', $user->id)->delete(); // まず、既存のその他のデータを削除
        // if (is_array($others)) {
        //     foreach ($others as $other) {
        //         Other::create([
        //             'user_id' => $user->id,
        //             'name' => $other['name'],
        //             'newOtherName' => $request->newOtherName, // ここで$requestからnewOtherNameを取得

        //             // 'newOtherName' => $other['newOtherName'] ?? null,
        //         ]);
        //     }
        // } else {
        //     Other::create([
        //         'user_id' => $user->id,
        //         'name' => $others,
        //         'newOtherName' => $others
        //     ]);
        // }
        $newOthers = $request->input('others');
        $currentOthers = Other::where('user_id', $user->id)->get();

        foreach ($currentOthers as $currentOther) {
            $found = false;
            foreach ($newOthers as $index => $newOther) {
                if ($currentOther->name === $newOther['name']) {
                    $found = true;
                    // 必要に応じてここで $currentOther を更新
                    $currentOther->update([
                        'newOtherName' => $request->newOtherName,
                    ]);
                    unset($newOthers[$index]);
                    break;
                }
            }

            if (!$found) {
                $currentOther->delete();
            }
        }

        foreach ($newOthers as $newOther) {
            Other::create([
                'user_id' => $user->id,
                'name' => $newOther['name'],
                'newOtherName' => $request->newOtherName,
            ]);
        }


                


        // other2のデータを更新
        // $others2 = $request->input('others2');
        // Other2::where('user_id', $user->id)->delete(); // 既存のその他のデータを削除
        // if (is_array($others2)) {
        //     foreach ($others2 as $other) {
        //         Other2::create([
        //             'user_id' => $user->id,
        //             'name' => $other['name'],
        //             'newOtherName2' => $request->newOtherName2,
        //         ]);
        //     }
        // } else {
        //     Other2::create([
        //         'user_id' => $user->id,
        //         'name' => $others2,
        //         'newOtherName2' => $others2
        //     ]);
        // }

        $newOthers2 = $request->input('others2');
$currentOthers2 = Other2::where('user_id', $user->id)->get();

foreach ($currentOthers2 as $currentOther2) {
    $found = false;
    foreach ($newOthers2 as $index => $newOther2) {
        if ($currentOther2->name === $newOther2['name']) {
            $found = true;
            $currentOther2->update([
                'newOtherName2' => $request->newOtherName2,
            ]);
            unset($newOthers2[$index]);
            break;
        }
    }

    if (!$found) {
        $currentOther2->delete();
    }
}

foreach ($newOthers2 as $newOther2) {
    Other2::create([
        'user_id' => $user->id,
        'name' => $newOther2['name'],
        'newOtherName2' => $request->newOtherName2,
    ]);
}


        // other3のデータを更新
        // $others3 = $request->input('others3');
        // Other3::where('user_id', $user->id)->delete(); // 既存のその他のデータを削除
        // if (is_array($others3)) {
        //     foreach ($others3 as $other) {
        //         Other3::create([
        //             'user_id' => $user->id,
        //             'name' => $other['name'],
        //             'newOtherName3' => $request->newOtherName3,
        //         ]);
        //     }
        // } else {
        //     Other3::create([
        //         'user_id' => $user->id,
        //         'name' => $others3,
        //         'newOtherName3' => $others3
        //     ]);
        // }

        $newOthers3 = $request->input('others3');
        $currentOthers3 = Other3::where('user_id', $user->id)->get();

        foreach ($currentOthers3 as $currentOther3) {
            $found = false;
            foreach ($newOthers3 as $index => $newOther3) {
                if ($currentOther3->name === $newOther3['name']) {
                    $found = true;
                    $currentOther3->update([
                        'newOtherName3' => $request->newOtherName3,
                    ]);
                    unset($newOthers3[$index]);
                    break;
                }
            }

            if (!$found) {
                $currentOther3->delete();
            }
        }

        foreach ($newOthers3 as $newOther3) {
            Other3::create([
                'user_id' => $user->id,
                'name' => $newOther3['name'],
                'newOtherName3' => $request->newOtherName3,
            ]);
        }


        // SNS
        $social_links = $request->input('social_links');

        if(is_array($social_links) || is_object($social_links)){

            foreach ($social_links as $link) {
                $platform = $link['platform'] ?? null;
                $url = $link['url'] ?? null;

                SocialLink::updateOrInsert(
                    ['user_id' => $user->id, 'platform' => $platform], // 検索条件
                    ['url' => $url] // 更新するデータまたは挿入するデータ
                );
            }
        }
        return response()->json(['message' => 'Profile updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // ログイン中のユーザーを取得
        $user = auth()->user();

        // 各リレーションデータを削除
        $user->freePosts()->delete();
        $user->hobbies()->delete();
        $user->others()->delete();
        $user->others2()->delete();
        $user->others3()->delete();
        $user->others3()->delete();
        $user->socialLinks()->delete();
        Follow::where('from_user_id', $user->id)->orWhere('to_user_id', $user->id)->delete();

        
        // ユーザー自体を削除
        $user->delete();

        return response()->json(['message' => 'User and related data deleted successfully']);
     }

}
