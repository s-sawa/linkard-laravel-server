<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //ログイン中のユーザー情報を取得
        $user = auth()->user();
        return response()->json($user);
    }

    public function getUserProfile(Request $request)
    {
        // ログイン中のユーザー情報を取得
        $user = $request->user();

        // ユーザーの趣味情報をロード
        $user->load('hobbies');

        // レスポンスとしてJSONを返す
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}