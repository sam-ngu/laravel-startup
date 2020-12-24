<?php

namespace Tests\Feature\Auth;

use App\Notifications\User\UserNeedsPasswordReset;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\ApiTestCase;

class ResetPasswordTest extends ApiTestCase
{

    const FORGOT_PASSWORD_URL = '/forgot-password';

    public function test_forgot_password_email_is_sent()
    {
        Notification::fake();
        $user = $this->createUser();
        $response = $this->postJson(self::FORGOT_PASSWORD_URL, [
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
        Notification::assertSentTo($user, UserNeedsPasswordReset::class);
    }

}
