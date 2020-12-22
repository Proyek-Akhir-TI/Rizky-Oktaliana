<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($role == Auth::guard('admin')->user()->hak_akses) {
            return $next($request);
        } else {
            $role = Auth::guard('admin')->user()->hak_akses;
            
            return redirect('/' . $role . '/dashboard');
        }
    }
}
