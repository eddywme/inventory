<?php

namespace App\Http\Middleware;

use app\Utility\RoleUtils;
use Closure;

class AccountantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!RoleUtils::isAccountant()) {
            return redirect('/');
        }
        return $next($request);
    }
}
