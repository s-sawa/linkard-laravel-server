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
        $user = auth()->user();

        // 趣味のデータを取得
        $hobbies = $user->hobbies; // Userモデルで定義したリレーションを介して取得
        // $otherData = $user->others;
        // $freePosts = $user->freePosts;

        return response()->json([
            'user' => $user,
            'hobbies' => $hobbies,
            // 'otherData' => $otherData,
            // 'freePosts' => $freePosts,
        ]);
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