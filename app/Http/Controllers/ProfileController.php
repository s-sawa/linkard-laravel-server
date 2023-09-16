<?php

namespace App\Http\Controllers;

use App\Models\FreePost;
use App\Models\Hobby;
use App\Models\Other;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    if ($request->hasFile('free_image')) {
        $image = $request->file('free_image');
        $filename = time() . '_' . $image->getClientOriginalName();
        // 画像をpublic/profile_imagesディレクトリに保存
        $userDirectory = 'user_images/user' . auth()->user()->id .'/free_image';
        $image->move(public_path($userDirectory), $filename);
    }

    // フリー投稿
    FreePost::create([
        'user_id' => $user->id,
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $userDirectory . '/' . $filename,
    ]);

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
        $freePosts = $user->freePosts;

        return response()->json([
            'user' => $user,
            'hobbies' => $hobbies,
            'otherData' => $otherData,
            'freePosts' => $freePosts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Log::info('Received request data:', ['data' => $request->all()]);

        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザーの情報を更新
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->comment = $request->comment;

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

        // 趣味を更新
        $hobbies = $request->input('hobbies');
        Hobby::where('user_id', $user->id)->delete(); // まず、既存の趣味を削除
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

        // その他のデータを更新
        $others = $request->input('others');
        Other::where('user_id', $user->id)->delete(); // まず、既存のその他のデータを削除
        if (is_array($others)) {
            foreach ($others as $other) {
                Other::create([
                    'user_id' => $user->id,
                    'name' => $other['name'],
                    'newOtherName' => $request->newOtherName, // ここで$requestからnewOtherNameを取得

                    // 'newOtherName' => $other['newOtherName'] ?? null,
                ]);
            }
        } else {
            Other::create([
                'user_id' => $user->id,
                'name' => $others,
                'newOtherName' => $others
            ]);
        }

        return response()->json(['message' => 'Profile updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function testMethod(Request $request)
{
    Log::info('Received request data:', ['data' => $request->all()]);
    return response()->json(['message' => 'Data received']);
}
}
