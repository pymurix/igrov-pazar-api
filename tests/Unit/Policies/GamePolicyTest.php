<?php

namespace Tests\Unit\Policies;

use App\Models\Game;
use App\Models\User;
use App\Policies\GamePolicy;
use App\Services\Implementations\GameServiceImplementation;
use Mockery;
use PHPUnit\Framework\TestCase;

class GamePolicyTest extends TestCase
{
    private $gamePolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gamePolicy =
            new GamePolicy(new GameServiceImplementation());
    }

    public function test_write_return_true_when_user_is_admin()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('hasRole')
            ->andReturn(true);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_true_when_game_belong_to_user()
    {
        $user = new User();
        $user->id = 123;
        $user = Mockery::mock($user);
        $user->shouldReceive('hasRole')
            ->andReturn(false);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_false_when_game_dont_belong_to_user()
    {
        $user = new User();
        $user->id = 145;
        $user = Mockery::mock($user);
        $user->shouldReceive('hasRole')
            ->andReturn(false);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Verify and clean up the Mockery instance
        Mockery::close();
    }
}
