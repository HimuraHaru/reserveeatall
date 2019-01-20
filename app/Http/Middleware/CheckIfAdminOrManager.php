<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdminOrManager
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
        if (
            Auth::check() == false ||
            Auth::user()->$role != "ADMIN" &&
            Auth::user()->$role != "MANAGER") {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
