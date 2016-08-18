<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        if (! $request->user()->hasRole($role)) {
            abort(401);
        }

        return $next($request);
    }
}
