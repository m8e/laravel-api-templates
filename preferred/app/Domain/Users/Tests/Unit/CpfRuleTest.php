<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Preferred\Domain\Users\Rules\CpfRule;
use Tests\TestCase;

class CpfRuleTest extends TestCase
{
    /** @var CpfRule */
    private $rule;

    public function setUp()
    {
        parent::setUp();

        $this->rule = new CpfRule();
    }

    public function testValidCpf()
    {
        $this->assertTrue($this->rule->passes('cpf', '127.489.080-23'));
        $this->assertTrue($this->rule->passes('cpf', '12748908023'));
    }

    public function testInValidCpf()
    {
        $this->assertFalse($this->rule->passes('cpf', '127.489.080-22'));
        $this->assertFalse($this->rule->passes('cpf', '12748908022'));
        $this->assertFalse($this->rule->passes('cpf', '27.558.514/0001-13'));
        $this->assertFalse($this->rule->passes('cpf', '27558514000113'));
    }
}
