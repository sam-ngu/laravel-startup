<?php

namespace App\Repositories\Api\V1;

use App\Events\Models\Role\RoleCreated;
use App\Events\Models\Role\RolePermanentlyDeleted;
use App\Events\Models\Role\RoleUpdated;
use App\Exceptions\GeneralJsonException;
use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    public $allowedFilters;

    public function __construct()
    {
        parent::__construct();
        $this->allowedFilters = [
            'name',
        ];
    }

    public function model()
    {
        return Role::class;
    }

    /**
     * @param array $data
     *
     * @return Role
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Role
    {
        $permissions = data_get($data, 'permissions');
        if (! $permissions || count($permissions) === 0) {
            $permissions = [];
        }
        if (config('access.roles.role_must_contain_permission') && $permissions === []) {
            throw new GeneralJsonException('Role needs permission');
        }

        return DB::transaction(function () use ($data, $permissions) {
            $role = parent::create([
                'name' => data_get($data, 'name'),
                'guard_name' => strtolower(data_get($data, 'guard_name', config('auth.defaults.guard'))),
            ]);

            /** @var Role $role */
            if ($role) {
                $role->givePermissionTo($permissions);

                event(new RoleCreated($role));

                return $role;
            }

            throw new GeneralJsonException('Unable to create.', 422);
        });
    }

    /**
     * @param Role $role
     * @param array $data
     *
     * @return Role
     * @throws GeneralJsonException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($role, array $data): Role
    {
        if ($role->isAdmin()) {
            throw new GeneralJsonException('You cannot edit the admin role');
        }
        $permissions = data_get($data, 'permissions');
        if (! $permissions || count($permissions) === 0) {
            $permissions = [];
        }
        if (config('access.roles.role_must_contain_permission') && $permissions === []) {
            throw new GeneralJsonException('Role needs permission');
        }

        return DB::transaction(function () use ($role, $data, $permissions) {
            if ($updated = $role->update([
                'name' => data_get($data, 'name') ?? $role->name,
            ])) {
                $role->syncPermissions(data_get($permissions, '*.name'));
                event(new RoleUpdated($role));

                return $role;
            }

            throw new GeneralJsonException('Unable to update.', 422);
        });
    }


    /**
     * @param Role $role
     *
     * @return Role
     * @throws GeneralJsonException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete($role): Role
    {
        return DB::transaction(function () use ($role) {
            // Delete associated relationships

            if ($role->forceDelete()) {
                event(new RolePermanentlyDeleted($role));

                return $role;
            }

            throw new GeneralJsonException('Unable to delete', 422);
        });
    }

    /**
     * @param Role $role
     *
     * @return Role
     * @throws GeneralJsonException
     */
    public function restore($role): Role
    {
        //        if (is_null($role->deleted_at)) {
        //            throw new GeneralJsonException(__('exceptions.backend.access.roles.cant_restore'));
        //        }
        //
        //        if ($role->restore()) {
        //            event(new RoleRestored($role));
        //
        //            return $role;
        //        }
        //
        //        throw new GeneralJsonException(__('exceptions.backend.access.roles.restore_error'));
    }

    /**
     * @param Role $model
     * @return mixed|void
     */
    public function softDelete($model)
    {
        //        $result = parent::softDelete($model);
        //        event(new RoleDeleted($model));
        //        return $result;
    }
}
