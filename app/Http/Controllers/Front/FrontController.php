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
}
