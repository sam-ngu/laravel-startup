<?php


namespace App\Services\Socialite;

use App\Events\Models\User\UserProviderRegistered;
use App\Exceptions\GeneralException;
use App\Models\SocialAccount;
use App\Models\User;
use App\Repositories\Api\V1\UserRepository;

class SocialiteService
{
    /**
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider)
    {
        // User email may not provided.
        $email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = User::query()->where('email', '=', $email)->first();

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (! $user) {
            // Registration is not enabled
            throw_if(! config('access.registration'), GeneralException::class, __('exceptions.frontend.auth.registration_disabled'));

            // Get users first name and last name from their full name
            [$firstName, $lastName] = $this->getNameParts($data->getName());

            $user = app(UserRepository::class)->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'active' => 1,
                'confirmed' => 1,
                'password' => null,
                'avatar_type' => $provider,
            ]);

            event(new UserProviderRegistered($user));
        }

        // See if the user has logged in with this social account before
        if (! $user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialAccount([
                'provider' => $provider,
                'provider_id' => $data->id,
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]);

            $user->avatar_type = $provider;
            $user->update();
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $fullName
     *
     * @return array
     */
    protected function getNameParts($fullName)
    {
        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);

        if (empty($parts)) {
            $firstName = null;
            $lastName = null;
        }

        if (! empty($parts) && $size == 1) {
            $firstName = $parts[0];
            $lastName = null;
        }

        if (! empty($parts) && $size >= 2) {
            $firstName = $parts[0];
            $lastName = $parts[1];
        }

        return [$firstName, $lastName];
    }

    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function getAcceptedProviders()
    {
        return array_keys(config('services.socialite'));
    }
}
