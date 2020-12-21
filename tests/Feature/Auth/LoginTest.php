<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;

class LoginTest extends ApiTestCase
{
    const LOGIN_URL = '/login';
    const LOGOUT_URL = '/logout';
    const LOGOUT_AS_URL = '/logout-as';

    private function loginAsUrl(string $userId)
    {
        return '/login-as/' . $userId;
    }

    private function login(string $username, string $password)
    {
        return $this->postJson(self::LOGIN_URL, [
            'email' => $username,
            'password' => $password,
        ]);
    }

    public function test_user_can_login()
    {
        $user = $this->createUser();

        $response = $this->login($user->email, 'secret');

        $response->assertStatus(200);
    }

    public function test_user_can_logout()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $this->assertTrue(auth()->check());

        $response = $this->postJson(self::LOGOUT_URL);

        $response->assertStatus(204);

        // test if user is still logged in
        $this->assertFalse(auth()->check());
    }

    public function test_wrong_password_will_throw_422()
    {
        $user = $this->createUser();

        $response = $this->login($user->email, '123');

        $response->assertStatus(422);
    }

    public function test_login_username_must_be_valid()
    {
        $response = $this->login('some', '123');
        $response->assertStatus(422);
    }

    public function test_only_user_cant_login_as_others()
    {
        $user = $this->createUser();
        $this->login($user->email, 'secret');

        $user2 = $this->createUser();
        $response = $this->getJson($this->loginAsUrl($user2->id));

        $response->assertStatus(302);
    }

    public function test_admin_can_login_as_others()
    {
        $user = $this->createUser();

        $admin = $this->createAdmin();
        $this->login($admin->email, 'secret');

        $response = $this->getJson($this->loginAsUrl($user->id));

        $this->assertSame($admin->id, session()->get('admin_user_id'));
        $this->assertSame($user->id, session()->get('temp_user_id'));

        // admin can logout
        $response = $this->getJson(self::LOGOUT_AS_URL);
        $this->assertNull(session()->get('admin_user_id'));
        $this->assertNull(session()->get('admin_user_name'));
        $this->assertNull(session()->get('temp_user_id'));
    }
}
