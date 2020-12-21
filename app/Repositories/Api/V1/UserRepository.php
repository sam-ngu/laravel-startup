<?php

namespace App\Repositories\Api\V1;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserPasswordChanged;
use App\Events\Models\User\UserPermanentlyDeleted;
use App\Events\Models\User\UserRestored;
use App\Events\Models\User\UserUpdated;
use App\Exceptions\GeneralException;
use App\Exceptions\GeneralJsonException;
use App\Helpers\General\FileHelper;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = parent::create([
                'name' => data_get($data, 'name'),
                'uuid' => Uuid::uuid4()->toString(),
                'email' => data_get($data, 'email'),
                'password' => data_get($data, 'password'),
                'active' => filter_var(data_get($data, 'active'), FILTER_VALIDATE_BOOLEAN),
                'confirmed' => filter_var(data_get($data, 'active'), FILTER_VALIDATE_BOOLEAN),
            ]);

            // See if adding any additional permissions
            if (! isset($data['permissions']) || ! count($data['permissions'])) {
                $data['permissions'] = [];
            }

            /** @var User $user */
            if ($user) {

                // Add selected roles/permissions
                // fallback role to default
                $user->syncRoles(data_get($data, 'roles', [config('access.users.default_role')]));
                $user->syncPermissions(data_get($data, 'permissions'));

                event(new UserCreated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param User $user
     * @param array $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($user, array $data): User
    {
        // See if adding any additional permissions
        if (! isset($data['permissions']) || ! count($data['permissions'])) {
            $data['permissions'] = [];
        }

        return DB::transaction(function () use ($user, $data) {
            if ($user->update([
                'name' => data_get($data, 'name') ?? data_get($user, 'name'),
                'email' => data_get($data, 'email') ?? data_get($user, 'email'),
            ])) {
                if ($avatar = data_get($data, 'avatar_img')) {
                    $user->avatar_location = Arr::first(FileHelper::imageProcessor([$avatar]));
                    $user->save();
                    throw_if(! $user->save(), GeneralJsonException::class, 'Unable to save user: ' . $user->name);
                }

                $toConfirmUser = ! $user->isConfirmed() && filter_var(data_get($data, 'confirmed', $user->confirmed), FILTER_VALIDATE_BOOLEAN);
                $toUnconfirmUser = $user->isConfirmed() && ! filter_var(data_get($data, 'confirmed', $user->confirmed), FILTER_VALIDATE_BOOLEAN);

                $toDeactivateUser = $user->isActive() && ! filter_var(data_get($data, 'active', $user->active), FILTER_VALIDATE_BOOLEAN);
                $toReactivateUser = ! $user->isActive() && filter_var(data_get($data, 'active', $user->active), FILTER_VALIDATE_BOOLEAN);

                if ($toReactivateUser) {
                    $user = $user->setActive(true);
                }
                if ($toDeactivateUser) {
                    $user = $user->setActive(false);
                }

                if ($toConfirmUser) {
                    $user = $user->confirm();
                }

                if ($toUnconfirmUser) {
                    $user = $user->unconfirm();
                }

                // Add selected roles/permissions
                $roles = data_get($data, 'roles');
                if (is_array($roles)) {
                    $roles = array_map(fn ($role) => data_get($role, 'name'), $roles);
                    $user->syncRoles($roles);
                }
                $permissions = data_get($data, 'permissions');
                if (is_array($permissions)) {
                    $permissions = array_map(fn ($permission) => data_get($permission, 'name'), $permissions);
                    $user->syncPermissions($permissions);
                }

                event(new UserUpdated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_error'));
        });
    }

    public function updatePassword(User $user, $password)
    {
        $user->password = $password;
        $user->password_changed_at = Carbon::now()->toDateTimeString();

        if ($user->save()) {
            event(new UserPasswordChanged($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.update_password_error'));
    }


    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete($user): User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_first'));
        }

        return DB::transaction(function () use ($user) {
            // Delete associated relationships
            $user->passwordHistories()->delete();
            $user->providers()->delete();
            $user->sessions()->delete();

            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function restore($user): User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.restore_error'));
    }
}
