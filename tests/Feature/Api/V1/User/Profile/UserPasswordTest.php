<?php

namespace Tests\Feature\Api\V1\User\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ApiTestCase;


class UserPasswordTest extends ApiTestCase
{
    private function passwordApiUrl(string $userId)
    {
        return '/api/v1/users/' . $userId . '/profile/password';
    }

    private function changePasswordForUser(User $user, string $old_password, string $newPassword)
    {
        return $this->json('patch', $this->passwordApiUrl($user->id), [
            'old_password' => $old_password,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
    }

    public function test_user_must_submit_password_on_valid_rule()
    {
        $admin = $this->loginAsAdmin();
        // test request must contain old_password, password and password_confirmation

//        $response = $this->json();

        // test old password must match

        // test password and password confirm must match

        // test password must follow rules defined
    }

    public function test_user_can_change_self_password_only()
    {
        // if not login expect 401
        $response = $this->changePasswordForUser($this->createUser(), 'secret', 'secrettt');

        $response->assertStatus(401);

        $user = $this->loginAsUser();

        $response = $this->json('patch', $this->passwordApiUrl($user->id), [
            'old_password'
        ]);


    }
}
