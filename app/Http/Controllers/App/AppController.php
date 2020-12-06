<?php

namespace App\Http\Controllers\App;

class AppController
{
    public function dashboard()
    {
        return view('app.index');
    }

    public function admin()
    {
        return view('admin.index');
    }
}
