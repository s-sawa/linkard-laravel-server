<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    public function store(User $user, Request $request)
    {
        Log::info('Received Request Data:', $request->all());

        $follower = auth()->user(); // 認証済みユーザーを取得

        // 既にフォローしているか確認
        $existingFollow = Follow::where('from_user_id', $follower->id)
                                ->where('to_user_id', $user->id)
                                ->first();

        if ($existingFollow) {
            return response()->json(['message' => '既にフォローしています'], 409); // 409: Conflict
        }

        // follows テーブルにデータを保存
        $follow = new Follow();
        $follow->from_user_id = $follower->id;
        $follow->to_user_id = $user->id;
        $follow->group_id = $request->groupId; // リクエストからグループIDを取得

        if ($follow->save()) {
            return response()->json(['message' => 'フォローしました'], 201); // 201: Created
        } else {
            return response()->json(['message' => 'フォローに失敗しました'], 500); // 500: Internal Server Error
        }
    }

    public function show(Request $request, $toUserId)
    {
        // 認証ユーザーを取得
        $user = $request->user();

        // 認証ユーザーが特定のユーザーをフォローしているかどうかをチェック
        $isFollowing = $user->followingUsers()->where('to_user_id', $toUserId)->exists();

        // レスポンスを返す
        return response()->json(['isFollowing' => $isFollowing]);
    }
}
