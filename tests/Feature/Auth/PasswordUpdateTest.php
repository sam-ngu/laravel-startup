<?php

namespace Tests\Feature\Auth;

use App\Events\Models\User\UserPasswordChanged;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\ApiTestCase;

class PasswordUpdateTest extends ApiTestCase
{
    protected function passwordUpdateUrl($userId)
    {
        return '/api/v1/users/' . $userId . '/profile/password';
    }

    protected function changePassword($user, $oldPassword, $newPassword)
    {
        return $this->patchJson($this->passwordUpdateUrl($user->id), [
            'old_password' => $oldPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
    }

    public function test_user_password_can_be_changed()
    {
        Event::fake();
        // login as user
        $user  = $this->loginAsUser();
        $oldPassword = $user->password;
        $password = 'Secretsecret123!';

        $response = $this->changePassword($user, 'secret', $password);

        // assert password is different
        $response->assertStatus(200);
        $this->assertNotEquals($oldPassword, $user->refresh()->password);

        $this->assertTrue(Hash::check($password, $user->password));

        Event::assertDispatched(UserPasswordChanged::class);

    }


    public function test_password_must_comply_with_rules()
    {
        $user = $this->loginAsUser();
        $response = $this
            ->changePassword($user, 'secret', '123')
            ->assertStatus(422);

        $response = $this
            ->changePassword($user, 'secret', 'aa123')
            ->assertStatus(422);
        $response = $this
            ->changePassword($user, 'secret', 'aa123AA')
            ->assertStatus(422);

        $response = $this
            ->changePassword($user, 'secret', 'aa123AA!@$#')
            ->assertStatus(200);
    }

    public function test_user_cant_update_others_password()
    {
        $user = $this->loginAsUser();
        $user2 = $this->createUser();

        $response = $this->changePassword($user2, 'secret', 'aa123AA!@#');
        $response->assertStatus(403);
    }

    public function test_user_must_login_to_change_password()
    {
        $user = $this->createUser();
        $response = $this->changePassword($user, 'secret', 'awad!@#12313ADAS');
        $response->assertStatus(401);
    }

}
