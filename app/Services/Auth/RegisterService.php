<?php

namespace App\Services\Auth;

use App\Http\Data\Auth\RegisterData;
use App\Models\User;

interface RegisterService
{
    public function register(RegisterData $register): User;
}
