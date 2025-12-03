<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}