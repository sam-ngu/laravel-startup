<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\UserLoggedIn;
use App\Exceptions\GeneralException;
use App\Exceptions\GeneralJsonException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Socialite\SocialiteService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

/**
 * Public facing routes
*/
class SocialLoginController extends Controller
{
    /**
     * @param Request $request
     * @param $provider
     *
     * @throws GeneralException
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function login(Request $request, $provider, SocialiteService $socialiteService)
    {
        // There's a high probability something will go wrong
        $user = null;

        // If the provider is not an acceptable third party than kick back
        throw_if(
            ! in_array($provider, $socialiteService->getAcceptedProviders()),
            GeneralJsonException::class,
            'Not an acceptable provider: ' . $provider
        );

        /*
         * The first time this is hit, request is empty
         * It's redirected to the provider and then back here, where request is populated
         * So it then continues creating the user
         */
        if (! $request->all()) {
            return $this->getAuthorizationFirst($provider);
        }

        // Create the user if this is a new social account or find the one that is already there.
        try {
            $user = $socialiteService->findOrCreateProvider($this->getProviderUser($provider), $provider);
        } catch (GeneralException $e) {
            throw new GeneralJsonException($e->getMessage());
        }

        throw_if(is_null($user), GeneralJsonException::class, __('exceptions.frontend.auth.unknown'));

        // Check to see if they are active.
        throw_if(! $user->isActive(), GeneralJsonException::class, __('exceptions.frontend.auth.deactivated'));

        // Account approval is on
        throw_if($user->isPending(), GeneralJsonException::class, __('exceptions.frontend.auth.confirmation.pending'));

        // User has been successfully created or already exists
        auth()->login($user, true);

        // Set session variable so we know which provider user is logged in as, if ever needed
        session([config('access.socialite_session_name') => $provider]);

        event(new UserLoggedIn(auth()->user()));

        return (new UserResource(auth()->user()))->response();
    }

    /**
     * @param  $provider
     *
     * @return mixed
     */
    protected function getAuthorizationFirst($provider)
    {
        $socialite = Socialite::driver($provider);
        $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");
        $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
        $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");

        if ($scopes) {
            $socialite->scopes($scopes);
        }

        if ($with) {
            $socialite->with($with);
        }

        if ($fields) {
            $socialite->fields($fields);
        }

        return $socialite->redirect();
    }

    /**
     * @param $provider
     *
     * @return mixed
     */
    protected function getProviderUser($provider)
    {
        return Socialite::driver($provider)->user();
    }
}
