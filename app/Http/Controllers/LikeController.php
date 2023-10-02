<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\HobbyLike;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function index($resourceType, $resourceId)
    {
        Log::info('Received request data:', ['resourceType' => $resourceType, 'resourceId' => $resourceId]);

        try {
            $model = $this->getModel($resourceType);
            $resource = $model::findOrFail($resourceId);

            $likers = $resource->likers;
            return response()->json($likers);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => ucfirst($resourceType) . ' not found!'], 404);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    protected function getModel($resourceType)
    {
        $models = [
            'hobbies' => \App\Models\Hobby::class,
            'others' => \App\Models\Other::class,
            'others2' => \App\Models\Other2::class,
            'others3' => \App\Models\Other3::class,
        ];

        if (!isset($models[$resourceType])) {
            throw new \InvalidArgumentException("Invalid resource type: $resourceType");
        }

        return $models[$resourceType];
    }

    public function isResourceLiked($resourceType, $resourceId)
    {
        Log::info('Resource Type:', ['resourceType' => $resourceType]);
        Log::info('Resource ID:', ['resourceId' => $resourceId]);
        $user = Auth::user();

        try {
            $model = $this->getModel($resourceType);
            $methodName = 'hasLiked' . class_basename($model);

            if (!method_exists($user, $methodName)) {
                throw new \BadMethodCallException("Method $methodName does not exist on User model.");
            }

            $isLiked = $user->$methodName($resourceId);

            return response()->json(['isLiked' => $isLiked]);

        } catch (\Exception $e) {
            // エラーメッセージとスタックトレースのログ出力
            Log::error('Error Message:', ['error' => $e->getMessage()]);
            Log::error('Stack Trace:', ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], $e instanceof ModelNotFoundException ? 404 : 500);
}

    }

    public function getLikedHobbies()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $likedHobbies = $user->likedHobbies;
        return response()->json($likedHobbies);
    }

    public function store($resourceType, $resourceId)
    {
        $user = auth()->user();
        $userId = $user->id;

        try {
            $model = $this->getModel($resourceType);
            $likeModel = $this->getLikeModel($resourceType);

            $likeModel::create([
                'user_id' => $userId,
                strtolower(class_basename($model)) . '_id' => $resourceId,
            ]);

            return response()->json(['message' => 'Like added successfully'], 201);
        } catch (\Exception $e) {
        Log::error('Error Message: ', ['error' => $e->getMessage()]);
        Log::error('Stack Trace: ', ['trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    protected function getLikeModel($resourceType)
    {
        $likeModels = [
            'hobbies' => \App\Models\HobbyLike::class,
            'others' => \App\Models\OtherLike::class,
            'others2' => \App\Models\Other2Like::class,
            'others3' => \App\Models\Other3Like::class,

        ];

        if (!isset($likeModels[$resourceType])) {
            throw new \InvalidArgumentException("Invalid resource type for like: $resourceType");
        }

        return $likeModels[$resourceType];
    }

    public function destroy($resourceType, $resourceId)
    {
        $user = auth()->user();

        try {
            $model = $this->getModel($resourceType);
            $likeModel = $this->getLikeModel($resourceType);
            $columnName = strtolower(class_basename($model)) . '_id';

            $like = $likeModel::where($columnName, $resourceId)
                ->where('user_id', $user->id)
                ->first();

            if ($like) {
                $like->delete();
                return response()->json(['message' => 'Like removed successfully'], 200);
            }

            return response()->json(['message' => 'Like not found'], 404);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
