<?php

namespace Http\Controllers\Auth;

use Tests\TestCase;
class AuthSanctumTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = $this->createUser();
        $token = $user->createToken('some_token')->plainTextToken;
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }

    public function test_sanctum_user_endpoint()
    {
        $response = $this->getJson('/api/user');
        $this->assertAuthenticated();
    }
}
