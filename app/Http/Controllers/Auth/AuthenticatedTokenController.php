<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Data\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedTokenController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = Auth::user()->createToken($request->input('device_name'))
            ->plainTextToken;

        return response()->json(['access_token' => $token]);
    }

    public function destroy(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
