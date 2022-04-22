<?php

namespace App\Http\Controllers;

use \App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\JsonResponse;



class AuthController extends Controller
{

    public function register(Request $request): JsonResponse
    {

        $validation = $request->validate([
            'name' => 'required|string|max:125',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token-type' => 'Bearer'
        ]);
    }

    public function login(Request $request) :JsonResponse {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details.'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token-type' => 'Bearer'
        ]);
    }

    public function logout() : JsonResponse {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logged out successfully'
        ]);
    }
}
