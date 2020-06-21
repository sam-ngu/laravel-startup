<?php

namespace App\Models;

/**
 * Class Role.
 */
class Role extends \Spatie\Permission\Models\Role
{
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->name === config('access.users.admin_role');
    }
}
