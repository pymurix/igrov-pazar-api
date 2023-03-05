<?php

namespace Tests\Feature\Auth;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $file = UploadedFile::fake()->create('test.png', 2048);

        $response = $this->post('/register', [
            'first_name' => 'Test User',
            'last_name' => 'Test User last name',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_image' => $file,
        ]);

        $this->assertAuthenticated();
        $response->assertNoContent();
    }
}
