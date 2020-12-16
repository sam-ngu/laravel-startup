<?php

namespace App\Listeners\User;

use App\Events\Auth\UserLoggedIn;
use App\Events\Auth\UserLoggedOut;
use App\Events\Models\User\UserConfirmed;
use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserPasswordChanged;
use App\Events\Models\User\UserProviderRegistered;
use App\Events\Models\User\UserRegistered;
use App\Models\User;
use App\Notifications\User\RegistrationConfirmation;
use Illuminate\Support\Carbon;

class UserEventSubscriber
{
    /**
     * @param User $user
     */
    private function logPasswordHistory(User $user): void
    {
        if (config('access.users.password_history')) {
            $user->passwordHistories()->create([
                'password' => $user->password, // Password already hashed & saved so just take from model
            ]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(UserLoggedIn::class, function (UserLoggedIn $event) {
            $ip_address = request()->getClientIp();

            // Update the logging in users time & IP
            $event->user->fill([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $ip_address,
            ]);

            // Update the timezone via IP address
            $geoip = geoip($ip_address);

            if ($event->user->timezone !== $geoip['timezone']) {
                // Update the users timezone
                $event->user->fill([
                    'timezone' => $geoip['timezone'],
                ]);
            }

            $event->user->save();

            \Log::info('User Logged In: ' . $event->user->full_name);
        });

        $events->listen(UserLoggedOut::class, function (UserLoggedOut $event) {
            \Log::info('User Logged Out: ' . $event->user->full_name);
        });


        $events->listen(UserRegistered::class, function (UserRegistered $event) {
            /*
             * If users have to confirm their email and this is not a social account,
             * and the account does not require admin approval
             * send the confirmation email
             *
             * If this is a social account they are confirmed through the social provider by default
             */
            // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
            if (config('access.users.confirm_email')) {
                $event->user->notify(new RegistrationConfirmation($event->user->confirmation_code));
            }
        });

        $events->listen(UserProviderRegistered::class, function ($event) {
            \Log::info('User Provider Registered: '.$event->user->full_name);
        });

        $events->listen(UserConfirmed::class, function ($event) {
            \Log::info('User Confirmed: '.$event->user->full_name);
        });

        $events->listen(UserCreated::class, function (UserCreated $event) {
            $this->logPasswordHistory($event->user);
        });

        $events->listen(UserPasswordChanged::class, function ($event) {
            $this->logPasswordHistory($event->user);
        });

    }
}
