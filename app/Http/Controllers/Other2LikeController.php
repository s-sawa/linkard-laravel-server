<?php

namespace App\Http\Controllers;

use App\Models\Other2;
use App\Models\Other2Like;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Other2LikeController extends Controller
{
    public function index($other2Id)
    {
        Log::info('Received request data:', ['data' => $other2Id]);
        try {
            $other2 = Other2::findOrFail($other2Id);

            $likers = $other2->likers;

            return response()->json($likers);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Other2 not found!'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function isOther2Liked($other2Id)
    {
        $user = Auth::user();

        $isLiked = $user->hasLikedOther2($other2Id);

        return response()->json(['isLiked' => $isLiked]);
    }

    public function getLikedOther2s()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $likedOther2s = $user->likedOther2s;

        return response()->json($likedOther2s);
    }

    public function store($other2Id)
    {
        $user = auth()->user();
        $userId = $user->id;
        Log::info('User ID:', ['userId' => $userId]);
        Log::info('Other2 ID:', ['other2Id' => $other2Id]);

        Other2Like::create([
            'user_id' => $userId,
            'other2_id' => $other2Id,
        ]);
        return response()->json(['message' => 'Like added successfully'], 201);
    }

    public function destroy($other2Id)
    {
        $user = auth()->user();

        $like = Other2Like::where('other2_id', $other2Id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed successfully'], 200);
        }

        return response()->json(['message' => 'Like not found'], 404);
    }
}
