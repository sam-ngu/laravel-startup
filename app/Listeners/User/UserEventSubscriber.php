<?php

namespace App\Listeners\User;

use App\Events\Models\User\UserConfirmed;
use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserPasswordChanged;
use App\Events\Models\User\UserProviderRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\VerifyEmail;
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

    private function isUserNotConfirmed(User $user)
    {
        return $user->confirmed === false;
    }

    private function needAccountApproval()
    {
        return ! config('access.users.requires_approval');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(Login::class, function (Login $event) {
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
            $saved = $event->user->save();

            \Log::info('User Logged In: ' . $event->user->name);
        });

        $events->listen(Logout::class, function (Logout $event) {
            \Log::info('User Logged Out: ' . $event->user->name);
        });


        $events->listen(UserCreated::class, function (UserCreated $event) {
            //Send confirmation email if requested and account approval is off
            if ($this->isUserNotConfirmed($event->user) && ! $this->needAccountApproval()) {
                $event->user->notify(new VerifyEmail());
            }
            $this->logPasswordHistory($event->user);
        });

        $events->listen(UserProviderRegistered::class, function ($event) {
            \Log::info('User Provider Registered: '.$event->user->name);
        });

        $events->listen(UserConfirmed::class, function ($event) {
            \Log::info('User Confirmed: '.$event->user->name);
        });

        $events->listen(UserPasswordChanged::class, function ($event) {
            $this->logPasswordHistory($event->user);
        });

        $events->listen(PasswordReset::class, function ($event) {
//            $this->logPasswordHistory($event->user);
        });
    }
}
