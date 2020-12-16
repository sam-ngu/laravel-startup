<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'email' => 'admin@admin.com',
            'password' => 'secret',
            'confirmed' => true,
        ]);

        User::factory()->create([
            'first_name' => 'Backend',
            'last_name' => 'User',
            'email' => 'executive@executive.com',
            'password' => 'secret',
            'confirmed' => true,
        ]);

        User::factory()->create([
            'first_name' => 'Default',
            'last_name' => 'User',
            'email' => 'user@user.com',
            'password' => 'secret',
            'confirmed' => true,
        ]);

        $this->enableForeignKeys();
    }
}
