<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OtherProfileController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        // ユーザーIDを使用してユーザー情報を取得
        $user = User::find($user_id);

        if (!$user) {
            // ユーザーが存在しない場合のエラーハンドリング
            return response()->json(['error' => 'ユーザーが見つかりません'], 404);
        }

        // ユーザーの情報を取得
        $hobbies = $user->hobbies;
        $otherData = $user->others;
        $freePosts = $user->freePosts;

        // ログイン中のユーザーIDを取得
        $loggedInUserId = auth()->user()->id;

        return response()->json([
            'user' => $user,
            'hobbies' => $hobbies,
            'otherData' => $otherData,
            'freePosts' => $freePosts,
            'loggedInUserId' => $loggedInUserId, // ログイン中のユーザーIDを含める

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
