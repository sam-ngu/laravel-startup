<?php

namespace App\Http\Controllers\Auth;

use App\Events\Models\User\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\Api\V1\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;

// DEPRECATED since 24th Dec: Using Fortify
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;
//
//    /**
//     * Where to redirect users after registration.
//     *
//     * @var string
//     */
//    protected $redirectTo = RouteServiceProvider::HOME;
//
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }


//    /**
//     * @param RegisterRequest $request
//     *
//     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|JsonResponse
//     * @throws \Throwable
//     */
//    public function register(RegisterRequest $request, UserRepository $repository)
//    {
//        abort_unless(config('access.registration'), 404);
//
//        $user = $repository->create(array_merge(
//            $request->only('name', 'email', 'password'),
//            [
//                'roles' => [config('access.users.default_role')],
//            ]
//        ));
//
//        // If the user must confirm their email or their account requires approval,
//        // create the account but don't log them in.
//        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
//            event(new UserRegistered($user));
//            $message = config('access.users.requires_approval') ?
//                __('exceptions.frontend.auth.confirmation.created_pending') :
//                __('exceptions.frontend.auth.confirmation.created_confirm');
//
//            return new JsonResponse([
//                'data' => $message,
//            ]);
//        } else {
//            auth()->login($user);
//
//            event(new UserRegistered($user));
//
//            return new JsonResponse(null, 204);
//        }
//    }
//
//    /**
//     * Show the application registration form.
//     *
//     * @return \Illuminate\View\View
//     */
//    public function showRegistrationForm()
//    {
//        return view('public.auth.register');
//    }
}
