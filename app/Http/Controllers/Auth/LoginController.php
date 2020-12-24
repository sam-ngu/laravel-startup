<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\GeneralJsonException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{

//    use AuthenticatesUsers;

//    /**
//     * Where to redirect users after login.
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
//        $this->middleware('guest')->except(['logout', 'loginAs', 'logoutAs']);
//    }
//
//    /**
//     * Show the application's login form.
//     *
//     * @return \Illuminate\View\View
//     */
//    public function showLoginForm()
//    {
//        return view('public.auth.login');
//    }
//
//    /**
//     * Send the response after the user was authenticated.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    protected function sendLoginResponse(Request $request)
//    {
//        $request->session()->regenerate();
//
//        $this->clearLoginAttempts($request);
//
//        if ($response = $this->authenticated($request, $this->guard()->user())) {
//            return $response;
//        }
//
//        return $request->wantsJson()
//            ? new Response([
//                'data' => [
//                    'redirect' => '/app',
//                ],
//            ], 200)
//            : redirect()->intended($this->redirectPath());
//    }
//
//    public function logout(Request $request, TokenRepository $tokenRepository)
//    {
//        // TODO: complete this invalidate current logged in user
//        if (auth()->check()) {
//            $tokenRepository->revokeAccessToken();
//            auth()->user()->token()->revoke();
//
//            return new JsonResponse([
//                'data' => 'success',
//            ]);
//        }
//
//        return new JsonResponse([
//            'error' => 'Logout Unsuccessful. Something went wrong.',
//        ], 500);
//    }

    public function loginAs(Request $request, User $user)
    {
        // Overwrite who we're logging in as, if we're already logged in as someone else.
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Let's not try to login as ourselves.
            if ($request->user()->id === $user->id || session()->get('admin_user_id') == $user->id) {
                throw new GeneralJsonException('Do not try to login as yourself.');
            }

            // Overwrite temp user ID.
            session(['temp_user_id' => $user->id]);

            // Login.
            auth()->guard()->setUser($user);

//            auth()->loginUsingId($user->id);

            // Redirect.
            return redirect()->route('home');
        }

        Auth::flushTempSession();

        // Won't break, but don't let them "Login As" themselves
        if ($request->user()->id === $user->id) {
            throw new GeneralJsonException('Do not try to login as yourself.');
        }

        // Add new session variables
        session(['admin_user_id' => $request->user()->id]);
        session(['admin_user_name' => $request->user()->name]);
        session(['temp_user_id' => $user->id]);

        // Login user
        auth('web')->loginUsingId($user->id);

        if ($request->wantsJson()) {
            return new JsonResponse([
                'data' => 'success',
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->route('login');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            // Re-login admin
//            auth()->setUser(User::query()->find((int) $admin_id));
            auth('web')->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('admin');
        } else {
            app()->make(Auth::class)->flushTempSession();

            // Otherwise logout and redirect to login
            auth('web')->logout();

            return redirect()->route('login');
        }
    }
}
