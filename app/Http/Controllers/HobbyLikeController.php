<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\HobbyLike;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HobbyLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hobbyId)
    {
        // 指定されたIDのHobbyを検索
        $hobby = Hobby::find($hobbyId);

        // hobbyIdに対応するHobbyが存在しない場合は、404を返す
        if (!$hobby) {
            return response()->json(['error' => 'Hobby not found'], 404);
        }

        // Hobbyに紐づく「いいね」をしたユーザーのリストを取得
        $likes = $hobby->hobbyLike->pluck('user'); // この行が重要です

        // レスポンスとして、「いいね」をしたユーザーのリストを返す
        return response()->json(['likes' => $likes], 200);
    }

    public function isHobbyLiked($hobbyId)
    {
        $user = Auth::user();
        
        $isLiked = $user->hasLikedHobby($hobbyId);
        
        return response()->json(['isLiked' => $isLiked]);
    }

    public function getLikedHobbies()
    {
        $user = Auth::user(); // 認証済みのユーザーを取得
        
        if(!$user) {
            // ユーザーが認証されていない場合はエラーレスポンス
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $likedHobbies = $user->likedHobbies; // ユーザーがいいねした趣味を取得

        return response()->json($likedHobbies);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store($hobbyId)
    {
        $user = auth()->user();
        $userId = $user->id;

        // 新しいいいねをデータベースに保存
        HobbyLike::create([
            'user_id' => $userId,
            'hobby_id' => $hobbyId,
        ]);
    return response()->json(['message' => 'Like added successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(HobbyLike $hobbyLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HobbyLike $hobbyLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hobbyId)
    {
        // ログインユーザの取得
        $user = auth()->user();

        // 対象の趣味に対するいいねを検索
        $like = HobbyLike::where('hobby_id', $hobbyId)
                        ->where('user_id', $user->id)
                        ->first();

        // いいねが存在すれば削除
        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed successfully'], 200);
        }

        // いいねが見つからなかった場合
        return response()->json(['message' => 'Like not found'], 404);
    }

}
