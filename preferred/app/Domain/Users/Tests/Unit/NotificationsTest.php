<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Notifications\AccountDisabledNotification;
use Preferred\Domain\Users\Notifications\AuthorizeDeviceNotification;
use Preferred\Domain\Users\Notifications\PasswordChangedNotification;
use Preferred\Domain\Users\Notifications\ResetPasswordNotification;
use Preferred\Domain\Users\Notifications\SuccessfulLoginFromIpNotification;
use Preferred\Domain\Users\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testVerifyEmailNotification()
    {
        $token = Uuid::uuid4();
        $notification = new VerifyEmailNotification($token);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Confirm your registration', $notification->toMail($this->user)->subject);
    }

    public function testTwoFactorAuthenticationWasDisabledNotification()
    {
        $notification = new TwoFactorAuthenticationWasDisabledNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Two Factor Authentication Disabled', $notification->toMail($this->user)->subject);
    }

    public function testSuccessfulLoginFromIpNotification()
    {
        $mock = [
            'user_id'          => $this->user->id,
            'ip'               => 'test',
            'device'           => 'test',
            'platform'         => 'test',
            'platform_version' => 'test',
            'browser'          => 'test',
            'browser_version'  => 'test',
            'city'             => 'test',
            'region_code'      => 'test',
            'region_name'      => 'test',
            'country_code'     => 'test',
            'country_name'     => 'test',
            'continent_code'   => 'test',
            'continent_name'   => 'test',
            'latitude'         => 'test',
            'longitude'        => 'test',
            'zipcode'          => 'test',
        ];

        $notification = new SuccessfulLoginFromIpNotification($mock);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Successful Login From New IP', $notification->toMail($this->user)->subject);
    }

    public function testResetPasswordNotification()
    {
        $token = Uuid::uuid4();
        $notification = new ResetPasswordNotification($token);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertEquals($token, $notification->token);
        $this->assertContains('Reset password', $notification->toMail($this->user)->subject);
    }

    public function testPasswordChangedNotification()
    {
        $notification = new PasswordChangedNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Password Changed', $notification->toMail($this->user)->subject);
    }

    public function testAccountDisabledNotification()
    {
        $notification = new AccountDisabledNotification();
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Account disabled', $notification->toMail($this->user)->subject);
    }

    public function testAuthorizeDeviceNotification()
    {
        $mock = [
            'ip'                  => '0.0.0.0',
            'device'              => 'test',
            'platform'            => 'test',
            'platform_version'    => 'test',
            'browser'             => 'test',
            'browser_version'     => 'test',
            'city'                => 'test',
            'country_name'        => 'test',
            'authorization_token' => Uuid::uuid4(),
            'authorized_at'       => null,
            'user_id'             => $this->user->id,
        ];

        $notification = new AuthorizeDeviceNotification($mock);
        $this->assertEquals('notifications', $notification->queue);
        $this->assertContains('Authorize New Device', $notification->toMail($this->user)->subject);
    }
}
