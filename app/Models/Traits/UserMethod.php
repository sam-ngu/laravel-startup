<?php

namespace App\Models\Traits;

use App\Events\Models\User\UserConfirmed;
use App\Events\Models\User\UserDeactivated;
use App\Events\Models\User\UserReactivated;
use App\Events\Models\User\UserUnconfirmed;
use App\Exceptions\GeneralException;
use App\Exceptions\GeneralJsonException;
use App\Models\User;
use App\Notifications\User\UserAccountActive;
use App\Notifications\User\UserNeedsPasswordReset;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return mixed
     */
    public function canChangeEmail()
    {
        return config('access.users.change_email');
    }

    /**
     * @return bool
     */
    public function canChangePassword()
    {
        return ! app('session')->has(config('access.socialite_session_name'));
    }

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider === $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole(config('access.users.admin_role'));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return config('access.users.requires_approval') && ! $this->confirmed;
    }


    // this will overwrite default laravel notification

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserNeedsPasswordReset($token));
    }

    public function confirm()
    {
        throw_if($this->isConfirmed(), GeneralJsonException::class, __('exceptions.backend.access.users.already_confirmed'));

        $this->confirmed = 1;

        $saved = $this->save();

        if($saved){
            event(new UserConfirmed($this));

            if(config('access.users.requires_approval')){
                $this->notify(new UserAccountActive);
            }

            return $this;
        }
        throw new GeneralException(__('exceptions.backend.access.users.cant_confirm'));
    }

    public function unconfirm()
    {
        if(!$this->isConfirmed()){
            throw new GeneralException(__('exceptions.backend.access.users.not_confirmed'));
        }

        throw_if($this->id === auth()->id(), GeneralJsonException::class, __('exceptions.backend.access.users.cant_unconfirm_self'));

        throw_if($this->hasRole(config('access.users.admin_role')), GeneralJsonException::class, __('exceptions.backend.access.users.cant_unconfirm_admin'));

        $this->confirmed = 0;
        $unconfirmed = $this->save();

        if($unconfirmed){
            event(new UserUnconfirmed($this));
            return $this;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_confirm'));
    }

    public function setActive(bool $isActive = true)
    {
        if($this->active === $isActive ){
            return $this;
        }

        $this->active = $isActive;

        if($isActive){
            event(new UserReactivated($this));
        }else{
            event(new UserDeactivated($this));
        }
        if($this->save()){
            return  $this;
        }
        throw new GeneralJsonException(__('exceptions.backend.access.users.mark_error'));
    }
}
