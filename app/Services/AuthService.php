<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register the user
     */
    public function register(array $userData): JsonResponse
    {
        // retrieve the user
        $user = User::where('email', $userData['email'])->first();
        if (!empty($user)) {
            return response()->json(['message' => "User already registered. Please login"]);
        }

        // create the user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        // create a token for the user and return it
        $token = $user->createAndGetToken();

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Login the user
     */
    public function login(array $userAuthData): JsonResponse
    {
        // check if the user's credentials are correct
        if (!Auth::attempt($userAuthData)) {
            return response()->json(['errors' => "The provided credentials are incorrect"]);
        }

        // retrieve the user
        $user = User::where('email', $userAuthData['email'])->first();

        // create and get a token for the valid user
        $token = $user->createAndGetToken();

        return response()->json(['token' => $token]);
    }
}
