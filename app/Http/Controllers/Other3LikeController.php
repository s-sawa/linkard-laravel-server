<?php

namespace App\Http\Controllers;

use App\Models\Other3;
use App\Models\Other3Like;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Other3LikeController extends Controller
{
    public function index($other3Id)
    {
        Log::info('Received request data:', ['data' => $other3Id]);
        try {
            $other3 = Other3::findOrFail($other3Id);

            $likers = $other3->likers;

            return response()->json($likers);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Other3 not found!'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function isOther3Liked($other3Id)
    {
        $user = Auth::user();

        $isLiked = $user->hasLikedOther3($other3Id);

        return response()->json(['isLiked' => $isLiked]);
    }

    public function getLikedOther3s()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $likedOther3s = $user->likedOther3s;

        return response()->json($likedOther3s);
    }

    public function store($other3Id)
    {
        $user = auth()->user();
        $userId = $user->id;
        Log::info('User ID:', ['userId' => $userId]);
        Log::info('Other3 ID:', ['other3Id' => $other3Id]);

        Other3Like::create([
            'user_id' => $userId,
            'other3_id' => $other3Id,
        ]);
        return response()->json(['message' => 'Like added successfully'], 201);
    }

    public function destroy($other3Id)
    {
        $user = auth()->user();

        $like = Other3Like::where('other3_id', $other3Id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed successfully'], 200);
        }

        return response()->json(['message' => 'Like not found'], 404);
    }
}
