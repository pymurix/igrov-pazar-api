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
        $user = $this->createUser($register);
        $this->createProfile($register, $user->id);
        return $user;
    }

    private function createUser(RegisterData $register): User
    {
        return User::create([
            'name' => $register->firstName,
            'email' => $register->email,
            'password' => Hash::make($register->password),
        ]);
    }

    private function createProfile(RegisterData $register, int $userId): Profile
    {
        $hasPhoto = $register->profileImage != null;
        if ($hasPhoto) {
            $path = $register->profileImage->store('images');
        }

        return Profile::create([
            'user_id' => $userId,
            'first_name' => $register->firstName,
            'last_name' => $register->lastName,
            'profile_image' => $hasPhoto ? $path : null,
        ]);
    }
}
