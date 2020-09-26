<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'email_verified_at' => now(),
            'password' => 'secret',
            'password_changed_at' => null,
            'remember_token' => Str::random(10),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'active' => 1,
            'confirmed' => 1,
        ];
    }

    public function active()
    {
        return $this->state(function () {
            return [
                'active' => 1,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function () {
            return [
                'active' => 0,
            ];
        });
    }

    public function confirmed()
    {
        return $this->state(function () {
            return [
                'confirmed' => 1,
            ];
        });
    }

    public function unconfirmed()
    {
        return $this->state(function () {
            return [
                'confirmed' => 0,
            ];
        });
    }

    public function softDeleted()
    {
        return $this->state(function () {
            return [
                'deleted_at' => now(),
            ];
        });
    }
}
