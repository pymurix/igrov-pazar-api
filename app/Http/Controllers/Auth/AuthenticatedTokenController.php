<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Data\Auth\LoginRequest;
use App\Http\Data\Auth\MobileLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedTokenController extends Controller
{
    public function store(MobileLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->deviceName)
            ->plainTextToken;

        return response()->json(['access_token' => $token]);
    }

    public function destroy(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
