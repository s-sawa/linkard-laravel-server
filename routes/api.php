<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HobbyLikeController;
use App\Http\Controllers\Other2LikeController;
use App\Http\Controllers\Other3LikeController;
use App\Http\Controllers\OtherLikeController;
use App\Http\Controllers\OtherProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\HobbyLike;
use App\Models\Other;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);


// ログインが必要なルート
// Route::middleware('auth:sanctum')->group(function () {
Route::middleware(['auth:sanctum', 'throttle:6000,1'])->group(function () {

    // --------自分のプロフィール--------
    // 登録する
    Route::post('/profile/me', [ProfileController::class, 'store'])->name('profile.me');
    // 取得する
    Route::get('/profile/me', [ProfileController::class, 'show'])->name('profile.me');
    // 更新する
    Route::put('/profile/me', [ProfileController::class, 'update'])->name('profile.me');
    // 削除する
    Route::delete('/profile/me', [ProfileController::class, 'destroy'])->name('profile.me');
    
    // ログアウト
    Route::post('/logout', LogoutController::class)->name('logout');
    // グループ名取得
    Route::get('/groups', [GroupController::class, 'index']);
    // グループ名作成
    Route::post('/groups', [GroupController::class, 'store']);
    // qr読み取り後のプロフィール表示
    // Route::get('/profile/{user_id}/preview', [OtherProfileController::class, 'show'])->name('profile.user');
    Route::get('/profile/{user_id}/preview', [ProfileController::class, 'show'])->name('profile.user');
    // フォローする
    Route::post('/users/{user}/follow', [FollowController::class, 'store']);
    // フォロー解除
    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy']);



    // フォロー状態の確認
    Route::get('/users/me/follows/{toUserId}', [FollowController::class, 'show']);
    // フォローユーザーの情報取得
    Route::get('/users/following', [UserController::class, 'getFollowingUsers']);
    // --------趣味--------
    // いいねする
    Route::post('/hobbies/{hobbyId}/likes', [HobbyLikeController::class, 'store']);
    // いいね解除
    Route::delete('/hobbies/{hobbyId}/likes', [HobbyLikeController::class, 'destroy']);
    // いいねしてくれた人を取得
    Route::get('/hobbies/{hobbyId}/likes', [HobbyLikeController::class, 'index']);
    // いいねの状態取得
    Route::get('/hobbies/{hobbyId}/liked', [HobbyLikeController::class, 'isHobbyLiked']);

    // --------その他1--------
    Route::post('/others/{otherId}/likes', [OtherLikeController::class, 'store']);
    // いいね解除
    Route::delete('/others/{otherId}/likes', [OtherLikeController::class, 'destroy']);
    // いいねしてくれた人を取得
    Route::get('/others/{otherId}/likes', [OtherLikeController::class, 'index']);
    // いいねの状態取得
    Route::get('/others/{otherId}/liked', [OtherLikeController::class, 'isOtherLiked']);

    // --------その他2--------
    Route::post('/others2/{other2Id}/likes', [Other2LikeController::class, 'store']);
    // いいね解除
    Route::delete('/others2/{other2Id}/likes', [Other2LikeController::class, 'destroy']);
    // いいねしてくれた人を取得
    Route::get('/others2/{other2Id}/likes', [Other2LikeController::class, 'index']);
    // いいねの状態取得
    Route::get('/others2/{other2Id}/liked', [Other2LikeController::class, 'isOther2Liked']);

    // --------その他2--------
    Route::post('/others3/{other3Id}/likes', [Other3LikeController::class, 'store']);
    // いいね解除
    Route::delete('/others3/{other3Id}/likes', [Other3LikeController::class, 'destroy']);
    // いいねしてくれた人を取得
    Route::get('/others3/{other3Id}/likes', [Other3LikeController::class, 'index']);
    // いいねの状態取得
    Route::get('/others3/{other3Id}/liked', [Other3LikeController::class, 'isOther3Liked']);
});