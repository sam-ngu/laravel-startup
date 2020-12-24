<?php

namespace Tests;

use App\Models\User;

/**
 * Class TestCase.
 */
abstract class ApiTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Login the given administrator or create the first if none supplied.
     *
     * @param User|bool $admin
     *
     * @return bool|mixed
     */
    protected function loginAsAdmin($admin = false)
    {
        if (! $admin) {
            $admin = $this->createAdmin();
        }

        $this->actingAs($admin, 'web');

        return $admin;
    }

    protected function loginAsUser($user = false)
    {
        if (! $user) {
            $user = $this->createUser();
        }
        $this->actingAs($user, 'web');

        return $user;
    }
}
