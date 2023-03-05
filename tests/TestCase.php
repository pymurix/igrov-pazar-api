<?php

namespace Tests;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createUser(array $roles = [User::ROLE_USER], array $permissions = []): User
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole($roles);
        $user->givePermissionTo($permissions);

        Profile::factory()->create(['user_id' => $user->id]);
        return $user;
    }
}
