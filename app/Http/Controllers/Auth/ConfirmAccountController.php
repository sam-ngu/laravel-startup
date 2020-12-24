<?php

namespace App\Http\Controllers\Auth;

use App\Events\Models\User\UserConfirmed;
use App\Exceptions\GeneralJsonException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\User\RegistrationConfirmation;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * Class ConfirmAccountController.  THIS CLASS IS DEPRECATED, handled by laravel auth
 */
class ConfirmAccountController extends Controller
{


//    /**
//     * @param $token -- the confirmation code passed from api
//     *
//     * @return mixed
//     * @throws \App\Exceptions\GeneralException
//     */
//    public function confirm(Request $request, $token, UserRepository $repository)
//    {
//        // find user by confirmationCode
//        $user = User::query()->where('confirmation_code', '=', $token)->first();
//
//        $codeIsInvalid = $user->confirmation_code !== $token && ! ($user instanceof User);
//
//        throw_if($codeIsInvalid, GeneralJsonException::class, 'Confirmation Code is invalid');
//
//        throw_if($user->confirmed === 1, GeneralJsonException::class, 'Your account is already confirmed.');
//
//        $user->confirmed = 1;
//        throw_if($user->save(), GeneralJsonException::class, 'Unable to confirm user');
//
//        event(new UserConfirmed($user));
//
//        return new JsonResponse([
//            'data' => 'confirmed',
//        ]);
//    }

//    /**
//     * @param $uuid
//     *
//     * @return mixed
//     * @throws \App\Exceptions\GeneralException
//     */
//    public function sendConfirmationEmail($uuid)
//    {
//        $user = User::query()->where('uuid', '=', $uuid)->first();
//
//        throw_if(! ($user instanceof User), GeneralJsonException::class, 'User not found');
//
//        if ($user->isConfirmed()) {
//            return new JsonResponse([
//                'data' => 'User already confirmed',
//            ]);
//        }
//
//        $user->notify(new RegistrationConfirmation($user->confirmation_code));
//
//        return new JsonResponse([
//            'data' => 'succsss',
//        ]);
//    }
}
