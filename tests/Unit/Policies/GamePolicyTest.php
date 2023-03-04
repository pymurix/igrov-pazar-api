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
        $user = $this->mockUserHasRole([], true);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_true_when_game_belong_to_user()
    {
        $user = $this->mockUserHasRole(['id' => 123],  false);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_false_when_game_dont_belong_to_user()
    {
        $user = $this->mockUserHasRole(['id' => 145], false);
        $game = new Game(['user_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertFalse($result);
    }

    private function mockUserHasRole(array $userData, bool $hasRoleReturn): User
    {
        $user = new User();
        $user->forceFill($userData);
        $user = Mockery::mock($user);
        $user->shouldReceive('hasRole')
            ->andReturn($hasRoleReturn);

        return $user;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Verify and clean up the Mockery instance
        Mockery::close();
    }
}
