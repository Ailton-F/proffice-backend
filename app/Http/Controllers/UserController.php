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

    public function authenticate(AuthRequest $request)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!password_verify($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User authenticated successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'User logged out successfully']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
