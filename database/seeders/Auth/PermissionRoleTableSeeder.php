<?php

namespace Database\Seeders\Auth;

use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
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

        $createRoleAttribute = function($roleName)
        {
            return [
                'name' => $roleName,
                'guard_name' => 'web',
            ];
        };

        // Create Roles
        $admin = Role::create($createRoleAttribute(config('access.users.admin_role')));

        $executive = Role::create($createRoleAttribute('executive'));
        $user = Role::create($createRoleAttribute(config('access.users.default_role')));

        // Create Permissions
        $permissions = ['view backend'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ALWAYS GIVE ADMIN ROLE ALL PERMISSIONS
        $admin->givePermissionTo(Permission::all());

        // Assign Permissions to other Roles
        $executive->givePermissionTo('view backend');

        $this->enableForeignKeys();
    }
}
