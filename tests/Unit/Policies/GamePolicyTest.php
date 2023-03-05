<?php

namespace Tests\Unit\Policies;

use App\Models\Game;
use App\Models\User;
use App\Policies\GamePolicy;
use App\Services\Implementations\GameServiceImplementation;
use Illuminate\Support\Facades\Session;
use Mockery;
use PHPUnit\Framework\TestCase;

class GamePolicyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Session::shouldReceive('get')->andReturn(random_int(10000, 240000));
    }

    public function test_write_return_true_when_user_is_admin()
    {
        $gamePolicy = $this
            ->mockGameServiceGameBelongsToUser(false);
        $user = $this->mockUserHasRole(true);
        $game = new Game();

        $result = $gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_true_when_game_belong_to_user()
    {
        $gamePolicy = $this
            ->mockGameServiceGameBelongsToUser(true);
        $user = $this->mockUserHasRole(false);
        $game = new Game();

        $result = $gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_false_when_game_dont_belong_to_user()
    {
        $gamePolicy = $this
            ->mockGameServiceGameBelongsToUser(false);
        $user = $this->mockUserHasRole(false);
        $game = new Game();

        $result = $gamePolicy->write($user, $game);

        $this->assertFalse($result);
    }

    private function mockUserHasRole(bool $hasRoleReturn): User
    {
        $user = new User();
        $user = Mockery::mock($user);
        $user->shouldReceive('hasRole')->andReturn($hasRoleReturn);

        return $user;
    }

    private function mockGameServiceGameBelongsToUser(bool $isGameBelongToUser): GamePolicy
    {
        $mockedGameService = Mockery::mock(GameServiceImplementation::class);
        $mockedGameService->shouldReceive('isGameBelongsToUser')
            ->andReturn($isGameBelongToUser);

        return new GamePolicy($mockedGameService);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
