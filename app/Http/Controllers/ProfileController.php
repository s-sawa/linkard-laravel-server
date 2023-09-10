<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    $user->birthday = $request->birthday;
    $user->comment = $request->comment;

    // 画像アップロードの処理
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        // ファイル名を一意のものにする（例：timestamp_originalname.jpg）
        $filename = time() . '_' . $image->getClientOriginalName();
        // 画像をpublic/profile_imagesディレクトリに保存
        $image->move(public_path('profile_images'), $filename);

        // 保存した画像のパスをユーザーテーブルに保存
        $user->profile_image_path = 'profile_images/' . $filename;
    }
    // ... その他のカラムも必要に応じて追加
    $user->save();

    // 作成されたユーザーのIDを使用して、趣味をHobbiesテーブルに保存します
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
        // $otherData = $user->others;
        // $freePosts = $user->freePosts;

        return response()->json([
            'user' => $user,
            'hobbies' => $hobbies,
            // 'otherData' => $otherData,
            // 'freePosts' => $freePosts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}