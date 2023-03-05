<?php

namespace App\Services\Implementations\Auth;

use App\Http\Data\Auth\RegisterData;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterServiceImplementation implements \App\Services\Auth\RegisterService
{
    public function register(RegisterData $register): User
    {
        $user = User::create([
            'name' => $register->firstName,
            'email' => $register->email,
            'password' => Hash::make($register->password),
        ]);

        $hasPhoto = $register->profileImage != null;
        if ($hasPhoto) {
            $path = $register->profileImage->store('images');
        }

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $register->firstName,
            'last_name' => $register->lastName,
            'profile_image' => $hasPhoto ? $path : null,
        ]);

        return $user;
    }
}
