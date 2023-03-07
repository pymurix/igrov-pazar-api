<?php

namespace Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class MobileAuthenticationTest extends TestCase
{
    public function test_users_can_authenticate_using_token(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/mobile/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'iphone',
        ]);

        $tokenToAssert = explode('|', $response->json('access_token'))[1];
        $response->assertOk()
            ->assertJsonStructure([
                'access_token'
            ]);
        $this->assertEquals(
            $user->tokens()->first()->token,
            hash('sha256', $tokenToAssert)
        );
    }

    public function test_users_can_authenticate_using_token_wrong_creds(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/mobile/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'device_name' => 'iphone',
        ]);

        $response->assertUnprocessable();
    }
}
