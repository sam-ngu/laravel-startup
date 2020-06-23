<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\User\UserNeedsConfirmation;
use App\Repositories\Api\V1\UserRepository;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{


    /**
     * @param $token
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirm($token, UserRepository $repository)
    {
        $repository->confirm($token);

        return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
    }

    /**
     * @param $uuid
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function sendConfirmationEmail($uuid)
    {
        $user = $this->user->findByUuid($uuid);

        if ($user->isConfirmed()) {
            return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.resent'));
    }
}
