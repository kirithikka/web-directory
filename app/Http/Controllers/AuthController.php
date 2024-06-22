<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Users\UserData;
use App\Services\AuthService;
use App\Data\Users\UserAuthData;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Register the user
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $userData = UserData::validate($request->all());

            return $this->authService->register($userData);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Login method
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $userAuthData = UserAuthData::validate($request->all());

            return $this->authService->login($userAuthData);
            
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Logout method
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
