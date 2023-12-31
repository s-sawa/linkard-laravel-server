<?php

namespace App\Http\Controllers;

use App\Models\Other;
use App\Models\OtherLike;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OtherLikeController extends Controller
{
    public function index($otherId)
    {
        Log::info('Received request data:', ['data' => $otherId]);
        try {
            $other = Other::findOrFail($otherId); 
            
            $likers = $other->likers; 
            
            return response()->json($likers); 
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Other not found!'], 404); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function isOtherLiked($otherId)
    {
        $user = Auth::user();
        
        $isLiked = $user->hasLikedOther($otherId);
        
        return response()->json(['isLiked' => $isLiked]);
    }

    public function getLikedOthers()
    {
        $user = Auth::user();
        
        if(!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $likedOthers = $user->likedOthers;

        return response()->json($likedOthers);
    }

    public function store($otherId)
    {

        $user = auth()->user();
        $userId = $user->id;
        Log::info('User ID:', ['userId' => $userId]);
    Log::info('Other ID:', ['otherId' => $otherId]);

        OtherLike::create([
            'user_id' => $userId,
            'other_id' => $otherId,
        ]);
    return response()->json(['message' => 'Like added successfully'], 201);
    }

    public function destroy($otherId)
    {
        $user = auth()->user();

        $like = OtherLike::where('other_id', $otherId)
                        ->where('user_id', $user->id)
                        ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed successfully'], 200);
        }

        return response()->json(['message' => 'Like not found'], 404);
    }

}
