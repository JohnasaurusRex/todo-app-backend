<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = auth('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
    return response()->json(auth('sanctum')->user());
    }

    public function refresh(): JsonResponse
    {
    // Not needed for Sanctum, but you can return the user and tokens if needed
    return response()->json(['message' => 'Token refresh not supported with Sanctum']);
    }

    // respondWithToken method removed for Sanctum
}
