<?php

namespace App\Listeners\User;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserPasswordChanged;
use App\Events\Models\User\UserRegistered;
use App\Models\User;

class UserEventSubscriber
{
    /**
     * @param User $user
     */
    private function logPasswordHistory(User $user) : void
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
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(UserCreated::class, function (UserCreated $event) {
            $this->logPasswordHistory($event->user);
        });

        $events->listen(UserPasswordChanged::class, function ($event) {
            $this->logPasswordHistory($event->user);
        });

        $events->listen(UserRegistered::class, function ($event){
            // TODO: send confirmation email to user
        });

    }
}
