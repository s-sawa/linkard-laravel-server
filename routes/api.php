<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OtherProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Other;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    // 自分のプロフィールを登録する
    Route::post('/profile/me', [ProfileController::class, 'store'])->name('profile.me');
    // 自分の登録プロフィールを取得する
    Route::get('/profile/me', [ProfileController::class, 'show'])->name('profile.me');
    // 自分の登録プロフィールを更新する
    Route::put('/profile/me', [ProfileController::class, 'update'])->name('profile.me');
    // 自分の登録プロフィールを削除する
    Route::delete('/profile/me', [ProfileController::class, 'destroy'])->name('profile.me');
   // ログアウト
    Route::post('/logout', LogoutController::class)->name('logout');

    // グループ名取得
    Route::get('/groups', [GroupController::class, 'index']);
    // グループ名作成
    Route::post('/groups', [GroupController::class, 'store']);

    // qr読み取り後のプロフィール表示
    Route::get('/profile/{user_id}/preview', [OtherProfileController::class, 'show'])->name('profile.user');
    
    // フォローする
    Route::post('/users/{user}/follow', [FollowController::class, 'store']);
    
    // フォロー状態の確認
    Route::get('/users/me/follows/{toUserId}', [FollowController::class, 'show']);

    // フォローユーザーの情報取得
    Route::get('/users/following', [UserController::class, 'getFollowingUsers']);


    // Route::get('user', function (Request $request) {
    //     return $request->user();
    // });
});