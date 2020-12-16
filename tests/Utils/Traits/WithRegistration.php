<?php


namespace Tests\Utils\Traits;

trait WithRegistration
{
    protected function register(string $firstName, string $lastName, string $email, string $password)
    {
        return $this->postJson(self::REGISTER_URL, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
