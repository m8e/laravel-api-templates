<?php

namespace Tests\Unit;

use App\Models\LoginHistory;
use App\Models\User;
use Tests\TestCase;

class LoginHistoryTest extends TestCase
{
    /** @var LoginHistory */
    private $loginHistory;

    public function setUp()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->loginHistory = factory(LoginHistory::class)->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->loginHistory->user->id);
    }
}
