<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserPatchRequest;
use App\Http\Requests\UserPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        $current_user = Auth::user();
        if($current_user->role == 'admin')
        {
            return $current_user;
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return $user;
    }

    public function store(UserPostRequest $request)
    {
        $data = $request->validated();
        $data['name'] = ucwords($data['name']);
        $user = User::create($data);
        return $user;
    }

    public function update(UserPatchRequest $request, $id)
    {
        $data = $request->validated();
        $current_user = Auth::user();

        if($current_user->role !== 'admin' && $current_user->id !== (int)$id)
        {
            return response()->json(['message'=>'Unauthorized'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($data);
        return $user;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
