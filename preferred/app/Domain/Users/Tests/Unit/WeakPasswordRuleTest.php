<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Preferred\Domain\Users\Rules\WeakPasswordRule;
use Tests\TestCase;

class WeakPasswordRuleTest extends TestCase
{
    /** @var WeakPasswordRule */
    private $rule;

    public function setUp()
    {
        parent::setUp();

        $this->rule = new WeakPasswordRule();
    }

    public function testWillPassBecausePasswordIsNotInWeakPasswordList()
    {
        $this->assertTrue($this->rule->passes('password', 'skjdfksf233ksjd'));
    }

    public function testWillNotPassBecausePasswordIsInWeakPasswordList()
    {
        $this->assertFalse($this->rule->passes('password', 'senha123'));
    }
}
