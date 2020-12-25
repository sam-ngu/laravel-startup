<?php


namespace Tests\Utils\Traits;

trait WithRegistration
{
    protected function register(string $name, string $email, string $password)
    {
        return $this->postJson(self::REGISTER_URL, [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
