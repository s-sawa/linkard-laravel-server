<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(User $user, Request $request) 
    {
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
        $follow->group_id = $request->group_id; // リクエストからグループIDを取得

        if ($follow->save()) {
            return response()->json(['message' => 'フォローしました'], 201); // 201: Created
        } else {
            return response()->json(['message' => 'フォローに失敗しました'], 500); // 500: Internal Server Error
        }
    }
}
