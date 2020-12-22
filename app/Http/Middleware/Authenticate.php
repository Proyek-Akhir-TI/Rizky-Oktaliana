<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        // dd(Auth::guard('admin')->check());
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
        // die('tesat');

        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
