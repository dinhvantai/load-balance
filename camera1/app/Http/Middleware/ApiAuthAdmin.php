<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class ApiAuthAdmin
{

    private $guard = 'api';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::guard($this->guard)->user();
        if (!$user || !$user->is_active) {
            return response(['error' => trans('auth.not_permission')], 401);
        }

        return $next($request);
    }
}
