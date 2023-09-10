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
        // $user = Auth::user();

        // ユーザーの情報を更新
        $user->birthday = $request->birthday;
        $user->comment = $request->comment;
        // ... その他のカラムも必要に応じて追加
        $user->save();

        // 既存の趣味を削除する場合（必要に応じて）

        // 作成されたユーザーのIDを使用して、趣味をHobbiesテーブルに保存します
        foreach ($request->hobbies as $hobbyData) {
            Hobby::create([
                'user_id' => $user->id,
                'hobby' => $hobbyData['hobby']
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