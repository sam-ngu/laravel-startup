<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

/**
 * Class Role.
 */
class Role extends \Spatie\Permission\Models\Role
{
    use Searchable,
        HasFactory;
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->name === config('access.users.admin_role');
    }

    public function toSearchableArray()
    {
        return $this->only(['id', 'name']);
    }
}
