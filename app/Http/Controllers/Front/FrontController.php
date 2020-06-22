<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Public facing routes
*/
class FrontController extends Controller
{
    public function login()
    {
        return view('public.auth.login');
    }

    public function register()
    {
        return view('public.auth.register');
    }

    public function forgotPassword()
    {
        return view('public.auth.passwords.email');
    }

    public function resetPassword()
    {
        return view('public.auth.passwords.reset');
    }


}
