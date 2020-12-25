<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Hash;

/**
 * Trait UserAttribute.
 */
trait UserAttribute
{
    /**
     * @param $password
     */
    public function setPasswordAttribute($password) : void
    {
        // If password was accidentally passed in already hashed, try not to double hash it
        if (
            (\strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
            (\strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password))
        ) {
            $hash = $password;
        } else {
            $hash = Hash::make($password);
        }

        // Note: Password Histories are logged from the \App\Observer\User\UserObserver class
        $this->attributes['password'] = $hash;
    }

    /**
     * @return string
     */
    public function getRolesLabelAttribute()
    {
        return $this->getRoleNames()->toArray();

//        if (\count($roles)) {
//            return implode(', ', array_map(function ($item) {
//                return ucwords($item);
//            }, $roles));
//        }
//
//        return 'N/A';
    }

    /**
     * @return string
     */
    public function getPermissionsLabelAttribute()
    {
        return $this->getDirectPermissions()->toArray();

//        if (\count($permissions)) {
//            return implode(', ', array_map(function ($item) {
//                return ucwords($item['name']);
//            }, $permissions));
//        }
//
//        return 'N/A';
    }


    /**
     * @return string
     */
    public function getSocialButtonsAttribute()
    {
        $accounts = [];

        foreach ($this->providers as $social) {
            $accounts[] = '<a href="'.route(
                'admin.auth.user.social.unlink',
                [$this, $social]
            ).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.users.unlink').'" data-method="delete"><i class="fab fa-'.$social->provider.'"></i></a>';
        }

        return \count($accounts) ? implode(' ', $accounts) : __('labels.general.none');
    }
}
