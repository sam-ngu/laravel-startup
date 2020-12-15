<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;

class LoginTest extends ApiTestCase
{
    const LOGIN_URL = '/login';
    const LOGOUT_URL = '/logout';

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

        $response = $this->getJson(self::LOGOUT_URL);

        $response->dump();
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
}
