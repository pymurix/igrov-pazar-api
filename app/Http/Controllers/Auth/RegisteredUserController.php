<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\File;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $registerRequest): Response
    {
        $registerRequest->validated();

        $user = User::create([
            'name' => $registerRequest->first_name,
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password),
        ]);
        $hasPhoto = $registerRequest->hasFile('profile_image');
        if ($hasPhoto) {
            $path = $registerRequest->profile_image->store('images');
        }
        $profile = Profile::create([
            'user_id' => $user->id,
            'first_name' => $registerRequest->first_name,
            'last_name' => $registerRequest->last_name,
            'profile_image' => $hasPhoto ? $path : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
