<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Laravel\Passport\Client;

class PassportClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'user_id' => null,
            'name' => $this->faker->company,
            'secret' => Str::random(40),
            'redirect' => $this->faker->url,
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ];
    }

    public function password_client()
    {
        return $this->state(function () {
            return [
                'personal_access_client' => false,
                'password_client' => true,
            ];
        });
    }
}
