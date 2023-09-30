<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\HobbyLike;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HobbyLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hobbyId)
    {
        Log::info('Received request data:', ['data' => $hobbyId]);
        try {
            $hobby = Hobby::findOrFail($hobbyId); // hobbyIdに基づいてHobbyを検索、なければ404を返す。
            
            $likers = $hobby->likers; // Hobbyモデルにリレーションが正しく定義されている場合、これでいいねしたユーザーのコレクションが取得できます。
            
            return response()->json($likers); // いいねしたユーザーのリストをJSON形式で返す。
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Hobby not found!'], 404); // hobbyが存在しない場合、エラーメッセージと共に404を返す。
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500); // その他のエラーが発生した場合、エラーメッセージと共に500を返す。
        }
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
        Log::info('User ID:', ['userId' => $userId]);
    Log::info('Other ID:', ['hobbyId' => $hobbyId]);

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
