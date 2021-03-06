<?php

namespace Tests\Unit;

use App\Models\User;
use App\Rules\CurrentPasswordRule;
use Tests\TestCase;

class CurrentPasswordRuleTest extends TestCase
{
    /** @var CurrentPasswordRule */
    private $rule;

    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->rule = new CurrentPasswordRule();
    }

    public function testWillPassBecausePasswordMatch()
    {
        $this->be($this->user);
        $this->assertTrue($this->rule->passes('current_password', 'secretxxx'));
    }

    public function testWillNotPassBecausePasswordNotMatch()
    {
        $this->be($this->user);
        $this->assertFalse($this->rule->passes('current_password', 'skjdfksf233ksjd'));
    }
}
