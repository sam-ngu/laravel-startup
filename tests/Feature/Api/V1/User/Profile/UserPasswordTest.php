<?php

namespace Tests\Feature\Api\V1\User\Profile;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\ApiTestCase;

class UserPasswordTest extends ApiTestCase
{
    private function passwordApiUrl(string $userId)
    {
        return '/api/v1/users/' . $userId . '/profile/password';
    }

    private function changePasswordForUser(User $user, string $old_password, string $newPassword)
    {
        return $this->patchJson($this->passwordApiUrl($user->id), [
            'old_password' => $old_password,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
    }

    public function test_user_must_submit_password_on_valid_rule()
    {
        $admin = $this->loginAsUser();
        // test request must contain old_password, password and password_confirmation
        $payload = [
            'old_password' => 'secret',
            'password' => 'SecretSanta123!@#',
            'password_confirmation' => 'SecretSanta123!@#',
        ];
        // no old_password should fail
        $response = $this->patchJson($this->passwordApiUrl($admin->id), Arr::except($payload, 'old_password'));
        $response->assertStatus(422);

        // no password should fail
        $response = $this->patchJson($this->passwordApiUrl($admin->id), Arr::except($payload, 'password'));
        $response->assertStatus(422);

        // no password_confirmation should fail
        $response = $this->patchJson($this->passwordApiUrl($admin->id), Arr::except($payload, 'password_confirmation'));
        $response->assertStatus(422);

        // if password and password_confirmation are diff, should fail
        $payloadCopy = $payload;
        data_set($payloadCopy, 'password_confirmation', '123');
        $response = $this->patchJson($this->passwordApiUrl($admin->id), $payloadCopy);
        $response->assertStatus(422);

        // WARNING: Tightly coupled test, not implementing should follow rules, upper, lower, number and symbols

        // old password not match then fail
        $payloadCopy = $payload;
        data_set($payloadCopy, 'password', '1231231213');
        $response = $this->patchJson($this->passwordApiUrl($admin->id), $payloadCopy);
        $response->assertStatus(422);

        // pass if matches all criteria
        $response = $this->patchJson($this->passwordApiUrl($admin->id), $payload);
        $response->assertStatus(200);
        $this->assertTrue(Hash::check(data_get($payload, 'password'), $admin->refresh()->password));
    }

    public function test_user_can_change_self_password_only()
    {
        // if not login expect 401
        $response = $this->changePasswordForUser($this->createUser(), 'secret', 'secrettt');

        $response->assertStatus(401);

        $user = $this->loginAsUser();

        $newPassword = 'Secrettt12@!#$';
        $response = $this->changePasswordForUser($user, 'secret', $newPassword);

        $response->assertStatus(200);
        // check if user password has changed
//        $this->assertTrue(Hash::check($newPassword, $user->refresh()->password));

        // user cant change password for other user
        $response = $this->changePasswordForUser($this->createUser(), 'secret', 'seseseses');
        $response->assertStatus(403);

    }
}
