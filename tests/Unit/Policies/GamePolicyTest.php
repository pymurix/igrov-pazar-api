<?php

namespace Tests\Unit\Policies;

use App\Models\Game;
use App\Models\Profile;
use App\Models\User;
use App\Policies\GamePolicy;
use App\Services\Implementations\GameServiceImplementation;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Session;
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
        $user = $this->mockUserHasRole(86, true);
        $game = new Game();

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_true_when_game_belong_to_user()
    {
        $profileId = 123;
        $user = $this->mockUserHasRole($profileId,  false);
        $game = new Game(['profile_id' => $profileId]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertTrue($result);
    }

    public function test_write_return_false_when_game_dont_belong_to_user()
    {
        $user = $this->mockUserHasRole(343, false);
        $game = new Game(['profile_id' => 123]);

        $result = $this->gamePolicy->write($user, $game);

        $this->assertFalse($result);
    }

    private function mockUserHasRole(int $profileId, bool $hasRoleReturn): User
    {
        $user = new User();
        Session::shouldReceive('get')->andReturn($profileId);
        $user = Mockery::mock($user);
        $user->shouldReceive('hasRole')->andReturn($hasRoleReturn);

        return $user;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Session::swap(null);
        Mockery::close();
    }
}
