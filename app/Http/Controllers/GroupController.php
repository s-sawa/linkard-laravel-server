<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index() {
        $groups = Group::all();
        return response()->json($groups);
    }

    public function store(Request $request) {
        // name のバリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
        ]);

        $group = Group::create($validatedData);

        // 必要に応じて、レスポンスを返す。
        return response()->json(['message' => 'グループが正常に作成されました。'], 201);
    }
}